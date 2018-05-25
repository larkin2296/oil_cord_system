<?php

namespace App\Repositories\Transformers;

use League\Fractal\TransformerAbstract;
use App\Repositories\Models\Audit;

/**
 * Class AuditTransformer.
 *
 * @package namespace App\Repositories\Transformers;
 */
class AuditTransformer extends TransformerAbstract
{
    /**
     * Transform the Audit entity.
     *
     * @param \App\Repositories\Models\Audit $model
     *
     * @return array
     */
    public function transform(Audit $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
