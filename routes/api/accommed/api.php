<?php


$router->group([],function($router){

    /*供应商查询*/
    require(__DIR__.'/order.php');

    /*供货管理*/
    require(__DIR__.'/supply_management.php');

    /*提现管理*/
    require(__DIR__.'/put_forward.php');



});