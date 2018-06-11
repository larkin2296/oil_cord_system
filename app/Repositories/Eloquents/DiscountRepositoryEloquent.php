<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\DiscountRepository;
use App\Repositories\Models\Discount;
use App\Repositories\Validators\DiscountValidator;

/**
 * Class DiscountRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class DiscountRepositoryEloquent extends BaseRepository implements DiscountRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Discount::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
