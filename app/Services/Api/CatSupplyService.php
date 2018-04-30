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

                $now = new Carbon();

                #TODO 供应单号表  卡密表
                $cam[] = request()->post('cam',[]);

                /*用户信息*/
                $user = $this->jwtUser();

                /*面额*/
                $platform_money_id = request()->post('money_id','');

                /*平台*/
                $platform_id = request()->post('platform_id','');

                /*卡密信息*/

                foreach( $cam as $item ) {

                        $arr = [
                            'cam_name' => $item['cam_name'],
                            'cam_other_name' => $item['cam_other_name'],
                            'denomination' => $platform_money_id,
                            'platform_id' => $platform_id,
                            'user_id' => $user->id,
                       ];

                    $info = $this->supplyCamRepo->create($arr);
                }

                /*供应单号*/
               // $supplySingleNumber = $this->generateSupplyNumber($supply,$user);

                return ['code' => 200, 'message' => '显示成功', 'data' => $info];

            });

        }catch(EXception $e){

        }
        return array_merge($this->results,$exception);
    }

    /**
     * 导入模版
     * return [type][deception]
     */
    public function importExcelData()
    {
        set_time_limit(0);

        $filePath = 'storage/attachments/'.iconv('UTF-8', 'GBK', 'cam').'.xlsx';

        Excel::load($filePath, function($reader) {

            $platform_money = request()->get('money_id','');
;
            $platform_id = request()->post('platform_id','');

            $reader = $reader->getSheet(0);

            $data = $reader->toArray();

            /*用户信息*/
            $user = $this->jwtUser();

            unset($data[0]);

            foreach( $data as $k=>$v ){
                /* 清除标题 */
                unset($v[2]);

                $arr = [
                    'cam_name' => $v[0],
                    'cam_other_name' => $v[1],
                    'denomination' => $platform_money,
                    'platform_id' => $platform_id,
                    'user_id' => $user->id,
                ];

              if( $info =  $this->supplyCamRepo->create($arr) ) {

              } else {
                  throw new Exception('导入卡密数据失败,请数据检查格式','2');
              }
            }

            return ['code' => '200' ,'message' => '导入卡密成功'];


        });

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

            })->export('xlsx');
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
        $user = $this->jwtUser();
    }



    /**
     * 直充供货
     * return [type][deception]
     */
    public function charge()
    {
        #TODO 先获取油卡 三张油卡 随机充值
    }

}
