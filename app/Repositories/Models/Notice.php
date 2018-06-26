<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * Class Notice.
 *
 * @package namespace App\Repositories\Models;
 */
class Notice extends Model implements Transformable
{
    use TransformableTrait,
        SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'notice';
    protected $fillable = [
        'user_id', 'content', 'choice',
    ];

}
