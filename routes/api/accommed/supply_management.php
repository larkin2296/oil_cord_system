<?php
$router->group(['prefix' => 'commodity'],function($router){

    /*平台面额*/
    $router->get('show',[
        'uses' => 'Supply\CatSupplyController@show',
        'as' => 'show',
    ]);

    /*卡密添加 单张 多张*/
    $router->post('create',[
        'uses' => 'Supply\CatSupplyController@create',
        'as' => 'create',
    ]);

    /*批量添加*/
    $router->match(['get','post'],'import',[
        'uses' => 'Supply\CatSupplyController@import',
        'as' => 'import',
    ]);

    /*模版导出*/
    $router->match(['get','post'],'export',[
        'uses' => 'Supply\CatSupplyController@export',
        'as' => 'export',
    ]);

    /*直充供货*/
    $router->match(['get','post'],'charge',[
        'uses' => 'Supply\CatSupplyController@charge',
        'as' => 'charge',
    ]);

    /*获取油卡*/
    $router->post('relationship',[
       'uses' => 'CatSupplyController@relationship',
        'as' => 'relationship',
    ]);
});