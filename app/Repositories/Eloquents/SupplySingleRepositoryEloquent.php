<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\SupplySingleRepository;
use App\Repositories\Models\SupplySingle;
use App\Repositories\Validators\SupplySingleValidator;

/**
 * Class SupplySingleRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class SupplySingleRepositoryEloquent extends BaseRepository implements SupplySingleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SupplySingle::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return SupplySingleValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
