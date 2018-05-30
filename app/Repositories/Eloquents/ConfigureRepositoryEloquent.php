<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\ConfigureRepository;
use App\Repositories\Models\Configure;
use App\Repositories\Validators\ConfigureValidator;

/**
 * Class ConfigureRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class ConfigureRepositoryEloquent extends BaseRepository implements ConfigureRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Configure::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
