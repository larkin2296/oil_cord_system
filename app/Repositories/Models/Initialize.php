<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Initialize.
 *
 * @package namespace App\Repositories\Models;
 */
class Initialize extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'initialize';

    protected $fillable = [
        'user_id','in_price','card_code','in_time'
    ];

}
