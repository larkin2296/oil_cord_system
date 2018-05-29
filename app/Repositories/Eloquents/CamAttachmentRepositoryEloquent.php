<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\cam_attachmentRepository;
use App\Repositories\Models\CamAttachment;
use App\Repositories\Validators\CamAttachmentValidator;

/**
 * Class CamAttachmentRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class CamAttachmentRepositoryEloquent extends BaseRepository implements CamAttachmentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CamAttachment::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return CamAttachmentValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
