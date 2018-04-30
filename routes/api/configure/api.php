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
});