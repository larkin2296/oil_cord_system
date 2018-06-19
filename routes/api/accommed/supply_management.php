<?php
$router->group(['prefix' => 'commodity'],function($router){

    /*平台面额*/
    $router->get('show',[
        'uses' => 'Supply\CatSupplyController@show',
        'as' => 'show',
    ]);

    /*卡密添加 单张&多张*/
    $router->post('create',[
        'uses' => 'Supply\CatSupplyController@create',
        'as' => 'create',
    ]);

    /*处理附件关系*/
    $router->match(['put','post'],'checks',[
        'uses' => 'Supply\CatSupplyController@checks',
        'as' => 'checks',
    ]);

    /*批量添加*/
    $router->match(['get','post'],'import',[
        'uses' => 'Supply\CatSupplyController@import',
        'as' => 'import',
    ]);

    /*导入回显*/
    $router->match(['get','post'],'lists',[
        'uses' => 'Supply\CatSupplyController@lists',
        'as' => 'lists',
    ]);

    /*模版导出*/
    $router->match(['get','post'],'export',[
        'uses' => 'Supply\CatSupplyController@export',
        'as' => 'export',
    ]);

    $router->match(['get','post'],'export_card',[
        'uses' => 'Supply\CatSupplyController@export_card',
        'as' => 'export_card',
    ]);


    /*直充供货*/
    $router->match(['get','post'],'charge',[
        'uses' => 'Supply\CatSupplyController@charge',
        'as' => 'charge',
    ]);

    /*获取油卡*/
    $router->post('relationship',[
       'uses' => 'Supply\CatSupplyController@relationship',
        'as' => 'relationship',
    ]);
});