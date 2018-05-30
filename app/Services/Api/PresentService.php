<?php
namespace App\Services\Api;

use App\Traits\ResultTrait;
use App\Traits\ExceptionTrait;
use App\Traits\ServiceTrait;
use App\Traits\CodeTrait;
use App\Traits\CatSupplyTrait;
use App\Traits\UserTrait;
use App\Services\Service;
use Exception;
use DB;
use App\Repositories\Models\User;
use PhpRedis;
use HskyZhou\NineOrange\NineOrange;

Class PresentService extends Service{

    use ServiceTrait, ResultTrait, ExceptionTrait, CodeTrait, CatSupplyTrait, UserTrait;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 提现管理列表
     * return [type] [deception]
     */
    public function index()
    {
        try{
            $exception = DB::transaction(function() {

                /*验证权限*/
                $this->checkSupplyAdminJurisdiction();

               $data = $this->presentSettingRepo->all();

                #TODO 提现列表数据 读取展示  状态 金额
                return $this->results = array_merge([
                   'code' => '200',
                   'message' => '提现显示成功',
                   'data' => $data,
                ]);
            });
        }catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results,$exception);
    }

    /**
     * 提现管理金额修改
     * return [type] [deception]
     */
    public function update()
    {

        try{
            $exception = DB::transaction(function() {

                /*验证权限*/
                $this->checkSupplyAdminJurisdiction();

                $request = $this->presentSettingRepo->all();
                $post = request()->post('list','');
                foreach($post as $val){
                    switch($val['conf_code']){
                        case 'upper_money':
                            $arr['upper_money'] = $val['status'];
                            break;
                        case 'lower_money':
                            $arr['lower_money'] = $val['status'];
                            break;
                        case 'deductions':
                            $arr['deductions'] = $val['status'];
                            break;
                        case 'proportion':
                            $arr['proportion'] = $val['status'];
                            break;
                        case 'greater_money':
                            $arr['greater_money'] = $val['status'];
                            break;
                        default:
                            break;
                    }
                }
                $arr = [
                    'status' => request()->post('status',''),
                ];

                if( $request->isNotEmpty() ) {

                    $data = $this->presentSettingRepo->update($arr,config('back.global.status.order.wait'));
                } else {

                    $data = $this->presentSettingRepo->create($arr);
                }

                return $this->results = array_merge([
                   'code' => '200',
                   'message' => '修改成功',
                   'data' => $data,
                ]);
            });
        }catch(Exception $e) {
            dd($e);
        }
        return array_merge($this->results,$exception);
    }
}