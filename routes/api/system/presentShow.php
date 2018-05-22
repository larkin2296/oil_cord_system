<?php
$router->group(['prefix' => 'presentShow','as' => 'presentShow .'],function($router){

    /*提现管理列表*/
    $router->get('index',[
        'uses' => 'System\Supply\PresentShowsController@index',
        'as' => 'index',
    ]);

    /*提现管理修改金额*/
    $router->post('update',[
        'uses' => 'System\Supply\PresentShowsController@update',
        'as' => 'update',
    ]);
});