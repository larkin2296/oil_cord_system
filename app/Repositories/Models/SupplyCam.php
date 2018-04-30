<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class SupplyCam.
 *
 * @package namespace App\Repositories\Models;
 */
class SupplyCam extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'supply_cam';
    protected $fillable = [
        'supply_id','cam_name','status','remark','platform_id','denomination'
    ];

}
