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
class AdministratorService extends Service {
    use ServiceTrait,ResultTrait,ExceptionTrait, CodeTrait,UserTrait,CatSupplyTrait;
    protected $builder;
    public function __construct()
    {
        parent::__construct();
    }
    public function get_camilo_list(){
        try{
            $exception = DB::transaction(function(){

                /*用户信息*/
                $user = $this->jwtUser();

                $field= [
                    'order_type' => '='
                ];
                $fieldWhere =  $this->searchArray($field);

                $where = array_merge($fieldWhere,[
                    'order_type' => 1,
                ]);

                $data =  $this->purorderRepo->findWhere($where)->map(function($item,$key){
                    //return $item;
                    return [
                        'id' => $item['id'],
                        'order_code' => $item['order_code'],
                        'discount' => $item['discount'],
                        'denomination' => $this->handleDenomination($item['unit_price']),
                        'platform_id' => $this->handlePlatform($item['platform']),
                        'created_at' => $item['created_at'],
                        'num' => $item['num'],
                        'status' => $item['order_status']
                    ];

                })->all();
                //->model()::with(['denomination','platform'])->get();
                if( $data ) {
                } else {
                    throw new EXception('卡密查询异常,请重试','2');
                }
                return ['code' => '200', 'message' => '查询成功', 'data' => $data];

            });
        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results, $exception);
    }
    //直充数据获取
    public function get_directly_list(){
        try{
            $exception = DB::transaction(function(){

                /*用户信息*/
                $user = $this->jwtUser();

                $field= [
                    'supply_status' => '='
                ];
                $fieldWhere =  $this->searchArray($field);

                $where = array_merge($fieldWhere,[
                    'supply_status' => 1,
                ]);

                $data =  $this->supplySingleRepo->findWhere($where)->map(function($item,$key){
                    $result = $this->oilcardRepo->model()::where(['oil_card_code'=>$item['oil_number']])->get();
                    $user = $this->userRepo->find($result[0]['user_id']);
//                    dd($user);
                    return [
                        'id' => $item['id'],
                        'supply_single_number' => $item['supply_single_number'],
                        'already_card' => $item['already_card'],
                        'discount' => $item['discount'],
                        'end_time' => $item['end_time'],
                        'oil_number' => $item['oil_number'],
                        'serial_number' => $result[0]['serial_number'],
                        'ture_name' => $result[0]['ture_name'],
                        'purchasing_name' => $user['truename']
                    ];

                })->all();
                //->model()::with(['denomination','platform'])->get();
                if( $data ) {
                } else {
                    throw new EXception('卡密查询异常,请重试','2');
                }
                return ['code' => '200', 'message' => '查询成功', 'data' => $data];

            });
        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results, $exception);
    }
    public function send_camilo(){
        try{
            $exception = DB::transaction(function(){

                $post = request()->post('list','');
                $platform_id = $post['platform_id']['id'];
                $denomination = $post['denomination']['id'];
                $order = $post['id'];
                /*用户信息*/
                $user = $this->jwtUser();

                $field= [
                    'platform_id' => '=',
                    'denomination' => '=',
                    'status' => '=',
                ];
                $fieldWhere =  $this->searchArray($field);

                $where = array_merge($fieldWhere,[
                    'platform_id' => $platform_id,
                    'denomination' => $denomination,
                    'status' => 1
                ]);

                $data =  $this->supplyCamRepo->model()::where($where)->limit($post['num'])->get()->map(function($item,$key){
                    //return $item;
                    return [
                        'id' => $item['id'],
                    ];

                })->all();
                if(sizeof($data) < $post['num']){
                    return ['code' => '400', 'message' => '卡密数量不够', 'data' => ''];
                } else {
                    try{
                        $this->set_camilo_status($data);
                    }catch(Exception $e){
                        return ['code' => '400', 'message' => $e, 'data' => ''];
                    }
                    try{
                        $this->set_camilo_order($data,$order);
                    }catch(Exception $e){
                        return ['code' => '400', 'message' => $e, 'data' => ''];
                    }
                }
                if( $data ) {
                } else {
                    throw new EXception('卡密查询异常,请重试','2');
                }
                return ['code' => '200', 'message' => '查询成功', 'data' => $data];

            });
        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results, $exception);
    }
    private function set_camilo_status($data){
        foreach($data as $value){
            $this->supplyCamRepo->update(['status'=>2],$value['id']);
        }
        return true;
    }
    private function set_camilo_order($data,$order){
        foreach($data as $value){
            $this->purchasingcamilodetailRepo->create(['order_code'=>$order,'camilo_id'=>$value['id']]);
        }
        $this->purorderRepo->update(['order_status'=>2],$order);
        return true;
    }

    public function get_card(){
        $result = $this->oilcardRepo->model()::orderBy('user_id')->get()->map(function($item,$index){
            $user = $this->userRepo->find($item['user_id']);
           return [
             'id'=>$item['id'],
             'name' => $user['truename'],
             'serial_number'=>$item['serial_number'],
             'oil_card_code' => $item['oil_card_code'],
             'card_status' => $item['card_status'],
             'is_longtrem' => $item['is_longtrem']
           ];
        });
        return ['code' => '200', 'message' => '查询成功', 'data' => $result];
    }

    public function get_purchasing_user(){
        $user = $this->userRepo->findWhere(['role_status'=>1])->map(function($item,$index){
            return [
                'id' => $item['id'],
                'name' => $item['truename'],
                'recharge_camilo' => $item['recharge_camilo'] == 1 ? true : false,
                'recharge_short_directly' => $item['recharge_short_directly'] == 1 ? true : false,
                'recharge_long_directly' => $item['recharge_long_directly'] == 1 ? true : false,
                'pay_camilo' => "{$item['pay_camilo']}",
                'pay_directly' => "{$item['pay_directly']}"
            ];
        });
        return ['code' => '200', 'message' => '查询成功', 'data' => $user];
    }

    public function get_supplier_user(){
        $user = $this->userRepo->findWhere(['role_status'=>2])->map(function($item,$index){
            return [
                'id' => $item['id'],
                'name' => $item['truename'],
                'recommend_status' => $item['recommend_status'] == 1 ? true : false,
                'put_forward_premission' => $item['put_forward_premission'] == 1 ? true : false,
                'long_term_permission' => $item['long_term_permission'] == 1 ? true : false,
                'cam_permission' => $item['cam_permission'] == 1 ? true : false,
                'several' => $item['several'],
                'edit' => false
            ];
        });
        return ['code' => '200', 'message' => '查询成功', 'data' => $user];
    }

    public function set_user_perrmission() {
        $post = request()->post('list','');
        $where = [
            'recharge_camilo' => $post['recharge_camilo'] == true ? 1 : 2,
            'recharge_short_directly' => $post['recharge_short_directly'] == true ? 1 : 2,
            'recharge_long_directly' => $post['recharge_long_directly'] == true ? 1 : 2,
            'pay_camilo' => $post['pay_camilo'],
            'pay_directly' => $post['pay_directly']
        ];
        $result = $this->userRepo->update($where,$post['id']);
        if ($result) {
            return ['code' => '200','message' => '修改成功'];
        } else {
            return ['message' => '修改失败'];
        }
    }
    public function set_supplier_perrmission() {
        $post = request()->post('list','');
        $where = [
            'cam_permission' => $post['cam_permission'] == true ? 1 : 2,
            'long_term_permission' => $post['long_term_permission'] == true ? 1 : 2,
            'put_forward_premission' => $post['put_forward_premission'] == true ? 1 : 2,
            'recommend_status' => $post['recommend_status'] == true ? 1 : 2,
            'several' => $post['several']
        ];
        $result = $this->userRepo->update($where,$post['id']);
        if ($result) {
            return ['code' => '200','message' => '修改成功'];
        } else {
            return ['message' => '修改失败'];
        }
    }
    public function get_sdirectly_list() {
        try{
            $exception = DB::transaction(function(){

                /*用户信息*/
                $user = $this->jwtUser();

                $field= [
                    'order_type' => '='
                ];
                $fieldWhere =  $this->searchArray($field);

                $where = array_merge($fieldWhere,[
                    'order_type' => 2,
                ]);

                $data =  $this->purorderRepo->findWhere($where)->map(function($item,$key){
                    $res = $this->supplySingleRepo->model()::where(['notes'=>$item['order_code']])->sum('already_card');
                    $success = $this->supplySingleRepo->model()::where(['notes'=>$item['order_code'],'supply_status'=>1])->sum('already_card');
                    return [
                        'id' => $item['id'],
                        'order_code' => $item['order_code'],
                        'discount' => $item['discount'],
                        'oil_card_code' => explode(',',$item['oil_card_code']),
                        'price' => $item['price'],
                        'created_at' => $item['created_at'],
                        'history_price' =>$res,
                        'success_price' => $success
                    ];

                })->all();
                //->model()::with(['denomination','platform'])->get();
                if( $data ) {
                } else {
                    throw new EXception('卡密查询异常,请重试','2');
                }
                return ['code' => '200', 'message' => '查询成功', 'data' => $data];

            });
        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results, $exception);
    }
    public function charge()
    {
        try{
            $exception = DB::transaction(function() {
                #TODO 生成供应单记录 增加附件信息 关联上附件信息 direct_id 附件id
                /*充值油卡*/

                $res = request()->post('list','');


                /*用户信息*/
                $user = $this->jwtUser();

                $arr = [
                    'already_card' => $res['price'],
                    'end_time' => request()->end_time,
                    'oil_number' => $res['oil_card'],
                    'user_id' => $user->id,
                    'end_time' => $res['recharge_time'],
                    'direct_id' => $res['id_hash'],
                    'status' => 1,
                    'supply_status' => 2,
                    'notes' => $res['order_code']
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

    public function get_sdirectly_detail() {
        try{
            $exception = DB::transaction(function(){
                $res = request()->post('list','');

                /*用户信息*/
                $user = $this->jwtUser();

                $field= [
                    'notes' => '='
                ];
                $fieldWhere =  $this->searchArray($field);

                $where = array_merge($fieldWhere,[
                    'notes' => $res,
                ]);

                $data =  $this->supplySingleRepo->findWhere($where)->map(function($item,$key){
                    return [
                        'id' => $item['id'],
                        'supply_single_number' => $item['supply_single_number'],
                        'oil_number' => $item['oil_number'],
                        'already_card' => $item['already_card'],
                        'end_time' => $item['end_time']
                    ];

                })->all();
                //->model()::with(['denomination','platform'])->get();
                if( $data ) {
                } else {
                    throw new EXception('卡密查询异常,请重试','2');
                }
                return ['code' => '200', 'message' => '查询成功', 'data' => $data];

            });
        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results, $exception);
    }
    /**
     * 审核管理列表
     * return [type] [deception]
     */
    public function audit_list()
    {
        try{
            $exception = DB::transaction(function(){

                /*验证权限*/
                $this->checkAdminUser();
                $field = [
                    'truename' => 'like',
                    'name' => 'like',
                    'mobile' => 'like',
                    'qq_num' => 'like',
                    'alipay' => 'like',
                    'invitation_id' => '=',
                    'status_examine' => '=',
                ];
                /*查询条件*/
                $whereField = $this->searchArray($field);
                /*规范角色*/
                $where = array_merge($whereField,[
                    'role_status' => getCommonCheckValue(true),
                ]);
//                DB::connection()->enableQueryLog();
                $data = $this->userRepo->with(['attachments'=>function($query){
                    return $query;
                }])->findWhere($where)->map(function($item, $key){
                    $attachmentsRebuild = $item->attachments->isNotEmpty() ? $item->attachments : collect([]);
                    /*构造数组*/
                    $attachments = array();

                    foreach($attachmentsRebuild as $value){
                        $attachments[] = route('common.attach.show',[$value->id_hash]);
                    }
                    return [
                        'id' => $item->id,
                        'name' => $item->name ?? '',
                        'truename' => $item->truename ?? $item->mobile,
                        'qq_num' => $item->qq_num ?? '',
                        'id_card' => $item->id_card ?? '',
                        'mobile' => $item->mobile ?? '',
                        'alipay' => $item->alipay ?? '',
                        'notes' => $item->notes ?? '',
                        'status_examine' => $item->status_examine ?? getCommonCheckValue(true),
                        'avatar' => dealAvatar($item->avatar) ?? '',
                        'attachments' => $attachments ?? collect([]),
                    ];
                });
//                print_r(DB::getQueryLog());
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
}