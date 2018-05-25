<?php
$router->group(['prefix' => 'authority','as' => 'authority .'],function($router){

    /*权限管理列表*/
    $router->get('index',[
        'uses' => 'System\Supply\AuthorityController@index',
        'as' => 'index',
    ]);

    /*权限管理修改*/
    $router->post('store',[
        'uses' => 'System\Supply\AuthorityController@store',
        'as' => 'store',
    ]);

});