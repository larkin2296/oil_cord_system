<?php

namespace App\Repositories\Transformers;

use League\Fractal\TransformerAbstract;
use App\Repositories\Models\PresentForward;

/**
 * Class PresentForwardTransformer.
 *
 * @package namespace App\Repositories\Transformers;
 */
class PresentForwardTransformer extends TransformerAbstract
{
    /**
     * Transform the PresentForward entity.
     *
     * @param \App\Repositories\Models\PresentForward $model
     *
     * @return array
     */
    public function transform(PresentForward $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
