<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class SupplySingle.
 *
 * @package namespace App\Repositories\Models;
 */
class SupplySingle extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'supply_single';

    protected $fillable = [
        'supply_single_number','supply_state','oil_card','start_time','notes','end_time','already_card','remarks',
        'direct_id','status','suoil_id','oil_number','user_id','forward_status','discount',
    ];

    /**
     * 直充附件
     * return [type] [deception]
     */
     public function attachmentCharge()
     {
         return $this->hasOne(Attachment::class,'id','direct_id');
     }
}
