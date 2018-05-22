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
    use ServiceTrait, ResultTrait, ExceptionTrait, CodeTrait, UserTrait, CatSupplyTrait;
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
                dd(123);
                /*用户信息*/
                $user = $this->jwtUser();

                $field = [
                    'denomination' => '=',
                    'platform_id' => '=',
                    'status' => '=',
                    'success_time' => 'like',
                ];
                $fieldWhere = $this->searchArray($field);

                $where = array_merge($fieldWhere, [
                    'user_id' => $user->id,
                ]);

                $data = $this->supplyCamRepo->findWhere($where)->map(function ($item, $key) {
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
                        'supplier_time' => $item['created_at'],
                    ];

                })->all();
                //->model()::with(['denomination','platform'])->get();
                if ($data) {
                } else {
                    throw new EXception('卡密查询异常,请重试', '2');
                }
                return ['code' => '200', 'message' => '查询成功', 'data' => $data];

            });
        } catch (Exception $e) {
            dd($e);
        }
        return array_merge($this->results, $exception);
    }

}