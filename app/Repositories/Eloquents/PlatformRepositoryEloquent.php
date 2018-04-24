<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\PlatformRepository;
use App\Repositories\Models\Platform;
use App\Repositories\Validators\PlatformValidator;

/**
 * Class PlatformRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class PlatformRepositoryEloquent extends BaseRepository implements PlatformRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Platform::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PlatformValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
