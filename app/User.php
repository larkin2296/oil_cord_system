<?php

namespace App;

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
