<?php

namespace App\Repositories\Transformers;

use League\Fractal\TransformerAbstract;
use App\Repositories\Models\OilSupply;

/**
 * Class OilSupplyTransformer.
 *
 * @package namespace App\Repositories\Transformers;
 */
class OilSupplyTransformer extends TransformerAbstract
{
    /**
     * Transform the OilSupply entity.
     *
     * @param \App\Repositories\Models\OilSupply $model
     *
     * @return array
     */
    public function transform(OilSupply $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
