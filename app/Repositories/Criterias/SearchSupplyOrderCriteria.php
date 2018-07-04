<?php

namespace App\Repositories\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FilterCompanyIdCriteria
 * @package namespace App\Repositories\Criterias;
 */
class SearchSupplyOrderCriteria implements CriteriaInterface
{
  
    public function __construct($key, $value)
    {
 
    }
    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        
    }
}
