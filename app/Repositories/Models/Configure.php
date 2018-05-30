<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Configure.
 *
 * @package namespace App\Repositories\Models;
 */
class Configure extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'configure';

    protected $fillable = [
        'sdirectly_price_up', 'sdirectly_price_down','sdirectly_day','camilo_recharge','camilo_sell','ldirectly_discount','sdirectly_discount_up','sdirectly_discount_down'
    ];
}
