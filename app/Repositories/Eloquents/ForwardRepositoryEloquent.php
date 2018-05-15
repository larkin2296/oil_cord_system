<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\ForwardRepository;
use App\Repositories\Models\Forward;
use App\Repositories\Validators\ForwardValidator;

/**
 * Class ForwardRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class ForwardRepositoryEloquent extends BaseRepository implements ForwardRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Forward::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ForwardValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
