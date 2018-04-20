<?php

$router->group([],function($router){

    /*订单查询*/
    $router->get('index',[
       'uses' => 'Supply/OrderController@index',
        'as' => 'index',
    ]);


});