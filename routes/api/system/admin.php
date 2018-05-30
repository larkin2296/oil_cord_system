<?php
$router->group(['prefix' => 'admin', 'as' => 'admin.'],function($router){

    /*管理员权限列表*/
    $router->get('index',[
       'uses' => 'System\Admin\AdminController@index',
       'as' => 'index',
    ]);

    /*添加管理员*/
    $router->post('create',[
        'uses' => 'System\Admin\AdminController@create',
        'as' => 'create',
    ]);

    /*设定管理员*/
    $router->post('setAdmin',[
        'uses' => 'System\Admin\AdminController@setAdmin',
        'as' => 'setAdmin',
    ]);
});