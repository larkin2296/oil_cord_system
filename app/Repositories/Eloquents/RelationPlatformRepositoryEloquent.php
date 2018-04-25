<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\RelationPlatformRepository;
use App\Repositories\Models\RelationPlatform;
use App\Repositories\Validators\RelationPlatformValidator;

/**
 * Class RelationPlatformRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class RelationPlatformRepositoryEloquent extends BaseRepository implements RelationPlatformRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RelationPlatform::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return RelationPlatformValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
