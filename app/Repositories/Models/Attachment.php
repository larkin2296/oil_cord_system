<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Traits\ModelTrait;

/**
 * Class Attachment.
 *
 * @package namespace App\Repositories\Models;
 */
class Attachment extends Model implements Transformable
{
    use TransformableTrait;
    use ModelTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'cam_attachment';

    protected $fillable = [
        'name','origin_name','size','ext','ext_info','path','status','user_id','created_at','updated_at','deleted_at'
    ];

    protected $appends = ['id_hash'];

    public function getIdHashAttribute()
    {
        return $this->encodeId('attachment', $this->id);
    }

}
