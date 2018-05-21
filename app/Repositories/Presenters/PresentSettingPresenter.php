<?php

namespace App\Repositories\Presenters;

use App\Repositories\Transformers\PresentSettingTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PresentSettingPresenter.
 *
 * @package namespace App\Repositories\Presenters;
 */
class PresentSettingPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PresentSettingTransformer();
    }
}
