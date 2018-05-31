<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\JurisdictionRepository;
use App\Repositories\Models\Jurisdiction;
use App\Repositories\Validators\JurisdictionValidator;

/**
 * Class JurisdictionRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class JurisdictionRepositoryEloquent extends BaseRepository implements JurisdictionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Jurisdiction::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return JurisdictionValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
