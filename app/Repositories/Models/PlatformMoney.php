<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PlatformMoney.
 *
 * @package namespace App\Repositories\Models;
 */
class PlatformMoney extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'platform_money';

    protected $fillable = [
        'denomination','status'
    ];


}
