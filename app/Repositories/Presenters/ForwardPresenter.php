<?php

namespace App\Repositories\Presenters;

use App\Repositories\Transformers\ForwardTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ForwardPresenter.
 *
 * @package namespace App\Repositories\Presenters;
 */
class ForwardPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ForwardTransformer();
    }
}
