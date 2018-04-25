<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\PlatformMoneyRepository;
use App\Repositories\Models\PlatformMoney;
use App\Repositories\Validators\PlatformMoneyValidator;

/**
 * Class PlatformMoneyRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class PlatformMoneyRepositoryEloquent extends BaseRepository implements PlatformMoneyRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PlatformMoney::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PlatformMoneyValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
