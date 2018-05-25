<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class SupplyCam.
 *
 * @package namespace App\Repositories\Models;
 */
class SupplyCam extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'supply_cam';


    protected $fillable = [
        'cam_name','status','remark','platform_id','denomination','user_id','success_time','status','cam_other_name',
        'discount','actual_money','forward_status', 'role_status',
    ];

    /**
     *面额
     *return [type][deception]
     */
    public function denomination()
    {
        return $this->hasOne(PlatformMoney::class,'id','denomination');
    }

    /**
     *平台
     *return [type][deception]
     */
    public function platform()
    {
        return $this->hasOne(Platform::class,'id','platform_id');
    }


}
