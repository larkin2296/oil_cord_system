<?php
namespace App\Services\Api;

use App\Traits\ResultTrait;
use App\Traits\ExceptionTrait;
use App\Traits\ServiceTrait;
use App\Traits\CodeTrait;
use App\Services\Service;
use Exception;
use DB;
use Redis;
use App\User;
use JWTAuth;


class LoginService extends Service {
   use ServiceTrait,ResultTrait,ExceptionTrait, CodeTrait;

    protected $builder;
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 登陆
     * @return [type] [description]
     */
    public function index()
    {

        //TODO  验证规则
       
       try {
           $exception =  DB::transaction(function() {
               return ['code' => '200','message' => '登陆成功','data' => ['token' => '123321']];
           });
       } catch (Exception $e) {
           dd($e);
           $exception = [
               'code' => '0',
               'message' => $this->handler($e),
           ];
       }
       return array_merge($this->results, $exception);

    }
    public function get_info($field){
        try {
                $result = $this->userRepo->findWhere($field)->all();
                return $result[0];
        } catch (Exception $e) {
            dd($e);
            $exception = [
                'code' => '0',
                'message' => $this->handler($e),
            ];
        }
        return array_merge($this->results, $exception);
    }
}