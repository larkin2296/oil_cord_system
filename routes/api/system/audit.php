<?php
$router->group(['prefix' => 'audit','as' => 'audit.'],function($router){

    /*审核资质列表*/
    $router->match(['get','post'],'index',[
        'uses' => 'System\Supply\AuditController@index',
        'as' => 'index',
    ]);

    /*审核资质审核*/
    $router->match(['get','post'],'store',[
        'uses' => 'System\Supply\AuditController@store',
        'as' => 'store',
    ]);

    /*删除资质*/
    $router->match(['get','post'],'destroy',[
        'uses' => 'System\Supply\AuditController@destroy',
        'as' => 'destroy',
    ]);

    /*已删除用户信息*/
    $router->match(['get','post'],'edit',[
        'uses' => 'System\Supply\AuditController@edit',
        'as' => 'edit',
    ]);

    /*恢复已删除用户*/
    $router->match(['get','post'],'restore',[
        'uses' => 'System\Supply\AuditController@restore',
        'as' => 'restore',
    ]);

    /*创建用户信息*/
    $router->match(['get','post'],'create',[
        'uses' => 'System\Supply\AuditController@create',
        'as' => 'create',
    ]);
});
