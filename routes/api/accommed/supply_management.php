<?php
$router->group(['prefix' => 'commodity'],function($router){

    /*平台面额*/
    $router->get('show',[
        'uses' => 'Supply\CatSupplyController@show',
        'as' => 'show',
    ]);

    /*单张卡密添加*/
    $router->post('create',[
        'uses' => 'Supply\CatSupplyController@create',
        'as' => 'create',
    ]);

});