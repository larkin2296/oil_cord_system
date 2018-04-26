<?php

namespace App\Repositories\Presenters;

use App\Repositories\Transformers\SupplyCamTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SupplyCamPresenter.
 *
 * @package namespace App\Repositories\Presenters;
 */
class SupplyCamPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SupplyCamTransformer();
    }
}
