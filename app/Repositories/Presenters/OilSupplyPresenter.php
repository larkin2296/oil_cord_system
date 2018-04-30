<?php

namespace App\Repositories\Presenters;

use App\Repositories\Transformers\OilSupplyTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class OilSupplyPresenter.
 *
 * @package namespace App\Repositories\Presenters;
 */
class OilSupplyPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OilSupplyTransformer();
    }
}
