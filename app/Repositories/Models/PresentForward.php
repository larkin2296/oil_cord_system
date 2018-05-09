<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PresentForward.
 *
 * @package namespace App\Repositories\Models;
 */
class PresentForward extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'present_forward';

    protected $fillable = [
        'forward_id','supply_id','cam_id','status'
    ];

}
