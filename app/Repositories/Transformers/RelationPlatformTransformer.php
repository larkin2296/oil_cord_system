<?php

namespace App\Repositories\Transformers;

use League\Fractal\TransformerAbstract;
use App\Repositories\Models\RelationPlatform;

/**
 * Class RelationPlatformTransformer.
 *
 * @package namespace App\Repositories\Transformers;
 */
class RelationPlatformTransformer extends TransformerAbstract
{
    /**
     * Transform the RelationPlatform entity.
     *
     * @param \App\Repositories\Models\RelationPlatform $model
     *
     * @return array
     */
    public function transform(RelationPlatform $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
