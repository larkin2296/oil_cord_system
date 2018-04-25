<?php

namespace App\Repositories\Presenters;

use App\Repositories\Transformers\RelationPlatformTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class RelationPlatformPresenter.
 *
 * @package namespace App\Repositories\Presenters;
 */
class RelationPlatformPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RelationPlatformTransformer();
    }
}
