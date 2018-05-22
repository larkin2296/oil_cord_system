<?php
$router->group(['prefix' => 'order','as' => 'order'],function($router){
   #TODO 卡密

   /*卡密列表*/
   $router->match(['get','post'],'index',[
       'uses' => 'System\Supply\OrderManagementController@index',
       'as' => 'index',

   ]);

    /*删除卡密*/
    $router->post('destroy',[
        'uses' => 'System\Supply\OrderManagementController@destroy',
        'as' => 'destroy',

    ]);

    /*恢复卡密*/
    $router->post('recover',[
        'uses' => 'System\Supply\OrderManagementController@recover',
        'as' => 'recover',

    ]);


    /*直充查询*/
    $router->match(['get','post'],'show',[
        'uses' => 'System\Supply\OrderManagementController@show',
        'as' => 'show',

    ]);
});