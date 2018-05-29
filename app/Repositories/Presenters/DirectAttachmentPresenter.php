<?php

namespace App\Repositories\Presenters;

use App\Repositories\Transformers\DirectAttachmentTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DirectAttachmentPresenter.
 *
 * @package namespace App\Repositories\Presenters;
 */
class DirectAttachmentPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DirectAttachmentTransformer();
    }
}
