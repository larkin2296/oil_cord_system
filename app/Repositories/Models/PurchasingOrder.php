<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PurchasingOrder.
 *
 * @package namespace App\Repositories\Models;
 */
class PurchasingOrder extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'purchasing_order';
    protected $fillable = ['id','order_code','user_id','price','order_type','platform','order_status','pay_time','pay_type','pay_real','unit_price','real_unit_price','discount','num','remark','pay_status','is_problem','problem_order_code','is_rush','repair_order_code','cutoff_time','oil_card_code'];

}
