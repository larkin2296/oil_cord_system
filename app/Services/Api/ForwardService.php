<?php
namespace App\Services\Api;
use App\Traits\ResultTrait;
use App\Traits\ExceptionTrait;
use App\Traits\ServiceTrait;
use App\Traits\CodeTrait;
use App\Traits\UserTrait;
use App\Services\Service;
use App\Traits\CatSupplyTrait;
use Exception;
use DB;
use Hashids\Math;
use Redis;
use App\User;
use JWTAuth;
use Carbon\Carbon;
use Excel;
Class ForwardService extends Service
{
    protected $build;
    use ResultTrait, ExceptionTrait, ServiceTrait, CodeTrait, UserTrait, CatSupplyTrait;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 直充列表
     * return [type] [deception]
     */
    public function index()
    {
        try{
            $exception = DB::transaction(function(){

                /*用户信息*/
                $user = $this->jwtUser();
                /*卡密列表*/
                $data['cam'] = $this->supplyCamRepo->model()::where('user_id',$user->id)
                    ->where('status',4)
                    ->where('forward_status',getCommonCheckValue(false))
                    ->get()->map(function($item,$key){
                        return [
                           'id' => $item->id,
                           'cam_name' => $item->cam_name,
                           'cam_other_name' => $item->cam_other_name,
                           'denomination' => $this->handleDenomination($item->denomination),
                           'real_money'=>  (int)$this->handleDenomination($item->denomination) * $item->discount,
                           'status' => $this->checkCamStatus($item->status),
                           'forward_status' => $this->checkForWardStatus($item->forward_status),
                        ];
                    });

                /*直充列表*/
                $data['forward'] = $this->supplySingleRepo->model()::where('user_id',$user->id)
                    ->where('supply_status',getCommonCheckValue(true))
                    ->where('forward_status',getCommonCheckValue(false))
                    ->where('status',getCommonCheckValue(true))->get()
                    ->map(function($item,$key){
                    return [
                        'id' => $item->id,
                        'supply_single_number' => $item->supply_single_number,
                        'oil_number' => $item->oil_number,
                        'already_card' => $item->already_card,
                        'real_money'=>  (int)$item->already_card * $item->discount,
                        'supply_status' => $this->checkSupplyStatus($item->supply_status),
                        'forward_status' => $this->checkForWardStatus($item->forward_status),
                        'suoil_id' => $item->suoil_id,
                        'status' => $item->status,
                    ];
                });

                return $this->results = array_merge([
                    'code' => '200',
                    'message' => '列表显示成功',
                    'data' => $data,
                ]);
            });

        }catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results,$exception);
    }

    /**
     * 提现金额
     * return [type] [deception]
     */
    public function edit()
    {
        try{
            $exception = DB::transaction(function(){
                $res = request()->post('list','');
                $cam_id = $res['cam'];
                $forward_id = $res['forward'];

                $cam = [];
                foreach( $cam_id as $key => $item ) {

                    $cam[] = $this->supplyCamRepo->model()::where('id',$item['id'])
                        ->with(['denomination'])
                        ->get()
                        ->first()
                        ->toArray();
                }
                if($cam == []){
                    $sum[0] = 0;
                }else{
                    foreach($cam as $k => $v) {
                        $sum[$k] = $v['denomination']['denomination'];
                    }
                }

                /* 卡密金额 */
                $cam_sum = array_sum($sum);

                $forward = [];

                foreach ($forward_id as $is => $value){
                    $forward[] = $this->supplySingleRepo->model()::where('id',$value['id'])
                        ->get()
                        ->first()
                        ->toArray();
                }
                if($forward == []){
                    $sums[0] = 0;
                }else{
                    foreach($forward as $ke => $val ){
                        $sums[$ke] = $val['already_card'] * $val['discount'];
                    }
                }

                /* 直充金额 */
                $forward_sum = array_sum($sums);

                $data = $cam_sum+$forward_sum;

                return $this->results = array_merge([
                   'code' => '200',
                   'message' => '金额显示成功',
                   'data' => $data,
                ]);
            });

        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results,$exception);
    }
    /**
     * 提现
     * return [type] [deception]
     */
    public function store()
    {
        try{
            $exception = DB::transaction(function(){
                $res = request()->post('list','');
                $cam_id = [];
                $forward_id = [];
                foreach($res['cam'] as $val){
                    $cam_id[] = $val['id'];
                }
                foreach($res['forward'] as $value){
                    $forward_id[] = $value['id'];
                }
                $sum = $res['money'];
                /*提现单号*/
                $forwardNumber = $this->getForwardNumber($this->jwtUser());

                $arr = [
                    'forward_number' => $forwardNumber,
                    'status' => 3,
                    'money' => $sum,
                    'user_id' => $this->jwtUser()->id,
                ];

                if( $forwards = $this->forwardRepo->create($arr) ) {
                    /*关联卡密提现*/
                    event(new \App\Events\Accommed\RelationPresentForward($forwards,$cam_id));

                    /*关联直充提现*/
                    event(new \App\Events\Accommed\RelationForward($forwards,$forward_id));

                    /* 更改状态提现中 */
                    event(new \App\Events\Accommed\Forward($cam_id,$forward_id));

                } else {
                    throw new Exception('提现失败，请确认参数');
                }

                return $this->results = array_merge([
                   'code' => '200',
                   'message' => '提现申请成功,等待管理员审核',
                   'data' => collect([]),
                ]);

            });

        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results,$exception);
    }

    /**
     * 提现记录
     * return [type] [deception]
     */
    public function presentRecord()
    {
        try{
            /*用户信息*/
            $user = $this->jwtUser();

           $data =  $this->forwardRepo->findByField(['user_id' => $user->id])->map(function($item, $key){
               return [
                   'id' => $item->id,
                   'forward_number' => $item->forward_number,
                   'money' => $item->money,
                   'status' => $this->checkForWardStatus($item->status),
                   'created_at' => $item->created_at->format('Y-m-d H:i:s'),
               ];
           });

           return ['code' => '200', 'message' => '显示成功', 'data' => $data];

        } catch(Exception $e) {
            dd($e);
        }
    }


}