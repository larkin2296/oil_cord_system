<?php


$router->group([],function($router){

    /*供应商查询*/
    require(__DIR__.'/order.php');

    /*供货管理*/
    require(__DIR__.'/supply_management.php');



});