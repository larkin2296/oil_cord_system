<?php

namespace App\Repositories\Presenters;

use App\Repositories\Transformers\PlatformMoneyTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PlatformMoneyPresenter.
 *
 * @package namespace App\Repositories\Presenters;
 */
class PlatformMoneyPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PlatformMoneyTransformer();
    }
}
