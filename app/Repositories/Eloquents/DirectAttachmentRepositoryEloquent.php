<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\direct_attachmentRepository;
use App\Repositories\Models\DirectAttachment;
use App\Repositories\Validators\DirectAttachmentValidator;

/**
 * Class DirectAttachmentRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class DirectAttachmentRepositoryEloquent extends BaseRepository implements DirectAttachmentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DirectAttachment::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return DirectAttachmentValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
