<?php
$router->group(['prefix' => 'audit','as' => 'audit.'],function($router){

    /*审核资质列表*/
    $router->match(['get','post'],'index',[
       'uses' => '\System\Supply\AuditController@index',
       'as' => 'index',
    ]);
});