<?php

namespace App\Repositories\Presenters;

use App\Repositories\Transformers\AttachmentTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AttachmentPresenter.
 *
 * @package namespace App\Repositories\Presenters;
 */
class AttachmentPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AttachmentTransformer();
    }
}
