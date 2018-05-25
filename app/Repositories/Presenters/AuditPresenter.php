<?php

namespace App\Repositories\Presenters;

use App\Repositories\Transformers\AuditTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AuditPresenter.
 *
 * @package namespace App\Repositories\Presenters;
 */
class AuditPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AuditTransformer();
    }
}
