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

    public function checkedMobile($mobile)
    {
        if( $this->model->where('mobile',$mobile)->first() ) {
            return true;
        } else {
            return false;
        }
    }
    /*验证手机号存不存在*/
    public function issetMobile($mobile)
    {
        if( $this->model->where('mobile',$mobile)->first() ) {
            return false;
        } else {
            return true;
        }
    }


    /**
     * 供应商关系
     * @return [type] [deception]
     */
    public function supplierCardPermissions($user_id)
    {
        $results = $this->model()->where(function($query) use ($user_id){
            return $query->whereHas('supplierCardPermissions',function($query) use ($user_id){
                return $query->where('user_id',$user_id);
            });
        });
        $this->resetModel();

        return $results;
    }
    
}
