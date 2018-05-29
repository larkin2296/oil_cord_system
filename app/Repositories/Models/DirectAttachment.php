<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class DirectAttachment.
 *
 * @package namespace App\Repositories\Models;
 */
class DirectAttachment extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'direct_attachment';

    protected $fillable = [
        'direct_id', 'attachment_id',
    ];

}
