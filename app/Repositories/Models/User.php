<?php

namespace App\Repositories\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class User.
 *
 * @package namespace App\Repositories\Models;
 */
class User extends Model implements Transformable
{
    use TransformableTrait,ModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';

    protected $fillable = [
    	'name','truename','sex','mobile','email','is_auth','notes','password','avatar','invitation_code','city',
    	'role_status','status','auth_papers','qq_num','alipay'

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


}
