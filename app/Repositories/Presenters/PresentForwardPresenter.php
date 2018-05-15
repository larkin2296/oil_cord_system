<?php

namespace App\Repositories\Presenters;

use App\Repositories\Transformers\PresentForwardTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PresentForwardPresenter.
 *
 * @package namespace App\Repositories\Presenters;
 */
class PresentForwardPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PresentForwardTransformer();
    }
}
