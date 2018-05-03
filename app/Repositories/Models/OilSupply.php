<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class OilSupply.
 *
 * @package namespace App\Repositories\Models;
 */
class OilSupply extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'oil_supply';

    protected $fillable = [
        'user_id','oil_id','status'
    ];

    /**
     * 油卡表
     * return [type][deception]
     */
    public function hasManyOilCard()
    {
        return $this->hasMany(UserOilCard::class,'id','oil_id');
    }

    /**
     * 供应商油卡
     * return [type][deception]
     */
    public function hasManySupplySingle()
    {
        return $this->hasMany(UserOilCard::class,'suoil_id','id');
    }
}
