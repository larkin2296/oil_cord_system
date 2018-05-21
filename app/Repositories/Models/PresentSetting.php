<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PresentSetting.
 *
 * @package namespace App\Repositories\Models;
 */
class PresentSetting extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'present_setting';

    protected $fillable = [
        'upper_money', 'lower_money', 'status', 'deductions', 'greater_money', 'proportion'
    ];

}
