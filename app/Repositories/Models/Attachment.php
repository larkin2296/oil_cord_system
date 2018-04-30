<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Attachment.
 *
 * @package namespace App\Repositories\Models;
 */
class Attachment extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'cam_attachment';

    protected $fillable = [
        'name','origin_name','size','ext','ext_info','path','user_id','created_at',
    ];

}
