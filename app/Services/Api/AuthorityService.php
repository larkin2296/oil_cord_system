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
class AuthorityService extends Service
{
    use ServiceTrait, ResultTrait, ExceptionTrait;
    use CodeTrait,
        UserTrait,
        CatSupplyTrait;

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
        try {
            $exception = DB::transaction(function () {

                /*验证权限*/
                $this->checkAdminUser();

                $fieldWhere = $this->searchArray([
                    'truename' => 'like',
                ]);

                $where = array_merge($fieldWhere,[
                   'role_status' => config('back.global.status.order.doing'),
                ]);


                $data = $this->userRepo->findWhere($where)
                    ->map(function ($item, $key) {
                    return [
                        'id' => $item['id'],
                        'truename' => $item->truename ?? $item->mobile,
                        'cam_permission' => $this->checkJurisdictionStatus($item->cam_permission) ?? '',
                        'long_term_permission' => $this->checkJurisdictionStatus($item->long_term_permission) ?? '',
                        'put_forward_premission' => $this->checkJurisdictionStatus($item->put_forward_premission) ?? '',
                        'recommend_status' => $this->checkJurisdictionStatus($item->recommend_status) ?? '',
                        'several' => $item->several,
                    ];

                })->all();

                if ($data) {
                } else {
                    throw new EXception('暂时没有供应商数据', '2');
                }
                return ['code' => '200', 'message' => '供应商列表显示成功', 'data' => $data];

            });
        } catch (Exception $e) {
            dd($e);
        }
        return array_merge($this->results, $exception);
    }

    /**
     * 修改供应商权限
     * return [type] [deception]
     */
    public function store()
    {
        try {
            $exception = DB::transaction(function () {

                /*验证权限*/
                $this->checkAdminUser();
                $arr = [
                    'recommend_status' => request()->post('recommend_status'),
                    'put_forward_premission' => request()->post('put_forward_premission'),
                    'long_term_permission' => request()->post('long_term_permission'),
                    'cam_permission' => request()->post('cam_permission'),
                    'several' => request()->post('several'),

                ];

                $data = $this->userRepo->update($arr,request()->id);

                return ['code' => '200', 'message' => '修改权限成功', 'data' => $data];

            });
        } catch (Exception $e) {
            dd($e);
        }
        return array_merge($this->results, $exception);

    }

}