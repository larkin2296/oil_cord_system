<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\PresentSettingRepository;
use App\Repositories\Models\PresentSetting;
use App\Repositories\Validators\PresentSettingValidator;

/**
 * Class PresentSettingRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class PresentSettingRepositoryEloquent extends BaseRepository implements PresentSettingRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PresentSetting::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PresentSettingValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
