<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PurchasingCamiloDetail.
 *
 * @package namespace App\Repositories\Models;
 */
class PurchasingCamiloDetail extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'purchasing_camilo_detail';
    protected $fillable = ['order_code','camilo_id','is_used','is_problem','created_at','updated_at'];

}
