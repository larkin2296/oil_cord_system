<?php

namespace App\Repositories\Transformers;

use League\Fractal\TransformerAbstract;
use App\Repositories\Models\PresentSetting;

/**
 * Class PresentSettingTransformer.
 *
 * @package namespace App\Repositories\Transformers;
 */
class PresentSettingTransformer extends TransformerAbstract
{
    /**
     * Transform the PresentSetting entity.
     *
     * @param \App\Repositories\Models\PresentSetting $model
     *
     * @return array
     */
    public function transform(PresentSetting $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
