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
use Redis;
use App\User;
use JWTAuth;
use Carbon\Carbon;
use Excel;
Class CatSupplyservice extends Service{
    protected $build;
    use ResultTrait, ExceptionTrait, ServiceTrait, CodeTrait, UserTrait,CatSupplyTrait;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 卡密供货
     * return [type][deception]
     */
    public function create()
    {
        try{
            $exception = DB::transaction( function() {

                $res = request()->post('list','');
                $cam = $res['cam'];

                $now = new Carbon();
                /*用户信息*/
                $user = $this->jwtUser();
                /*处理面额*/
                $platform_money_id = $this->platformMoneyRepo->findWhere(['denomination'=>$res['money_id']])->map(function($item,$key){
                    return [
                       'id'=>$item['id']
                    ];
                })->first();

                /*处理平台*/
                $platform_id = $this->platformRepo->findWhere(['platform_name'=>$res['platform_id']])->map(function($item,$key){
                    return [
                        'id'=>$item['id']
                    ];
                })->first();

                /*卡密信息*/
                foreach( $cam as $item ) {
                    $arr = [
                        'cam_name' => $item['cam_name'],
                        'cam_other_name' => $item['cam_other_name'],
                        'denomination' => $platform_money_id,
                        'platform_id' => $platform_id,
                        'user_id' => $user->id,
                    ];
                    $data = $this->supplyCamRepo->create($arr);
                }

               return $this->results = array_merge([
                  'code' => '200',
                  'message' => '卡密供货成功',
                  'data' => $data,
               ]);
            });

        }catch(Exception $e){
           dd($e);
        }
        return array_merge($this->results,$exception);
    }

    /*处理附件*/
    public function checkAttachments()
    {
        try{
            $exception = DB::transaction(function(){
                /*附件id*/
               $attachmentIds = request()->attachment_id;

               /*验证附件关系*/

                return $this->results = array_merge([
                   'code' => '200',
                   'message' => '处理附件关系成功',
                   'data' => collect([]),
                ]);
            });
        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results,$exception);
    }
    /**
     * 导入模版
     * return [type][deception]
     */
    public function importExcelData()
    {
        /*设置请求时间*/
        set_time_limit(0);
        try{
            /*获取上传路径*/
            $path = request()->post('path',[]);

            foreach($path as $key => $item) {
                $filePath = 'storage/app/' . $item;
                $exception = Excel::load($filePath, function ($reader) {
                    /*金额*/
                    $platform_money = request()->get('money_id', '');
                    /*平台*/
                    $platform_id = request()->post('platform_id', '');
                    $reader = $reader->getSheet(0);
                    $data = $reader->toArray();
                    /*用户信息*/
                    $user = $this->jwtUser();
                    /*格式数据*/
                    unset($data[0]);

                    foreach( $data as $k=>$v ){
                    /*清除标题*/
                    unset($v[2]);
                    $arr = [
                        'cam_name' => $v[0],
                        'cam_other_name' => $v[1],
                        'denomination' => $platform_money,
                        'platform_id' => $platform_id,
                        'user_id' => $user->id,
                    ];
                $attachmentsIds = request()->post('attachment_id',[]);
                    if( $info =  $this->supplyCamRepo->create($arr) ) {
                    /*验证附件*/
                    $attachmentId = $this->attachmentRepo->listByIds($attachmentsIds,$user->id)->keyBy('id')->keys()->toArray();
                    /*处理关系*/
                    $info->attachments()->attach($attachmentId);
                    } else {
                        throw new Exception('导入卡密数据失败,请数据检查格式','2');
                    }
                }
                return $this->results = array_merge([
                    'code' => '200' ,
                    'message' => '导入卡密成功',
                    'data' => $data,
                ]);
                });

            }
        } catch(Exception $e) {
            dd($e);
        }
        return array_merge($this->results,[]);
    }

    /**
     * 内容回显
     * return [type][deception]
     */
    public function importExcelShow()
    {
        $list = request()->post('list','');
        /*设置时间*/
        set_time_limit(0);

        $filePath = 'storage/app/'.iconv('UTF-8', 'GBK', $list);

        $data = Excel::load($filePath, function($reader) {

            $reader = $reader->getSheet(0)->toArray();
            return $reader;
        });

        $array = $data->getSheet(0)->toArray();

        foreach($array as $key=>&$val){
            if($key > 0){
                $arr[$key-1]['cam_name'] = $val[0];
                $arr[$key-1]['cam_other_name'] = $val[1];
            }
        }
         return ['code' => '200' ,'message' => '显示成功','data' => $arr];

    }

    /**
     * 导出模版
     * return [type][deception]
     */
    public function export()
    {
        Excel::create('cam',function($excel){
            $excel->sheet('Sheetname',function($sheet) {
                $sheet->rows([
                        array('字段名称1','字段名称2-可为空','备注 ：卡密为纯数字的请按照模版格式将excel单元格式选择为文本格式'),
                        array('110501804252467010327','110501804252467010328'),
                        array('110501804252467010329','110501804252467010338'),
                    ]
                );

            })->export('xls');
        });
    }

    /**
     * 平台金额
     * return [type][deception]
     */
    public function show()
    {
        try{
            $exception = DB::transaction(function(){
                /*获取平台*/
                $platform = $this->platformRepo->all();
                /*获取面额*/
                $platformMoney = $this->platformMoneyRepo->all();

                $data = [
                    'platform' => $platform->toArray() ?? '',
                    'money' => $platformMoney->toArray() ?? '',
                ];
                return ['code' => 200, 'message' => '显示成功', 'data' => $data];

            });
        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results,$exception);
    }

    /**
     * 供应商油卡
     * return [type][deception]
     */
    public function relationshipSupply()
    {
        /* 获取供应商信息 */
        try{
            $exception = DB::transaction(function() {

                $user = $this->jwtUser();
                /*供应商是否第一次获取油卡*/
                if( $info = $this->oilSupplyRepo->findWhere(['user_id' => $user->id])->count() > 0 ) {
                    /* 油卡信息 */
                    $data=  $this->oilSupplyRepo->model()::where('user_id',$user->id)
                        ->with('hasManyOilCard')->get()
                        ->map(function($item,$key){
                            $arr = $item->hasManyOilCard;
                            return [
                                'id' => $arr[0]['id'],
                                'user_id' => $arr[0]['user_id'],
                                'oil_card_code' => $arr[0]['oil_card_code'],
                                'serial_number' => $arr[0]['serial_number'],
                                'card_status' => $arr[0]['card_status'],
                                'status_supply' => $arr[0]['status_supply'],
                                'total_money' => $arr[0]['total_money'],
                                'is_longtrem' => $arr[0]['is_longtrem'],
                                'recharge_num' => $arr[0]['recharge_num'],
                                'recharge_today_num' => $arr[0]['recharge_today_num'],
                                'last_recharge_time' => $arr[0]['last_recharge_time'],
                            ];
                        });

                    return ['code' => 200, 'message' => '获取油卡信息成功','data' => $data];
                } else {
                    /*获取油卡张数*/
                    $limit = $this->userRepo->find($user->id)->several ?? getCommonCheck(true);
                    /* 获取油卡 */
                    $arr = $this->oilcardRepo->model()::where('status_supply',getCommonCheckValue(false))
                        ->limit($limit)->get()->map(function($item,$key){
                            return [
                                'id' => $item->id,
                                'user_id' => $item->user_id,
                                'oil_card_code' => $item->oil_card_code,
                                'serial_number' => $item->serial_number,
                                'card_status' => $item->card_status,
                                'status_supply' => $item->status_supply,
                                'total_money' => $item->total_money,
                                'is_longtrem' => $item->is_longtrem,
                                'recharge_num' => $item->recharge_num,
                                'recharge_today_num' => $item->recharge_today_num,
                                'last_recharge_time' => $item->last_recharge_time,
                            ];
                        });
                    if( $arr ) {
                        foreach( $arr as $item ) {
                            /* 油卡使用状态 */
                            $supplyStatus =  $this->oilcardRepo->update(['status_supply' => getCommonCheckValue(true)],$item['id']);

                            $arrNew = [
                                'user_id' => $user->id,
                                'oil_id' => $item['id']
                            ];

                            $patient =  $this->oilSupplyRepo->create($arrNew);

                            if( $supplyStatus && $patient ) {
                            } else {
                                throw new Exception('获取油卡失败，请联系管理员',2);
                            }
                        }
                    } else {
                        throw new Exception('当前暂无油卡,请稍后再试',2);
                    }

                    return ['code' => 200, 'message' => '获取油卡信息成功','data' => $arr];
                }
            });
        } catch(Exception $e){
            dd($e);
        }
       return array_merge($this->results,$exception);
    }

    /**
     * 直充供货
     * return [type][deception]
     */
    public function charge()
    {
        try{
            $exception = DB::transaction(function() {
                /*用户信息*/
                $user = $this->jwtUser();
                /*充值油卡*/
                $res = request()->post('list','');
                $id = $res['id'];

                $oilInfo = $this->oilSupplyRepo->model()::where('oil_id',$id)
                    ->with('hasManyOilCard')->first();

                /*冗余油卡*/
                $oilCard =  $this->oilcardRepo->find($id);

                $arr = [
                    'suoil_id' => $oilInfo->id,
                    'already_card' => $res['price'],
                    'oil_number' => $oilCard->oil_card_code,
                    'user_id' => $user->id,
                    'end_time' => $res['recharge_time'],
                    'direct_id' => $res['id_hash'],
                    'status' => getCommonCheckValue(true),
                    'supply_status' => getCommonCheckValue(false),
                ];

                $supply = $this->supplySingleRepo->create($arr);
                /*供应单号*/
                $supplySingleNumber = $this->generateSupplyNumber($supply,$user);

                $data = $this->supplySingleRepo->update(['supply_single_number' => $supplySingleNumber],$supply->id);

                if( $data ) {
                } else {
                    throw new Exception('直充失败','2');
                }
                return ['code' => 200, 'message' => '直充成功', 'data' => $data];
            });

        } catch(Exception $e){
            dd($e);
        }
            return array_merge($this->results,$exception);
    }

}