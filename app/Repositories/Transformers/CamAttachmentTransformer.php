<?php

namespace App\Repositories\Transformers;

use League\Fractal\TransformerAbstract;
use App\Repositories\Models\CamAttachment;

/**
 * Class CamAttachmentTransformer.
 *
 * @package namespace App\Repositories\Transformers;
 */
class CamAttachmentTransformer extends TransformerAbstract
{
    /**
     * Transform the CamAttachment entity.
     *
     * @param \App\Repositories\Models\CamAttachment $model
     *
     * @return array
     */
    public function transform(CamAttachment $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
