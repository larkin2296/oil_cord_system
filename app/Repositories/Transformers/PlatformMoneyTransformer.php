<?php

namespace App\Repositories\Transformers;

use League\Fractal\TransformerAbstract;
use App\Repositories\Models\PlatformMoney;

/**
 * Class PlatformMoneyTransformer.
 *
 * @package namespace App\Repositories\Transformers;
 */
class PlatformMoneyTransformer extends TransformerAbstract
{
    /**
     * Transform the PlatformMoney entity.
     *
     * @param \App\Repositories\Models\PlatformMoney $model
     *
     * @return array
     */
    public function transform(PlatformMoney $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
