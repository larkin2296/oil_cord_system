<?php

namespace App\Repositories\Transformers;

use League\Fractal\TransformerAbstract;
use App\Repositories\Models\Platform;

/**
 * Class PlatformTransformer.
 *
 * @package namespace App\Repositories\Transformers;
 */
class PlatformTransformer extends TransformerAbstract
{
    /**
     * Transform the Platform entity.
     *
     * @param \App\Repositories\Models\Platform $model
     *
     * @return array
     */
    public function transform(Platform $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
