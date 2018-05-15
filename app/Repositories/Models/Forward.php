<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Forward.
 *
 * @package namespace App\Repositories\Models;
 */
class Forward extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'forward';

    protected $fillable = [
        'forward_number','status','money', 'user_id',
    ];

}
