<?php

namespace App;

use App\Repositories\Models\PurchasingOrder;
use App\Repositories\Models\UserOilCard;
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
    	'role_status','status','auth_papers','qq_num','alipay', 'cam_permission', 'long_term_permission',
        'recommend_status', 'put_forward_premission', 'several',

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
        return $this->hasOne(\App\Repositories\Models\SupplyCam::class,'user_id','id');
    }

}
