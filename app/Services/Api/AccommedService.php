<?php
namespace App\Services\Api;
use App\Traits\ResultTrait;
use App\Traits\ExceptionTrait;
use App\Traits\ServiceTrait;
use App\Traits\CodeTrait;
use App\Traits\UserTrait;
use App\Traits\CatSupplyTrait;
use App\Services\Service;
use Exception;
use DB;
use Redis;
use App\User;
use JWTAuth;
class AccommedService extends Service {
    use ServiceTrait,ResultTrait,ExceptionTrait, CodeTrait,UserTrait,CatSupplyTrait;
    protected $builder;
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * 卡密供货查询
     * return [type] [deception]
     */
    public function index()
    {
        try{
            $exception = DB::transaction(function() {

                /*用户信息*/
                $user = $this->jwtUser();
                
		$field= [
                    'denomination' => '=',
                    'platform_id' => '=',
                    'status' => '=',
                    'success_time' => 'like',
                ];
                $fieldWhere =  $this->searchArray($field);

                $where = array_merge($fieldWhere,[
                    'user_id' => $user->id,
                ]);
                $post = request()->post('list','');
		
                if(isset($post['goods_type']) && $post['goods_type'] != ''){
                    $where['platform_id'] = $this->get_platform_id($post['goods_type']);
                }
                if(isset($post['card_price']) && $post['card_price'] != ''){
                    $where['denomination'] = $this->get_denomination_id($post['card_price']);
                }
                isset($post['status']) ? $where['status'] = $post['status'] : '';
                isset($post['time_end']) ? $where['end'] = ['created_at','<',$post['time_end']] : '';
                isset($post['time_start']) ? $where['start'] = ['created_at','>',$post['time_start']] : '';
                $data =  $this->supplyCamRepo->orderBy('created_at','desc')->findWhere($where)->map(function($item,$key){
                   //return $item;
                    return [
                        'id' => $item['id'],
                        'cam_name' => $item['cam_name'],
                        'cam_other_name' => $item['cam_other_name'],
                        'status' => $item['status'],
                        'denomination' => $this->handleDenomination($item['denomination']),
                        'platform_id' => $this->handlePlatform($item['platform_id']),
                        'remark' => $item['remark'],
                        'discount' => $item['discount'],
                        'actual_money' => $item['actual_money'],
                        'success_time' => $item['success_time'],
                        'supplier_time' => $item['created_at']->format('Y-m-d H:i:s'),
                    ];

               })->all();

                if( $data ) {
                } else {
                    return ['code' => '400', 'message' => '查询成功', 'data' => ''];
                }

                return  [
			'code' => '200', 
			'message' => '查询成功', 
			'data' => $data
		];
            });
        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results, $exception);
    }

    /**
     * 卡密供货详情
     * return [type][deception]
     */
    public function show($id)
    {
        try{
            $exception = DB::transaction(function() use ($id){

                #TODO 卡密状态显示
                $data = $this->supplyCamRepo->model()::where('id',$id)
                    ->with(['denomination','platform'])->get();

                return ['code' => '200', 'message' => '详情显示成功', 'data' => $data];

            });
        }catch(Exception $e){
                dd($e);
        }
        return array_merge($this->results, $exception);
    }

    /**
     * 直充查询
     * return [type][deception]
     */
    public function chargeQuery()
    {
        /*用户信息*/
        $user = $this->jwtUser();

        $field = [
            'oil_number' => 'like',
            'status' => '=',
            'end_time' => 'like',
        ];
        $fieldWhere = $this->searchArray($field);
        #TODO 用户 供应商拥有的油卡  供应单的时间

        $where = array_merge($fieldWhere,[
           'user_id' => $user->id,
        ]);
        $post = request()->post('list','');

        isset($post['supply_status']) ? $where['supply_status'] = $post['supply_status'] : '';
        isset($post['oil_number']) ? $where['oil_number'] = ['oil_number','like','%'.$post['supply_status'].'%'] : '';
        isset($post['time_end']) ? $where['created_at'] = ['created_at','<',$post['time_end'].'23:59:59'] : '';
        isset($post['time_start']) ? $where['created_at'] = ['created_at','>',$post['time_start'].'00:00:00'] : '';


        $data = $this->supplySingleRepo->orderBy('created_at','desc')->findWhere($where)->map(function($item,$key){
            //return $item;
            return [
                'id' => $item->id,
                'supply_single_number' => $item->supply_single_number,
                'oil_number' => $item->oil_number,
                'end_time' => $item->end_time,
                'created_at' => $item->created_at->format("Y-m-d H:i:s"),
                'already_card' => $item->already_card,
                'direct_id' => $item->direct_id,
                'supply_status' => $this->checkSupplyStatus($item->supply_status),
            ];
        });

        return ['code' => 200, 'message' => '直充查询成功', 'data' => $data];

    }

    /**
     * 直充详情查询
     * return [type][deception]
     */
    public function attachmentCharge($id)
    {
        try{
            $exception = DB::transaction(function() use ($id){
                $data = $this->supplySingleRepo->model()::where('id',$id)
                    ->with('attachmentCharge')
                    ->get()->map(function($item,$key){

                        return [
                          'id' => $item->id,
                          'supply_single_number' => $item->supply_single_number,
                          'oil_number' => $item->oil_number,
                          'supply_status' => $this->checkSupplyStatus($item->supply_status),
                          'notes' => $item->notes,
                          'end_time' => $item->end_time,
                          'already_card' => $item->already_card,
                          'direct_id' => route('common.attach.show',[$item->attachmentCharge]),
                          'status' => $item->status,

                        ];
                    });

                if( $data ) {
                }else {
                    throw new Exception('直充详情列表读取失败','2');
                }
                return $this->results = array_merge([
                   'code' => 200,
                   'message' => '直充详情展示成功',
                   'data' => $data,
                ]);
            });
        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results,$exception);
    }

}
