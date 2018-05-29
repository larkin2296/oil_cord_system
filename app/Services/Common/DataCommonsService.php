<?php
namespace App\Services\Common;
use App\Traits\ResultTrait;
use App\Traits\ExceptionTrait;
use App\Traits\ServiceTrait;
use App\Traits\UserTrait;
use App\Traits\EncryptTrait;
use App\Services\Service;
use App\Traits\CodeTrait;
use Carbon\Carbon;
use Exception;
use DB;
use Storage;
use JWTAuth;
use Illuminate\Support\Facades\Hash;
class DataCommonsService extends Service
{
    use ServiceTrait, ResultTrait, ExceptionTrait, UserTrait, CodeTrait, EncryptTrait;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取全部供应商
     * return [type] [deception]
     */
    public function getSupplierAll()
    {
        try{
            $data = $this->userRepo->findWhere([
                'role_status' => config('back.global.status.order.doing'),
            ])->all();
            if( $data ) {

            }else {
                throw new Exception('获取数据失败',2);
            }

            return ['code' => '200', 'message' => '获取数据成功', 'data' => $data];
        } catch(Exception $e) {
            dd($e);
        }

    }

    /**
     * 获取全部采购商
     * return [type] [deception]
     */
    public function getPurchasersAll()
    {
        try{
            $data = $this->userRepo->findWhere([
                'role_status' => config('back.global.status.order.wait'),
            ])->all();
            if( $data ) {

            }else {
                throw new Exception('获取数据失败',2);
            }

            return ['code' => '200', 'message' => '获取数据成功', 'data' => $data];
        } catch(Exception $e) {
            dd($e);
        }
    }

    /**
     * 获取全部管理员
     * return [type] [deception]
     */
    public function getAdminAll()
    {
        try{
            $data = $this->userRepo->findWhere([
                'role_status' => config('back.global.status.order.complete'),
            ])->all();
            if( $data ) {
            }else {
                throw new Exception('获取数据失败',2);
            }

            return ['code' => '200', 'message' => '获取数据成功', 'data' => $data];
        } catch(Exception $e) {
            dd($e);
        }
    }

    /**
     * 验证用户权限
     * return [type] [deception]
     */
    public function checkUserOauth()
    {
        try{
            $exception = DB::transaction(function() {

                /*用户信息*/
                $user = $this->jwtUser();
                $data = request()->data;
                if($user->$data == getCommonCheckValue(true)) {
                }else {
                    throw new Exception('您暂时没有开通此权限，请联系管理员开通',2);
                }
                return $this->results = array_merge([
                    'code' => '200',
                    'message' => '权限验证通过',
                    'data' => collect([]),
                ]);
            });

        } catch(Exception $e) {
            dd($e);
        }
        return array_merge($this->results,$exception);
    }

    /**
     * 获取邀请人
     * return [type] [deception]
     */
    public function getInvitationHuman()
    {
        try{
            $exception = DB::transaction(function() {

                $rebuild = array(
                  '0' => getCommonCheckValue(true),
                  '1' => getCommonCheckValue(false),
                );

                $data = $this->userRepo->findWhereIn('role_status',$rebuild);
                if( $data ) {
                }else {
                    throw new Exception('获取邀请人失败',2);
                }
                return $this->results = array_merge([
                    'code' => '200',
                    'message' => '权限验证通过',
                    'data' => $data ?? collect([]),
                ]);
            });

        } catch(Exception $e) {
            dd($e);
        }
        return array_merge($this->results,$exception);
    }



}