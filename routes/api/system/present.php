<?php
$router->group(['prefix' => 'present','as' => 'present'],function($router){

    /*提现管理列表*/
    $router->get('index',[
       'uses' => 'System\Supply\PresentManagementController@index',
       'as' => 'index',
    ]);

    /*提现管理修改金额*/
    $router->post('update',[
        'uses' => 'System\Supply\PresentManagementController@update',
        'as' => 'update',
    ]);
});