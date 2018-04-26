<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\SupplyCamRepository;
use App\Repositories\Models\SupplyCam;
use App\Repositories\Validators\SupplyCamValidator;

/**
 * Class SupplyCamRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class SupplyCamRepositoryEloquent extends BaseRepository implements SupplyCamRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SupplyCam::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return SupplyCamValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
