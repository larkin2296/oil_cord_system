<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Jurisdiction.
 *
 * @package namespace App\Repositories\Models;
 */
class Jurisdiction extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'admin_jurisdiction';

    protected $fillable = [
        'user_id', 'supply_jurisdiction', 'purchase_jurisdiction', 'service_jurisdiction', 'commodity_jurisdiction',
        'status',
    ];

}
