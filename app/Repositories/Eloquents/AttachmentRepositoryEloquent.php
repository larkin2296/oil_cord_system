<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\AttachmentRepository;
use App\Repositories\Models\Attachment;
use App\Repositories\Validators\AttachmentValidator;
use Illuminate\Container\Container as Application;
use App\Traits\EncryptTrait;


/**
 * Class AttachmentRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class AttachmentRepositoryEloquent extends BaseRepository implements AttachmentRepository
{
    use EncryptTrait;

    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->setEncryptConnection('patientattachment');
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Attachment::class;
    }

    /*获取附件列表*/
    public function listByIds($ids, $userId)
    {
        $results = $this->model->whereIn('id', $ids)->where('user_id', $userId)->get();

        $this->resetModel();

        return $results;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
