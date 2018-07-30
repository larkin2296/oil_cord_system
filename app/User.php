<?php

namespace App;

use App\Repositories\Models\Attachment;
use App\Repositories\Models\Audit;
use App\Repositories\Models\PurchasingOrder;
use App\Repositories\Models\SupplyCam;
use App\Repositories\Models\UserAttachment;
use App\Repositories\Models\UserOilCard;
use App\Services\SaleAttachmentService;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelTrait;
//use App\RepositoriesModels\ThirdAccount;


/**
 * Class User.
 *
 * @package namespace App\Repositories\Models;
 */
class User extends Authenticatable implements Transformable
{
    use LaratrustUserTrait;
    use Notifiable;
    use TransformableTrait;
    use SoftDeletes;
    use ModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';

    protected $fillable = [
    	'name','truename','sex','mobile','email','is_auth','notes','password','avatar','invitation_id','city',
    	'role_status', 'status', 'auth_papers', 'qq_num', 'alipay', 'cam_permission', 'long_term_permission',
        'recommend_status', 'put_forward_premission', 'several', 'status_examine', 'id_card', 'recharge_camilo',
        'recharge_short_directly', 'recharge_long_directly', 'pay_camilo', 'pay_directly', 'whether_status'

    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];


    public function getIdHashAttribute()
    {
        return $this->encodeId('user', $this->id);
    }

    /**
     *用户订单
     * @return [type] [description]
     */
    public function hasManyUserOrder()
    {
        return $this->hasMany(PurchasingOrder::class,'id','user_id');
    }

    /**
     * 供应商卡密权限
     * return [type] [deception]
     */
    public function supplierCardPermissions()
    {
        return $this->hasOne(SupplyCam::class,'user_id','id');
    }

    /**
     * 审核用户
     * return [type] [deception]
     */
    public function checkUserInfo()
    {
        return $this->hasOne(Audit::class,'user_id','id');
    }

    /**
     * 用户附件信息
     * @return [type] [deception]
     */
    public function attachments()
    {
        return $this->belongsToMany(\App\Repositories\Models\Attachment::class,'user_attachment','user_id','attachment_id');
    }

    /**
     * 管理员权限
     * return [type] [deception]
     */
    public function jurisdiction()
    {
        return $this->hasOne(\App\Repositories\Models\Jurisdiction::class,'user_id','id');
    }
}
