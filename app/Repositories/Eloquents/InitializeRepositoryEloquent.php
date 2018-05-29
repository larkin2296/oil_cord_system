<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\InitializeRepository;
use App\Repositories\Models\Initialize;
use App\Repositories\Validators\InitializeValidator;

/**
 * Class InitializeRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class InitializeRepositoryEloquent extends BaseRepository implements InitializeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Initialize::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
