<?php

namespace App\Repositories\Transformers;

use League\Fractal\TransformerAbstract;
use App\Repositories\Models\Notice;

/**
 * Class NoticeTransformer.
 *
 * @package namespace App\Repositories\Transformers;
 */
class NoticeTransformer extends TransformerAbstract
{
    /**
     * Transform the Notice entity.
     *
     * @param \App\Repositories\Models\Notice $model
     *
     * @return array
     */
    public function transform(Notice $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
