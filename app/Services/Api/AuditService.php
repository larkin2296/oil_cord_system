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
                   'role_status' => getCommonCheckValue(false),
                ]);
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
                        'mobile' => $item->mobile ?? '',
                        'id_card' => $item->id_card ?? '',
                        'alipay' => $item->alipay ?? '',
                        'notes' => $item->notes ?? '',
                        'status_examine' => $item->status_examine ?? getCommonCheckValue(true),
                        'avatar' => dealAvatar($item->avatar) ?? '',
                        'attachments' => $attachments ?? collect([]),
                      ];
                 });
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

    /**
     * 审核状态
     * return [type] [deception]
     */
    public function store()
    {
        try{
            $exception = DB::transaction(function(){
                $status_examine = request()->post('status_examine','');
                $arr = [
                    'status_examine' => $status_examine,
                ];
                $this->checkAdminUser();

                $user = $this->userRepo->update($arr,request()->id);

                $user->save();
                return $this->results = array_merge([
                   'code' => '200',
                   'message' => '审核状态成功',
                   'data' => collect([]),
                ]);
            });
        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results,$exception);
    }

    /**
     * 逻辑删除用户信息
     * return [type] [deception]
     */
    public function destroy()
    {
        try{
            $exception = DB::transaction(function(){
                /*验证权限*/
                $this->checkAdminUser();

                if( $user = $this->userRepo->delete(request()->id) ) {

                } else {
                    throw new Exception('删除失败，请重试',2);
                }

                return $this->results = array_merge([
                    'code' => '200',
                    'message' => '删除成功',
                    'data' => collect([]),
                ]);
            });
        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results,$exception);
    }

    /**
     * 已删除用户信息
     * return [type] [deception]
     */
    public function edit()
    {
        try{
            $exception = DB::transaction(function(){
                /*验证权限*/
                $this->checkAdminUser();

                $user = $this->userRepo->model()::where('role_status',getCommonCheckValue(false))->onlyTrashed()->get();

                if( $user ) {

                } else {
                    throw new Exception('查询已删除用户失败，请重试',2);
                }

                return $this->results = array_merge([
                    'code' => '200',
                    'message' => '查询成功',
                    'data' => collect([]),
                ]);
            });
        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results,$exception);
    }


    /**
     * 恢复删除用户
     * return [type] [deception]
     */
    public function restore()
    {
        try{
            $exception = DB::transaction(function(){
                /*验证权限*/
                $this->checkAdminUser();
                $user = $this->userRepo->model()::where('id',request()->id)->restore();
                if( $user ) {

                } else {
                    throw new Exception('恢复删除用户，请重试',2);
                }

                return $this->results = array_merge([
                    'code' => '200',
                    'message' => '恢复成功',
                    'data' => collect([]),
                ]);
            });
        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results,$exception);
    }

    public function create() {
        try{
            $exception = DB::transaction(function() {
                #TODO 生成供应单记录 增加附件信息 关联上附件信息 direct_id 附件id
                /*充值油卡*/

                $res = request()->post('list','');

                /*用户信息*/
                $user = $this->jwtUser();

                $arr = [
                    'truename' => $res['true_name'],
                    'alipay' => $res['alipay'],
                    'city' => $res['city'],
                    'qq_num' => $res['qq_num'],
                    'sex' => $res['sex'],
                    'id_card' => $res['id_card']
                ];
                //更新user表字段
                $data = $this->userRepo->update($arr,$user->id);

                foreach($res['img_url'] as $val){
                    $array = [
                      'attachment_id' => $val['id']
                    ];
                    $this->userAttachmentRepo->updateOrCreate(['user_id' => $user->id,'status' => 1],$array);
                }
                foreach($res['card_url'] as $val){
                    $array = [
                        'attachment_id' => $val['id']
                    ];
                    $this->userAttachmentRepo->updateOrCreate(['user_id' => $user->id,'status' => 2],$array);
                }
                return ['code' => 200, 'message' => '提交成功', 'data' => $data];

            });

        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results,$exception);
    }
}