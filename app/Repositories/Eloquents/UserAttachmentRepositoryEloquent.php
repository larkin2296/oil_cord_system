<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Interfaces\UserAttachmentRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\user_attachmentRepository;
use App\Repositories\Models\UserAttachment;
use App\Repositories\Validators\UserAttachmentValidator;

/**
 * Class UserAttachmentRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class UserAttachmentRepositoryEloquent extends BaseRepository implements UserAttachmentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserAttachment::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return UserAttachmentValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
