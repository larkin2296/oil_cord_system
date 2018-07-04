<?php
namespace App\Services\Api;

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


class PurchasingService extends Service {
    use ServiceTrait,ResultTrait,ExceptionTrait,CodeTrait,UserTrait,CatSupplyTrait;

    protected $builder;
    public function __construct()
    {
        parent::__construct();
    }
    protected function r_object($table){
        switch($table){
            case 'purchasing_order':
                return $this->purorderRepo;
                break;
            case 'purchasing_camilo_detail':
                return $this->purchasingcamilodetailRepo;
                break;
            case 'user_oil_card':
                return $this->oilcardRepo;
                break;
            default:
                return 'Boom!!!,not found class';
                break;
        }
    }
    private function get_data($table,$param){
        $result = $this->r_object($table)->findWhere($param);
        return $result;
    }
    //获取卡密订单数据
    public function get_camilo_order(){
        $user = $this->jwtUser();
        $post = request()->post('list','');

        if(!empty($post)) {
            if(isset($post['goods_type']) && $post['goods_type'] != ''){
                $where['platform'] = $this->get_platform_id($post['goods_type']);
            }
            if(isset($post['card_price']) && $post['card_price'] != ''){
                $where['unit_price'] = $this->get_denomination_id($post['card_price']);
            }
            isset($post['order_status']) ? $where['order_status'] = $post['order_status'] : '';
            isset($post['time_end']) ? $where['created_at'] = ['created_at','<',$post['time_end'].'23:59:59'] : '';
            isset($post['time_start']) ? $where['created_at'] = ['created_at','>',$post['time_start'].'00:00:00'] : '';
            isset($post['order_code']) ? $where['order_code'] = ['order_code','like','%'.$post['order_code'].'%'] : '';
        }
        $where['order_type'] = 1;
        $where['user_id'] = $user->id;
//        DB::connection()->enableQueryLog();
        $results = $this->purorderRepo->orderBy('created_at','desc')->findWhere($where);
//        print_r(DB::getQueryLog());
        foreach($results as &$val){
            $val['platform'] = $this->handlePlatform($val['platform']);
//            $val['unit_price'] = $this->handlePlatform($val['unit_price']);
            switch($val['order_status']){
                case 1:
                    $val['order_status'] = '未完成';
                    break;
                case 2:
                    $val['order_status'] = '已完成';
                    break;
                case 3:
                    $val['order_status'] = '问题订单';
                    break;
                default:
                    break;
            }
        }
        return $results;
    }
    //获取长充数据
    public function ldirectly_order($request){
        $post = request()->post('list','');

        if(!empty($post)) {
            isset($post['serial_number']) ? $where['serial_number'] = $post['serial_number'] : '';
            isset($post['ture_name']) ? $where['ture_name'] = ['ture_name','like','%'.$post['ture_name'].'%'] : '';
            isset($post['oil_card_code']) ? $where['oil_card_code'] = ['oil_card_code','like','%'.$post['oil_card_code'].'%'] : '';
        }
        $user = $this->jwtUser();
        $where['is_longtrem'] = 1;
        $where['user_id'] = $user->id;
        $results = $this->oilcardRepo->findWhere($where)->map(function($item,$index){
            $res = $this->supplySingleRepo->model()::where(['oil_number'=>$item['oil_card_code'],'supply_status'=>1])->sum('already_card');
            $time = $this->supplySingleRepo->model()::where(['oil_number'=>$item['oil_card_code'],'supply_status'=>1])->orderBy('end_time','desc')->first();
            return [
             'id' => $item['id'],
             'oil_card_code'=>$item['oil_card_code'],
             'serial_number' => $item['serial_number'],
             'last_recharge_time' => $time['end_time'],
             'save_money' =>   $res,
             'initialize_price' => $item['initialize_price'],
             'total_money' => $item['total_money']
           ];
        });
        return $results;
    }
    //获取短充数据
    public function sdirectly_order($request){
        $post = request()->post('list','');

        if(!empty($post)) {
            isset($post['order_status']) ? $where['order_status'] = $post['order_status'] : '';
//            isset($post['time_end']) ? $where['created_at'] = ['created_at','<',$post['time_end'].'23:59:59'] : '';
//            isset($post['time_start']) ? $where['created_at'] = ['created_at','>',$post['time_start'].'00:00:00'] : '';
            isset($post['order_code']) ? $where['order_code'] = ['order_code','like','%'.$post['order_code'].'%'] : '';
        }
        $user = $this->jwtUser();
        $where['order_type'] = 2;
        $where['user_id'] = $user->id;
        $results = $this->purorderRepo->orderBy('created_at','desc')->findWhere($where)->map(function($item,$index){
            $res = $this->supplySingleRepo->model()::where(['notes'=>$item['order_code'],'supply_status'=>1])->sum('already_card');
            $time = $this->supplySingleRepo->model()::where(['notes'=>$item['order_code'],'supply_status'=>1])->orderBy('end_time','desc')->first();
            return [
                'id' => $item['id'],
                'order_code'=>$item['order_code'],
                'price' => $item['price'],
                'status' => $item['order_status'],
                'real_unit_price' => $res,
                'pageviews' => $time == '' ? '' :$time['end_time']
            ];
        });
        return $results;
    }
    //将购物车数据添加到数据库
    public function add($request){
        $order = $this->set_order_code($request['order_type'],1,1);
        try {
                $re = $request;
                if(isset($request['platform']) && $request['platform'] != ''){
                    $re['platform'] = $this->get_platform_id($request['platform']);
                }
                if(isset($request['unit_price']) && $request['unit_price'] != ''){
                    $re['unit_price'] = $this->get_denomination_id($request['unit_price']);
                }
                $re['order_code'] = $order;
                $re['order_status'] = 1;
                $this->purorderRepo->create($re);
            return ['code' => '200','message' => '添加成功'];
        } catch (Exception $e) {
            dd($e);
            $exception = [
                'code' => '0',
                'message' => $this->handler($e),
            ];
        }
        return array_merge($this->results, $exception);
    }
    public function card_binding(){
        try{
            $data = request()->post('list','');
            foreach($data as $val){
                $res = $this->oilcardRepo->findWhere(['oil_card_code'=>$val['oil_card_code']])->count();
                if($res == 0){
                    $this->oilcardRepo->create($val);
                    return ['code' => '200','message' => '添加成功'];
                }else{
                    return ['code' => '500','message' => '此卡已存在'];
                }
            }

        }catch(Exception $e){
            $exception = [
                'code' => '0',
                'message' => $this->handler($e),
            ];
        }
        return array_merge($this->results, $exception);
    }
    public function get_short_card($table,$param){
        $result = $this->get_data($table,$param);
        $code = [];
        foreach($result as $val){
            $code[] = $val['oil_card_code'];
        }
        return $code;
    }
    public function get_card(){
        $post = request()->post('list','');

        if(!empty($post)) {
            isset($post['serial_number']) ? $where['serial_number'] = $post['serial_number'] : '';
            isset($post['ture_name']) ? $where['ture_name'] = ['ture_name','like','%'.$post['ture_name'].'%'] : '';
            isset($post['oil_card_code']) ? $where['oil_card_code'] = ['oil_card_code','like','%'.$post['oil_card_code'].'%'] : '';
            isset($post['is_longtrem']) ? $where['is_longtrem'] = $post['is_longtrem'] : '';
        }
        $where['is_del'] = 0;
        $user = $this->jwtUser();
        $where['user_id'] = $user->id;
        $results = $this->oilcardRepo->findWhere($where);
        foreach($results as &$val){
            if($val['card_status'] == 0){
                $val['is_start'] = true;
                $val['status'] = false;
                $val['longtrem'] = false;
                $val['disabled'] = true;
            }else if($val['card_status'] == 1){
                $val['is_start'] = false;
                $val['status'] = '正常';
                $val['longtrem'] = true;
                $val['disabled'] = false;
            }else if($val['card_status'] == 2){
                $val['is_start'] = false;
                $val['status'] = '停用';
                $val['longtrem'] = false;
                $val['disabled'] = false;
            }
        }
        return $results;
    }
    public function get_oilcard_upload() {
        $list = request()->post('list','');
        /*设置时间*/
        set_time_limit(0);

        $filePath = 'storage/app/'.iconv('UTF-8', 'GBK', $list);

        $data = Excel::load($filePath, function($reader) {

            $reader = $reader->getSheet(0)->toArray();
            return $reader;
        });

        $array = $data->getSheet(0)->toArray();

        $user = $this->jwtUser();
        foreach($array as $key=>&$val){
            if($key > 0){
                $arr[$key-1]['serial_number'] = $val[0];
                $arr[$key-1]['ture_name'] = $val[1];
                $arr[$key-1]['oil_card_code'] = $val[2];
                $arr[$key-1]['identity_card'] = $val[3];
                $arr[$key-1]['web_account'] = $val[4];
                $arr[$key-1]['web_password'] = $val[5];
                $arr[$key-1]['user_id'] = $user->id;
            }
        }
        return ['code' => '200' ,'message' => '显示成功','data' => $arr];
    }
    public function card_start($request){
        $result = $this->oilcardRepo->update(['card_status'=>1],$request->card);
        if($result['card_status'] == 0){
            $result['is_start'] = true;
            $result['status'] = false;
            $result['longtrem'] = false;
        }else if($result['card_status'] == 1){
            $result['is_start'] = false;
            $result['status'] = '正常';
            $result['longtrem'] = true;
        }else if($result['card_status'] == 2){
            $result['is_start'] = false;
            $result['status'] = '停用';
            $result['longtrem'] = false;
        }
        return $result;
    }
    public function del_card(){
        $id = request()->post('id','');
        $result = $this->oilcardRepo->update(['is_del'=>1],$id);
        return ['code' => '200' ,'message' => '删除成功','data' => $result];
    }

    public function directly_order($request){
        $result = $request['list'];
        foreach($result as $key=>$value){
            $arr = implode(',',$value['oil_card_code']);
            $result[$key]['oil_card_code'] = $arr;
        }
        foreach($result as $val){
            $this->add($val);
        }
        return ['code' => 200, 'message' => '添加成功'];
    }
    //获取卡密订单详情
    public function get_camilo_detail(){
        $order_code = request('order','');
        $results['data'] = DB::table('purchasing_camilo_detail')
                    ->join('supply_cam','purchasing_camilo_detail.camilo_id','=','supply_cam.id')
                    ->join('platform','platform.id','=','supply_cam.platform_id')
                    ->join('platform_money','platform_money.id','=','supply_cam.denomination')
                    ->where('purchasing_camilo_detail.order_code','=',$order_code)
                    ->select('platform.platform_name', 'platform_money.denomination','supply_cam.cam_name','supply_cam.id','supply_cam.cam_other_name','supply_cam.status')
                    ->get();
        $order = $this->purorderRepo->model()::where(['id'=>$order_code])->get();
        $results['msg']['order'] = $order[0]['order_code'];
        $results['msg']['num'] = $this->purchasingcamilodetailRepo->findWhere(['order_code'=>$order_code])->count();
        $results['msg']['is_usd'] = $this->purchasingcamilodetailRepo->findWhere(['order_code'=>$order_code,'is_used'=>1])->count();
        $results['msg']['is_error'] = $this->purchasingcamilodetailRepo->findWhere(['order_code'=>$order_code,'is_problem'=>1])->count();
        $results['msg']['no_use'] = $results['msg']['num'] - $results['msg']['is_usd'] - $results['msg']['is_error'];
        foreach($results['data'] as &$value){
            switch($value->status){
                case '2':
                    $value->status_name = '未使用';
                    break;
                case '3':
                    $value->status_name = '问题卡密';
                    break;
                case '4':
                    $value->status_name = '已使用';
                    break;
                default:
                    break;
            }
        }
        return $results;
    }
    /*设置为问题卡密*/
    public function set_problem(){
        try{
            $this->purchasingcamilodetailRepo->update(['is_problem'=>1],request('id', ''));
            $this->supplyCamRepo->update(['status'=>4],request('card_code',''));
        }catch(Exception $e) {
            return $e;
        }
        return true;
    }
    /*获取圈存数据*/
    public function get_initialize(){
//        'select from supplier_order a inner join oil_card_code b on card_code=card_code where
//         b.user_id=X and a.time< and a.time> group by order_code';
        $user = $this->jwtUser();
        $post = request()->post('list','');

        if(!empty($post)) {
            isset($post['oil_card_code']) ? $where['oil_card_code'] = ['oil_card_code','like','%'.$post['oil_card_code'].'%'] : '';
            isset($post['save_money']) && $post['save_money'] == 0 ? $where['save_money'] = 0 : $where['save_money'] = ['save_money','<>',0];
        }
        $where['user_id'] = $user->id;
        $where['card_status'] = 1;
        $result = $this->oilcardRepo->findWhere($where)->map(function($item,$index){
           return [
              'oil_card_code' => $item['oil_card_code'],
               'save_money' => $item['save_money'],
               'initialize_price' => $item['initialize_price']
           ] ;
        });
        return ['code'=>200,'message'=>'获取成功','data'=>$result];
    }
//    /*圈存详细数据*/
//    public function get_initialize_detail(){
//        'select from supplier_order where card_code=X and a.time< and a.time>';
//        'select from initialize where card_code=X and a.time< and a.time>';
//    }
//    public function set_initialize_data(){
//        'inset into initialize () values()';
//    }
    /*采购商自动补货*/
    public function auto_recharge(){
        $platform = request('platform','');
        $num = request('num','');
        $denomination = request('denomination','');
        if($this->supplier_cam->findWhere($platform,$denomination).length < $num){
            return '库存不够';
        }else{
            $result = $this->supplier_cam->findWhere($platform,$denomination)->limit($num);
            $this->problemorderRepo->create();
            return '生成补货单';
        }
    }
    /*采购商设置卡密已用*/
    public function set_camilo_userd($id,$code){
        $this->purchasingcamilodetailRepo->update(['is_used'=>1],['camilo_id'=>$id]);
        $this->supplyCamRepo->update(['status'=>4],['cam_name'=>$code]);
    }
    /*采购商直充长期查询详情*/
    public function get_ldirectly_detail(){
        $card = request()->post('card','');
        $where['oil_number'] = $card;
        $where['supply_status'] = 1;
        $data = $this->supplySingleRepo->orderBy('end_time','desc')->findWhere($where)->map(function($item,$key){
            return [
                'id' => $item->id,
                'oil_number' => $item->oil_number,
                'end_time' => $item->end_time,
                'already_card' => $item->already_card
            ];
        });
        return ['code' => 200, 'message' => '直充查询成功', 'data' => $data];
    }
    public function get_sdirectly_detail() {
        try{
            $exception = DB::transaction(function(){
                $res = request()->post('order','');

                /*用户信息*/
                $user = $this->jwtUser();

                $field= [
                    'notes' => '=',
                    'supply_status' => '='
                ];
                $fieldWhere =  $this->searchArray($field);

                $where = array_merge($fieldWhere,[
                    'notes' => $res,
                    'supply_status' => 1
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
    public function confirm_status() {
        try{
            $id = request()->post('id','');
            $card = $this->oilcardRepo->find($id);
            $res = $this->supplySingleRepo->findWhere(['oil_number'=>$card['oil_card_code'],'supply_status'=>2])->count();
            if($res == 0){
                if($card['card_status'] == 1){
                    $this->oilcardRepo->update(['card_status'=>2],$id);
                } else {
                    $this->oilcardRepo->update(['card_status'=>1],$id);
                }
                return ['code' => '200', 'message' => '修改成功'];
            }else{
                return ['code' => '400', 'message' => '有未完成订单待处理'];
            }
        }catch(Exception $e){
            $exception = [
                'code' => '0',
                'message' => $this->handler($e),
            ];
        }
        return array_merge($this->results, $exception);
    }

    //上报圈存
    public function send_initialize() {
        try{
            $exception = DB::transaction( function() {

                $post = request()->post('list','');
                $card = $post['oil_card'];
                $time = $post['recharge_time'];
                $money = $post['money'];
                $user = $this->jwtUser();
                $singe_money = $this->oilcardRepo->findWhere(['oil_card_code'=>$card]);
                $already_money = $singe_money[0]['save_money'] - $money;
                $initialize_money = $singe_money[0]['initialize_price'] + $money;
                $result = $this->oilcardRepo->model()::where(['oil_card_code'=>$card])->update(['save_money'=>$already_money,'initialize_price'=>$initialize_money]);


                $arr = [
                    'user_id' => $user->id,
                    'in_price' => $money,
                    'card_code' => $card,
                    'in_time' => $time
                ];

                $data = $this->initializeRepo->create($arr);

                return $this->results = array_merge([
                    'code' => '200',
                    'message' => '圈存成功',
                    'data' => $data,
                ]);
            });

        }catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results,$exception);
    }

    public function get_reconciliation_data() {
        try{
            $exception = DB::transaction( function() {

                $post = request()->post('list','');
                $card = $post['oil_card_code'];
                $end_time = $post['end_time'].' 23:59:59';
                $start_time = $post['start_time'].' 00:00:00';
//                DB::connection()->enableQueryLog();
                $initialize = [];
                $supplysingle = [];
                $initialize = $this->initializeRepo->model()::where(['card_code'=>$card,['in_time','>',$start_time],['in_time','<',$end_time],'check_money'=>0])->get()->map(function($item,$index){
                    $serial_number = $this->oilcardRepo->findWhere(['oil_card_code'=>$item['card_code']])->pluck('serial_number');
                    return [
                        'id' => $item['id'],
                        'serial_number' => $serial_number[0],
                        'oil_card_code' => $item['card_code'],
                        'time' => $item['in_time'],
                        'money' => $item['in_price'],
                        'type' => 'sub'
                    ];
                })->all();
//                print_r(DB::getQueryLog());
                $supplysingle = $this->supplySingleRepo->model()::where(['oil_number'=>$card,['end_time','>',$start_time],['end_time','<',$end_time],'supply_status'=>1,'check_money'=>0])->get()->map(function($item,$index){
                    $serial_number = $this->oilcardRepo->findWhere(['oil_card_code'=>$item['oil_number']])->pluck('serial_number');
                    return [
                        'id' => $item['id'],
                        'serial_number' => $serial_number[0],
                        'oil_card_code' => $item['oil_number'],
                        'time' => $item['end_time'],
                        'money' => $item['already_card'],
                        'type' => 'add'
                    ];
                })->all();
                $data['data'] = array_merge($initialize,$supplysingle);
                $sub = 0;
                $add = 0;
                foreach($data['data'] as $val){
                    if($val['type'] == 'sub'){
                        $sub += $val['money'];
                    }else if($val['type'] == 'add'){
                        $add += $val['money'];
                    }
                }
                $data['total'] = [
                  'sub' => $sub,
                  'add' => $add,
                  'sum' => $add-$sub
                ];
                return $this->results = array_merge([
                    'code' => '200',
                    'message' => '查询',
                    'data' => $data
                ]);
            });

        }catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results,$exception);
    }

    public function set_reconciliation_data() {
        try{
            $exception = DB::transaction( function() {
                $user = $this->jwtUser();

                $data = request()->post('data','');
                $initialize_money = request()->post('initialize_money','');
                $recharge_money = request()->post('recharge_money','');
                $sum_money = request()->post('sum_money','');
                $recon_end = request()->post('recon_end','');
                $recon_start = request()->post('recon_start','');

                $order = $this->set_order_code(3,1,7);
                    $arr = [
                        'order_code' => $order,
                        'user_id' => $user->id,
                        'status' => 1,
                        'recon_start' => $recon_start,
                        'recon_end' => $recon_end,
                        'total_price' => $sum_money,
                        'initialize_price' => $initialize_money,
                        'recharge_price' => $recharge_money
                    ];
                    $info =  $this->reconRepo->create($arr);
                    foreach($data as $value){
                        if($value['type'] == 'sub') {
                            $this->initializeRepo->update(['reconciliation'=>$info->id,'check_money'=>1],$value['id']);
                        } else {
                            $this->supplySingleRepo->update(['reconciliation'=>$info->id,'check_money'=>1],$value['id']);
                        }
                    }
                    return $this->results = array_merge([
                        'code' => '200',
                        'message' => '查询',
                        'data' => $info
                    ]);
            });

        }catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results,$exception);
    }
    public function get_reconciliation_list() {
        try{
            $exception = DB::transaction( function() {
                $user = $this->jwtUser();
                $where = [];
                if($user->id != 3 && $user->id != 4){
                    $where = [
                        'user_id' => $user->id
                    ];
                }
                if($user->id == 3 || $user->id == 4){
                    $this->checkPurchasingAdminJurisdiction();
                }
                $info =  $this->reconRepo->all();
                return $this->results = array_merge([
                    'code' => '200',
                    'message' => '查询',
                    'data' => $info
                ]);
            });

        }catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results,$exception);
    }

    public function get_reconciliation_detail() {
        try{
            $exception = DB::transaction( function() {

                $id = request()->post('id','');

                $initialize = [];
                $supplysingle = [];
                $initialize = $this->initializeRepo->model()::where(['reconciliation'=>$id,'check_money'=>1])->get()->map(function($item,$index){
                    $serial_number = $this->oilcardRepo->findWhere(['oil_card_code'=>$item['card_code']])->pluck('serial_number');
                    return [
                        'id' => $item['id'],
                        'serial_number' => $serial_number[0],
                        'oil_card_code' => $item['card_code'],
                        'time' => $item['in_time'],
                        'money' => $item['in_price'],
                        'type' => 'sub'
                    ];
                })->all();
//                print_r(DB::getQueryLog());
                $supplysingle = $this->supplySingleRepo->model()::where(['reconciliation'=>$id,'check_money'=>1])->get()->map(function($item,$index){
                    $serial_number = $this->oilcardRepo->findWhere(['oil_card_code'=>$item['oil_number']])->pluck('serial_number');
                    return [
                        'id' => $item['id'],
                        'serial_number' => $serial_number[0],
                        'oil_card_code' => $item['oil_number'],
                        'time' => $item['end_time'],
                        'money' => $item['already_card'],
                        'type' => 'add'
                    ];
                })->all();
                $data = array_merge($initialize,$supplysingle);

                return $this->results = array_merge([
                    'code' => '200',
                    'message' => '查询',
                    'data' => $data
                ]);
            });

        }catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results,$exception);
    }

    public function del_short_order() {
        try{
            $exception = DB::transaction( function() {

                $order = request()->post('order','');

                $result = $this->supplySingleRepo->model()::where(['notes'=>$order])->count();
                if($result == 0){
                    $id = $this->purorderRepo->model()::where(['order_code'=>$order])->pluck('id');
                    $res = $this->purorderRepo->delete($id[0]);
                    if($res) {
                        return $this->results = array_merge([
                            'code' => 200,
                            'message' => '删除成功',
                            'data' => $res
                        ]);
                    }
                } else {
                    return $this->results = array_merge([
                        'code' => 400,
                        'message' => '删除失败',
                        'data' => ''
                    ]);
                }
            });

        }catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results,$exception);
    }

    public function get_search_card() {
        try{
            $exception = DB::transaction( function() {

                $serial_number = request()->post('serial_number','');

                $oil_card_code = request()->post('oil_card_code','');
                $where = [];
                $user = $this->jwtUser();
                $where['user_id'] = $user->id;
                $where['is_longtrem'] = 0;
                $where['is_del'] = 0;

                $serial_number != '' ? $where['serial_number'] = ['serial_number','like','%'.$serial_number.'%'] : '';
                $oil_card_code != '' ? $where['oil_card_code'] = ['oil_card_code','like','%'.$oil_card_code.'%'] : '';

                $result = $this->oilcardRepo->findWhere($where)->map(function($item,$index){
                   return [
                       'serial_number' => $item['serial_number'],
                       'oil_card_code' => $item['oil_card_code']
                   ];
                });

                return $this->results = array_merge([
                    'code' => '200',
                    'message' => '查询',
                    'data' => $result
                ]);
            });

        }catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results,$exception);
    }

    public function camilo_order($data) {
        foreach($data as $value){
            $num["{$value['platform']}"]["{$value['unit_price']}"] = 0;
        }
        foreach($data as $value){
            $num["{$value['platform']}"]["{$value['unit_price']}"] += $value['num'];
        }
        foreach($num as $key=>$value){
            $platform_id = $this->platformRepo->findWhere(['platform_name'=>$key])->map(function($item,$key){
                return [
                    'id'=>$item['id']
                ];
            })->first();
            foreach($value as $k=>$v){
                $platform_money_id = $this->platformMoneyRepo->findWhere(['denomination'=>$k])->map(function($item,$key){
                    return [
                        'id'=>$item['id']
                    ];
                })->first();
                $where['denomination_id'] = $platform_money_id['id'];
                $where['platform_id'] = $platform_id['id'];
                $vaild = $this->inventoryRepo->findWhere($where)->pluck('vaild_num');
                if($v > $vaild[0]){
                    return ['msg'=>$key.'平台面额'.$k.'实时库存不足','code'=>400];
                }
            }
        }
        foreach($data as $val){
            $results = $this->add($val);
        }
        return ['code'=>200];
    }
}