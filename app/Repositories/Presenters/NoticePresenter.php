<?php

namespace App\Repositories\Presenters;

use App\Repositories\Transformers\NoticeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class NoticePresenter.
 *
 * @package namespace App\Repositories\Presenters;
 */
class NoticePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new NoticeTransformer();
    }
}
