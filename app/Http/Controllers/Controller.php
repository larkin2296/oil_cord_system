<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct() {
        header("Access-Control-Allow-Origin: *");
        header('content-type:application/json;charset=utf8');
        header('Access-Control-Allow-Credentials', 'true');
        header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, OPTIONS');
        header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept');

    }
}
