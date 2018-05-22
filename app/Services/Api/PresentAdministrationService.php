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
use App\Repositories\Models\User;
use PhpRedis;
use HskyZhou\NineOrange\NineOrange;

class PresentAdministrationService extends Service {

    use ServiceTrait,ResultTrait,ExceptionTrait, CodeTrait, UserTrait, CatSupplyTrait;

    protected $builder;
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * 提现管理列表
     * @param  string data
     * @return [type] [description]
     */
    public function index()
    {
        try{
           $exception = DB::transaction(function() {
              /*验证身份*/
              $userRole = $this->checkAdminUser();

              $field = [
                'user_id' => '=',
                'created_at' => 'like',
                'status' => '=',
              ];

              $where = $this->searchArray($field);

              $data = $this->forwardRepo->findWhere($where)->map(function($item, $key){
                 return [
                    'id' => $item->id,
                     'user' => $this->getIdUserInfo($item->user_id)->truename ?? $this->getIdUserInfo($item->user_id)->mobile,
                     'user_id' => $item->user_id,
                     'forward_number' => $item->forward_number,
                     'money' => $item->money,
                     'status' => $this->checkForWardStatus($item->status),
                     'created_at' => $item->created_at->format("Y-m-d") ?: '',
                 ];
              });

              return $this->results = array_merge([
                 'code' => '200',
                 'message' => '查询提现记录成功',
                 'data' => $data,
              ]);
          });


      } catch(Exception $e ) {
          dd($e);
      }
      return array_merge($this->results,$exception);
    }

    /**
     * 提现审核
     * @param  string data
     * @return [type] [description]
     */
    public function update()
    {
        try{
            $exception = DB::transaction(function(){

                /*验证身份*/
                $this->checkAdminUser();

                $id = request()->id;

                if( request()->post('status') == config('back.global.status.order.wait') ) {

                    $status = $this->forwardRepo->update(['status'=>config('back.global.status.order.wait')],$id);
                } else if( request()->post('status') == config('back.global.status.order.doing') ) {

                    $status = $this->forwardRepo->update(['status'=>config('back.global.status.order.doing')],$id);
                }

                return $this->results = array_merge([
                    'code' => '200',
                    'message' => '审核提现记录成功',
                    'data' => $status,
                ]);
            });


        } catch(Exception $e ) {
            dd($e);
        }
        return array_merge($this->results,$exception);
    }
}