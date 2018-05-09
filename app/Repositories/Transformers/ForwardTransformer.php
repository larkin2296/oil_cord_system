<?php

namespace App\Repositories\Transformers;

use League\Fractal\TransformerAbstract;
use App\Repositories\Models\Forward;

/**
 * Class ForwardTransformer.
 *
 * @package namespace App\Repositories\Transformers;
 */
class ForwardTransformer extends TransformerAbstract
{
    /**
     * Transform the Forward entity.
     *
     * @param \App\Repositories\Models\Forward $model
     *
     * @return array
     */
    public function transform(Forward $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
