<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\ReconciliationRepository;
use App\Repositories\Models\Reconciliation;
use App\Repositories\Validators\ReconciliationValidator;

/**
 * Class ReconciliationRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class ReconciliationRepositoryEloquent extends BaseRepository implements ReconciliationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Reconciliation::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
