<?php

namespace App\Repositories\Presenters;

use App\Repositories\Transformers\UserAttachmentTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class UserAttachmentPresenter.
 *
 * @package namespace App\Repositories\Presenters;
 */
class UserAttachmentPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new UserAttachmentTransformer();
    }
}
