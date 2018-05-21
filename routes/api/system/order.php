<?php
$router->group(['prefix' => 'order','as' => 'order'],function($router){
   #TODO 卡密

   /*卡密列表*/
   $router->match(['get','post'],'index',[
       'uses' => 'System\Supply\OrderManagementController@index',
       'as' => 'index',

   ]);
    /*直充查询*/
    $router->match(['get','post'],'show',[
        'uses' => 'System\Supply\OrderManagementController@show',
        'as' => 'show',

    ]);
});