<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Inventory.
 *
 * @package namespace App\Repositories\Models;
 */
class Inventory extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'inventory';

    protected $fillable = [
        'platform_id','denomination_id','num','vaild_num','invalid_num'
    ];

}
