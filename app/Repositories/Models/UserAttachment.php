<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class UserAttachment.
 *
 * @package namespace App\Repositories\Models;
 */
class UserAttachment extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'user_attachment';

    protected $fillable = [
        'user_id', 'attachment_id', 'status'
    ];

}
