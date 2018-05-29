<?php

namespace App\Repositories\Transformers;

use League\Fractal\TransformerAbstract;
use App\Repositories\Models\DirectAttachment;

/**
 * Class DirectAttachmentTransformer.
 *
 * @package namespace App\Repositories\Transformers;
 */
class DirectAttachmentTransformer extends TransformerAbstract
{
    /**
     * Transform the DirectAttachment entity.
     *
     * @param \App\Repositories\Models\DirectAttachment $model
     *
     * @return array
     */
    public function transform(DirectAttachment $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
