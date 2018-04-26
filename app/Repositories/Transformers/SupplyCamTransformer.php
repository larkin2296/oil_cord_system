<?php

namespace App\Repositories\Transformers;

use League\Fractal\TransformerAbstract;
use App\Repositories\Models\SupplyCam;

/**
 * Class SupplyCamTransformer.
 *
 * @package namespace App\Repositories\Transformers;
 */
class SupplyCamTransformer extends TransformerAbstract
{
    /**
     * Transform the SupplyCam entity.
     *
     * @param \App\Repositories\Models\SupplyCam $model
     *
     * @return array
     */
    public function transform(SupplyCam $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
