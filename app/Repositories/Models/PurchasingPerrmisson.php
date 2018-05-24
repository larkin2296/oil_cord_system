<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PurchasingPerrmisson.
 *
 * @package namespace App\Repositories\Models;
 */
class PurchasingPerrmisson extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'purchasing_perrmission';
    protected $fillable = ['id','user_id','recharge_camilo','recharge_short_directly','recharge_long_directly','pay_camilo','pay_directly'];


}
