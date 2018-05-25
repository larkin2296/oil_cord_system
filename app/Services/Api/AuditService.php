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
class AuditService extends Service {
    use ServiceTrait,ResultTrait,ExceptionTrait, CodeTrait,UserTrait,CatSupplyTrait;
    protected $builder;
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 审核管理列表
     * return [type] [deception]
     */
    public function index()
    {
        try{
            $exception = DB::transaction(function(){
                /*验证身份*/
                $this->checkAdminUser();

                $field = [
                    'truename' => 'like',
                    'name' => 'like',
                    'mobile' => 'like',
                    'qq_num' => 'like',
                    ''
                ];
                return $this->results = array_merge([
                    'code' => '200',
                    'message' => '查询成功',
                    'data' => '',
                ]);
            });
        } catch( Exception $e ) {
            dd($e);
        }
        return array_merge($this->results,$exception);
    }
}