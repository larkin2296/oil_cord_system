<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\PurchasingCamiloDetailRepository;
use App\Repositories\Models\PurchasingCamiloDetail;
use App\Repositories\Validators\PurchasingCamiloDetailValidator;

/**
 * Class PurchasingCamiloDetailRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class PurchasingCamiloDetailRepositoryEloquent extends BaseRepository implements PurchasingCamiloDetailRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PurchasingCamiloDetail::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
