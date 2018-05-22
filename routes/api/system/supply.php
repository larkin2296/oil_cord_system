<?php
$router->group(['prefix' => 'supply','as' => 'supply'],function($router){

    /*订单管理*/
    require(__DIR__.'/order.php');

    /*提现管理*/
    require(__DIR__.'/present.php');

    /*提现列表*/
    require(__DIR__.'/presentShow.php');

    /*权限管理*/
    require(__DIR__.'/authority.php');

});