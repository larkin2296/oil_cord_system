<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\auditRepository;
use App\Repositories\Models\Audit;
use App\Repositories\Validators\AuditValidator;

/**
 * Class AuditRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class AuditRepositoryEloquent extends BaseRepository implements AuditRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Audit::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return AuditValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
