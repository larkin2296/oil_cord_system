<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\noticeRepository;
use App\Repositories\Models\Notice;
use App\Repositories\Validators\NoticeValidator;

/**
 * Class NoticeRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class NoticeRepositoryEloquent extends BaseRepository implements NoticeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Notice::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return NoticeValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
