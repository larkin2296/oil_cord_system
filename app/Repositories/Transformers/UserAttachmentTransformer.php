<?php

namespace App\Repositories\Transformers;

use League\Fractal\TransformerAbstract;
use App\Repositories\Models\UserAttachment;

/**
 * Class UserAttachmentTransformer.
 *
 * @package namespace App\Repositories\Transformers;
 */
class UserAttachmentTransformer extends TransformerAbstract
{
    /**
     * Transform the UserAttachment entity.
     *
     * @param \App\Repositories\Models\UserAttachment $model
     *
     * @return array
     */
    public function transform(UserAttachment $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
