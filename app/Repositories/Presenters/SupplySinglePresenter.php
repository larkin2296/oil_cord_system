<?php

namespace App\Repositories\Presenters;

use App\Repositories\Transformers\SupplySingleTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SupplySinglePresenter.
 *
 * @package namespace App\Repositories\Presenters;
 */
class SupplySinglePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SupplySingleTransformer();
    }
}
