<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\UserOilCardRepository;
use App\Repositories\Models\UserOilCard;
use App\Repositories\Validators\UserOilCardValidator;

/**
 * Class UserOilCardRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class UserOilCardRepositoryEloquent extends BaseRepository implements UserOilCardRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserOilCard::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
