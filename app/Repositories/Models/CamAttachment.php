<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CamAttachment.
 *
 * @package namespace App\Repositories\Models;
 */
class CamAttachment extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'cam_attachment';

    protected $fillable = [
        'cam_id', 'attachment_id',
    ];




}
