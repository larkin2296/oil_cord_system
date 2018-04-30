<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\OilSupplyRepository;
use App\Repositories\Models\OilSupply;
use App\Repositories\Validators\OilSupplyValidator;

/**
 * Class OilSupplyRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class OilSupplyRepositoryEloquent extends BaseRepository implements OilSupplyRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OilSupply::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return OilSupplyValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
