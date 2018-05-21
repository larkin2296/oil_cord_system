<?php
$router->group(['prefix' => 'supply','as' => 'supply'],function($router){

    /*订单管理*/
    require(__DIR__.'/order.php');

    /*提现管理*/
    require(__DIR__.'/present.php');

});