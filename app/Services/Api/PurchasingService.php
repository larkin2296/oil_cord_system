<?php
namespace App\Services\Api;

use App\Traits\ResultTrait;
use App\Traits\ExceptionTrait;
use App\Traits\ServiceTrait;
use App\Traits\CodeTrait;
use App\Traits\UserTrait;
use App\Services\Service;
use Exception;
use DB;
use Redis;
use App\Repositories\Models\PurchasingOrder;
use JWTAuth;


class PurchasingService extends Service {
    use ServiceTrait,ResultTrait,ExceptionTrait,CodeTrait,UserTrait;

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
    public function get_data($table,$param){
        $result = $this->r_object($table)->findWhere($param);
        return $result;
    }
    //将购物车数据添加到数据库
    public function add($request){
        $order = $this->set_order_code($request[0]['order_type'],1,1);
        try {
            foreach($request as $val){
                $re = $val;
                $re['order_code'] = $order;
                $this->purorderRepo->create($re);
            }
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
    public function card_binding($request){
        try{
            $res = $this->oilcardRepo->findWhere(['oil_card_code'=>$request['list']['oil_card_code']])->count();
            if($res == 0){
                $this->oilcardRepo->create($request['list']);
                return ['code' => '200','message' => '添加成功'];
            }else{
                return ['code' => '500','message' => '此卡已存在'];
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
        $results = $this->oilcardRepo->all();
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

    public function directly_order($request){
        $result = $request['list'];
        foreach($result as $key=>$value){
            $arr = implode(',',$value['oil_card_code']);
            $result[$key]['oil_card_code'] = $arr;
        }
        $results = $this->service->add($result);
        return $results;
    }
    //获取卡密订单详情
    public function get_camilo_detail(){
        $order_code = request('order','');
        $results['data'] = DB::table('purchasing_camilo_detail')
                    ->join('supply_cam','purchasing_camilo_detail.camilo_id','=','supply_cam.id')
                    ->join('platform','platform.id','=','supply_cam.platform_id')
                    ->join('platform_money','platform_money.id','=','supply_cam.denomination')
                    ->where('purchasing_camilo_detail.order_code','=',$order_code)
                    ->select('platform.platform_name', 'platform_money.denomination','supply_cam.cam_name','supply_cam.id','supply_cam.cam_two_name','supply_cam.status')
                    ->get();
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
        'select from supplier_order a inner join oil_card_code b on card_code=card_code where 
         b.user_id=X and a.time< and a.time> group by order_code';
    }
    /*圈存详细数据*/
    public function get_initialize_detail(){
        'select from supplier_order where card_code=X and a.time< and a.time>';
        'select from initialize where card_code=X and a.time< and a.time>';
    }
    public function set_initialize_data(){
        'inset into initialize () values()';
    }
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
    /*采购商直充长期查询*/
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
}