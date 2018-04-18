<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\PurchasingOrderRepository;
use App\Repositories\Models\PurchasingOrder;
use App\Repositories\Validators\PurchasingOrderValidator;

/**
 * Class PurchasingOrderRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class PurchasingOrderRepositoryEloquent extends BaseRepository implements PurchasingOrderRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PurchasingOrder::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
