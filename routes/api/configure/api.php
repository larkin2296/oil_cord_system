<?php


$router->group([],function($router){

    /*获取平台信息*/
    $router->match(['get','post'],'get_platform_list',[
        'uses' => 'Configure\ConfigureController@get_platform_list',
        'as' => 'get_platform_list',
    ]);

    /*获取面额信息*/
    $router->match(['get','post'],'get_denomination_list',[
        'uses' => 'Configure\ConfigureController@get_denomination_list',
        'as' => 'get_denomination_list',
    ]);

    /*添加平台信息*/
    $router->match(['get','post'],'add_platform',[
        'uses' => 'Configure\ConfigureController@add_platform',
        'as' => 'add_platform',
    ]);

    /*添加面额信息*/
    $router->match(['get','post'],'add_denomination',[
        'uses' => 'Configure\ConfigureController@add_denomination',
        'as' => 'add_denomination',
    ]);

    /*获取页面配置信息*/
    $router->match(['get','post'],'get_config_detail',[
        'uses' => 'Configure\ConfigureController@get_config_detail',
        'as' => 'get_config_detail',
    ]);

        /*获取油卡信息*/
    $router->post('get_oil_card',[
        'uses' => 'Configure\ConfigureController@get_oil_card',
        'as' => 'get_oil_card',
    ]);

    /*获取商品配置信息*/
    $router->post('get_config_set',[
        'uses' => 'Configure\ConfigureController@get_config_set',
        'as' => 'get_config_set',
    ]);

    /*更改配置*/
    $router->post('save_config',[
        'uses' => 'Configure\ConfigureController@save_config',
        'as' => 'save_config',
    ]);
});