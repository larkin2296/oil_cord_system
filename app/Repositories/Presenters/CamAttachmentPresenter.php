<?php

namespace App\Repositories\Presenters;

use App\Repositories\Transformers\CamAttachmentTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CamAttachmentPresenter.
 *
 * @package namespace App\Repositories\Presenters;
 */
class CamAttachmentPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CamAttachmentTransformer();
    }
}
