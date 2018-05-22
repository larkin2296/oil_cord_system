<?php
$router->group(['prefix' => 'authority','as' => 'authority .'],function($router){

    /*权限管理列表*/
    $router->get('index',[
        'uses' => 'System\Supply\AuthorityController@index',
        'as' => 'index',
    ]);


});