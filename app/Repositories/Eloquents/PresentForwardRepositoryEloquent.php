<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\PresentForwardRepository;
use App\Repositories\Models\PresentForward;
use App\Repositories\Validators\PresentForwardValidator;

/**
 * Class PresentForwardRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class PresentForwardRepositoryEloquent extends BaseRepository implements PresentForwardRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PresentForward::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PresentForwardValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
