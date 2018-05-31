<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Reconciliation.
 *
 * @package namespace App\Repositories\Models;
 */
class Reconciliation extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'reconciliation';
    protected $fillable = ['id','order_code','type','order_id','user_id','status','recon_start','recon_end','total_price','initialize_price','recharge_price'];

}
