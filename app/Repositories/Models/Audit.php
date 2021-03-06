<?php

namespace App\Repositories\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Audit.
 *
 * @package namespace App\Repositories\Models;
 */
class Audit extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'audit';

    protected $fillable = [
        'user_id',  'status',
    ];

    /**
     * 审核用户
     * return [type] [deception]
     */
    public function checkUsers()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

}
