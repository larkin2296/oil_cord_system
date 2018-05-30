<?php
$router->group([],function($router){
    /* 供应商管理 */
    require(__DIR__.'/supply.php');

    /*管理员权限*/
    require(__DIR__.'/admin.php');
});