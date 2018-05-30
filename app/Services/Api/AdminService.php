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
class AdminService extends Service {
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
            $exception = DB::transaction(function() {

                if( $checkProject = $this->checkModalJurisdiction() ) {

                    if( is_bool($checkProject) ) {
                       $data = $this->select();
                    } else {
                        if($checkProject->first()->service_jurisdiction == getCommonCheckValue(true)){
                            $data = $this->select();

                        } else {
                            throw new Exception('您还没有该权限,请联系管理员开通',2);
                        }
                    }
                }
                return $this->results = array_merge([
                    'code' => '200',
                    'message' => '查询成功',
                    'data' => $data,
                ]);
            });
        } catch( Exception $e ) {
            dd($e);
        }
        return array_merge($this->results,$exception);
    }

    public function select()
    {
        $data = $this->userRepo->with('jurisdiction')->findWhereIn('role_status',[3,4])->all();
        return $data;
    }
    /**
     * 管理员添加
     * return [type] [deception]
     */
    public function create()
    {
        try{
            $exception = DB::transaction(function(){
                /*校验数据*/
                if( $checkProject = $this->checkModalJurisdiction() ) {

                    $build = $this->setData(request()->all(),$this->jwtUser());
                    /*超级管理员权限*/
                    if( is_bool($checkProject) ){
                        $this->userRepo->create($build);

                    } else {
                        //验证非超级管理员是否有服务商权限
                        if( $checkProject->first()->service_jurisdiction == getCommonCheckValue(true) ) {
                            /*处理*/
                            $this->userRepo->create($build);
                        } else {
                            throw new Exception('您还没有该权限,请联系管理员开通',2);
                        }
                    }
                }
               return $this->results = array_merge([
                   'code' => '200',
                   'message' => '管理员添加成功',
                   'data' => collect([]),
               ]);
            });
        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results,$exception);
    }

    /**
     * 管理员权限设定
     * @param  [type] $data       [description]
     * @return [type]             [description]
     */
    public function setAdmin()
    {
        try{
            $exception = DB::transaction(function() {

                if( !$user_id = request('user_id','') ) {
                    throw new EXception('请选择要设定的管理员',2);
                }

                if( $this->getRoles() == getCommonCheckValue(true) ) {

                   $superAdmin =  $this->checkUserJurisdiction($user_id);
                } else {
                    //管理员设定非超管权限
                    $role = $this->userRepo->find($user_id);

                    if( $role->role_status == config('back.global.status.order.refunding') ) {

                        throw new Exception('您选择的管理员为超级管理员 您暂时无权为它操作',2);

                    } else if($role->role_status == config('back.global.status.order.complete')) {
                        $ordinary = $this->checkUserJurisdiction($user_id);
                    }
                }
                //设定权限 超级管理员
                return $this->results = array_merge([
                    'code' => '200',
                    'message' => '设定成功',
                    'data' => collect([]),
                ]);
            });
        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results,$exception);
    }

    public function checkUserJurisdiction($user_id)
    {
        $object = $this->userRepo->with(['jurisdiction'])->find($user_id);
        $jurisdiction= $object->jurisdiction;

        if(is_object($jurisdiction)){

            $this->jurisdictionRepo->update(request()->all(),$jurisdiction->id);
        } else{
            $this->jurisdictionRepo->create(request()->all());

        }
    }

}