<?php

namespace App\Repositories\Presenters;

use App\Repositories\Transformers\JurisdictionTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class JurisdictionPresenter.
 *
 * @package namespace App\Repositories\Presenters;
 */
class JurisdictionPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new JurisdictionTransformer();
    }
}
