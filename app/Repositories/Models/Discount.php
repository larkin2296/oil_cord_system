<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Discount.
 *
 * @package namespace App\Repositories\Models;
 */
class Discount extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'discount';

    protected $fillable = [
        'platform_id', 'denomination_id','camilo_recharge','camilo_sell','camilo_sell'
    ];

}
