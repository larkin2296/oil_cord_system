<?php

namespace App\Traits;

use JWTAuth;
use Exception;

Trait DataTrait
{


    public function userByJwt()
    {
        return JWTAuth::parseToken()->authenticate();
    }
}