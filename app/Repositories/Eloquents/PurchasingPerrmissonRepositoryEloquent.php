<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\PurchasingPerrmissonRepository;
use App\Repositories\Models\PurchasingPerrmisson;
use App\Repositories\Validators\PurchasingPerrmissonValidator;

/**
 * Class PurchasingPerrmissonRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class PurchasingPerrmissonRepositoryEloquent extends BaseRepository implements PurchasingPerrmissonRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PurchasingPerrmisson::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
