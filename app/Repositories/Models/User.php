<?php

namespace App\Repositories\Models;

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
    use TransformableTrait;

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

}
