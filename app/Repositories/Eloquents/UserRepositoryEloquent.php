<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\UserRepository;
use App\User;
use App\Repositories\Validators\UserValidator;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return UserValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    /*验证手机号是否注册*/

    public function checkMobile($mobile)
    {
        if( $this->model->where('mobile',$mobile)->first() ) {
            return true;
        } else {
            return false;
        }
    }
    
}
