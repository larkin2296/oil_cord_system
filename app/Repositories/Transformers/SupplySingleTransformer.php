<?php

namespace App\Repositories\Transformers;

use League\Fractal\TransformerAbstract;
use App\Repositories\Models\SupplySingle;

/**
 * Class SupplySingleTransformer.
 *
 * @package namespace App\Repositories\Transformers;
 */
class SupplySingleTransformer extends TransformerAbstract
{
    /**
     * Transform the SupplySingle entity.
     *
     * @param \App\Repositories\Models\SupplySingle $model
     *
     * @return array
     */
    public function transform(SupplySingle $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
