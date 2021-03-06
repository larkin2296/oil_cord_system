<?php
namespace App\Services\Api;
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
class UserService extends Service
{
    use ServiceTrait, ResultTrait, ExceptionTrait, UserTrait,CodeTrait,EncryptTrait;
    public $disk = 'public';
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * 更改手机号绑定
     * @return [type] [description]
     */
    public function editMobile()
    {
        $exception =  DB::transaction(function() {
            $mobile = request('mobile','');
            $code = request('code','');
            /*获取请求资源用户*/
            $user = $this->jwtUser();

            //验证验证码
            $this->checkCode('editMobile', $mobile, $code);

            $result = $this->userRepo->update(['mobile'=>$mobile],$user->id);
            if ($result) {
                return ['code' => '200','message' => '修改成功'];
            } else {
                return ['message' => '修改失败'];
            }
        });

        return array_merge($this->results, $exception);
    }

    /**
     * 个人信息
     * @return [type] [description]
     */
    public function userInfo()
    {
        $user = $this->jwtUser();

        $result = $this->userRepo->find($user->id);

        $attachments =  $user::where('id',$user->id)->orderBy('created_at','desc')->get()->map(function($item, $key) {
          $attachmentBuilds = $item->attachments->isNotEmpty() ? $item->attachments : collect([]);

           /*构造数组*/
           $attachmentCache = array();
           /*处理读取附件*/
           foreach ( $attachmentBuilds as $value ) {
               $attachmentCache[] = route('common.attach.show', [$value->id_hash]);
           }
           return $attachmentCache;

        });
        // 头像路径
        $data = [
            'id' => $result->id ?: $result->id,
            'name' => $result->truename ?: $result->mobile,
            'truename' => $result->truename ?: $result->mobile,
            'sex' => $result->sex ? $result->sex: '',
            'mobile' => $result->mobile,
            'email' => $result->email ? $result->email : '',
            'alipay' => $result->alipay ? $result->alipay : '',
            'qq_num' => $result->qq_num ? $result->qq_num : '',
            'grade' => $result->grade ? $result->grade : '',
            'notes' => $result->notes ? $result->notes : '',
            'roles' => $result->role_status ? [$result->role_status] : '',
            'status_examine' => $result->status_examine ? $result->status_examine : '',
            'avatar' => dealAvatar($result->avatar),
            'attachments' => $attachments,

        ];
        return array_merge($this->results,['code' => '200','data' => $data,'message' => '请求成功']);

    }
    function notnull($data)
    {
        foreach($data as $key => &$item){
            if( is_array($item) ) {
                 $this->notnull($item);
            } else {
                if($item === null){
                    unset($data[$key]);
                }
            }
            return $data;
        }
    }
    /**
     * 完善用户信息
     * @return [type] [description]
     */
    public function updateUser()
    {
        $exception = DB::transaction(function() {
            /*获取用户信息*/
            $user = $this->jwtUser();
            /*附件id*/
            $attachment_id = request()->post('attachment_id',[]);
            $arr = [
              'truename' => request()->post('truename',''),
              'sex' => request()->post('sex',''),
              'alipay' => request()->post('alipay',''),
              'qq_num' => request()->post('qq_num',''),
              'city' => request()->post('city',''),
              'id_card' => request()->post('id_card',''),
            ];

            if ( $data = $this->userRepo->update($arr,$user->id) ) {
                /*抛出修改个人信息事件*/
                event(new \App\Events\User($user, $attachment_id, $data));
            } else {
                throw new Exception ('修改失败，请稍后再试' );
            }
            return ['code' => '200' ,'massage' => '信息修改成功',];

        });

        return array_merge($this->results,$exception);
    }

    /**
     * 修改头像
     * @return [type] [description]
     */
    public function editAvatar()
    {
        $exception = DB::transaction(function () {
            $id = $this->jwtUser()->id;

            /*判断是否有文件*/
            if ( !request()->hasFile('file') ) {
                throw new Exception("找不到文件", 2);
            }

            $file = request()->file('file');

            /*上传文件路径*/
            $path = $file->store('', $this->disk);

            if ( $this->userRepo->update(['avatar'=>$path],$id) ) {
                # code...
            } else {
                throw new Exception("修改失败", 2);
            }

            /*更新用户头像*/
            return ['code' => '200','message' => '更新成功'];
        });

        return array_merge($this->results, $exception);

    }

    /**
     * 获取头像文件访问路径
     * @return [type] [description]
     */
    public function showAvatar($id)
    {
        try {
            /*获取附件信息*/
            $user = $this->userRepo->find($id);
            /*验证文件是否存在*/
            if( Storage::disk($this->disk)->exists($user->avatar) ) {
                /*获取文件*/
                $path = Storage::disk($this->disk)->path($user->avatar);
                return $path;
            } else{
                abort(404, '文件不存在');
            }
        } catch (Exception $e) {
            abort(404, '文件不存在');
        }
    }


    /**
     * 修改账户密码
     * @return [type] [description]
     */
    public function updatePasswd()
    {
        $exception = DB::transaction(function() {

            $password = request()->post('old_psd','');
            $new_password = request()->post('new_psd','');
             /*校验密码*/
            if ( $this->checkAuthPasswd($password) ) {

            } else {
                return ['code' => '500' ,'msg' => '密码不正确,请输入正确密码'];
            }
            /*更改密码*/
            if ( $data = $this->userRepo->update(['password'=>Hash::make($new_password)],$this->jwtUser()->id) ) {

            } else {
                throw new Exception ('密码修改失败，请稍后再试' );
            }
            return ['code' => '200' ,'msg' => '密码修改成功'];

        });

        return array_merge($this->results,$exception);
    }

    /**
     * 生成注册邀请链接
     * @return [type] [description]
     */
    public function setLink()
    {
        $exception = DB::transaction(function() {
            /*获取用户信息*/
            $user = $this->jwtUser();
            /*用户邀请权限正常且等级大于二级*/
            if ( $user->recommend_status == getCommonCheckValue(true) && $user->grade >= getCommonCheckValue(false) ) {

                /*生成邀请链接*/
                $regsiterLink = $this->encodeId($user->id);

            } else {
                return ['code' => '200' ,'massage' => '您的等级还不够,请保持良好记录等待下次评估'];
            }

            return ['code' => '200' ,'massage' => '生成邀请链接','data' => $regsiterLink];

        });

        return $exception;

    }

    /**
     * 查看已邀请
     * @return [type] [description]
     */
    public function show()
    {
        $exception = DB::transaction(function() {
            /*用户信息*/
            $user = $this->jwtUser();

            /*邀请人信息*/
            $registerInvite = $this->userRepo->findWhere([
                'invitation_id' => $user->id,
            ])->map(function($key,$item){
                return [
                  'name' => $item->name,
                  'time' => $item->create_time,
                  'grade' => $item->grade,
                  'status' => $item->status,
                ];
            });

            if ( $registerInvite ) {

            } else {
                return ['code' => '200' ,'massage' => '您还没有邀请任何人'];
            }

            return ['code' => '200' ,'massage' => '列表显示成功','data' => $registerInvite];

        });

        return array_merge($this->results,$exception);
    }
    /*刷新token*/
    public function updateToken()

    {
        try {

            $old_token = JWTAuth::getToken();

            $token = JWTAuth::refresh($old_token);

            JWTAuth::invalidate($old_token);

            $cacheKey = 'token';

            Cache::forever($cacheKey,$token);

        } catch (TokenExpiredException $e) {

            throw new AuthException(

                trans('errors.refresh_token_expired'), $e);

        } catch (JWTException $e) {

            throw new AuthException(

                trans('errors.token_invalid'), $e);

        }

        return response()->json(compact('token'));

    }
}