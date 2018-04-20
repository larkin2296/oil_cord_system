<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class UserOilCard.
 *
 * @package namespace App\Repositories\Models;
 */
class UserOilCard extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'user_oil_card';
    protected $fillable = ['id','user_id','serial_number','oil_card_code','identity_card','ture_name','web_account','web_password','card_status','is_longtrem','recharge_num','recharge_today_num'];


}
