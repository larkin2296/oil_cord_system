<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\InventoryRepository;
use App\Repositories\Models\Inventory;
use App\Repositories\Validators\InventoryValidator;

/**
 * Class InventoryRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class InventoryRepositoryEloquent extends BaseRepository implements InventoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Inventory::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
