<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class RelationPlatform.
 *
 * @package namespace App\Repositories\Models;
 */
class RelationPlatform extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'relation_platform';

    protected $fillable = [
        'supply_id','platform_id','money_id',
    ];

}
