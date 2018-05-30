<?php

namespace App\Repositories\Transformers;

use League\Fractal\TransformerAbstract;
use App\Repositories\Models\Jurisdiction;

/**
 * Class JurisdictionTransformer.
 *
 * @package namespace App\Repositories\Transformers;
 */
class JurisdictionTransformer extends TransformerAbstract
{
    /**
     * Transform the Jurisdiction entity.
     *
     * @param \App\Repositories\Models\Jurisdiction $model
     *
     * @return array
     */
    public function transform(Jurisdiction $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
