<?php
$router->group(['prefix' => 'verb'],function($router){

    /*卡密供货查询*/
    $router->get('index',[
        'uses' => 'Supply\OrderController@index',
        'as' => 'index',
    ]);
});