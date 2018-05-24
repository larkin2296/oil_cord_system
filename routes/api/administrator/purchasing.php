<?php
$router->group(['prefix' => 'purchasing'],function($router){

    /*卡密供货查询*/
    $router->post('get_camilo',[
        'uses' => 'Administrator\PurchasingController@get_camilo',
        'as' => 'get_camilo',
    ]);

    /*直充供货查询*/
    $router->post('get_directly',[
        'uses' => 'Administrator\PurchasingController@get_directly',
        'as' => 'get_directly',
    ]);
    /*卡密下发*/
    $router->post('send_camilo',[
        'uses' => 'Administrator\PurchasingController@send_camilo',
        'as' => 'send_camilo',
    ]);
    /*油卡获取*/
    $router->post('get_purchasing_card',[
        'uses' => 'Administrator\PurchasingController@get_purchasing_card',
        'as' => 'get_purchasing_card',
    ]);
    /*采购商用户权限获取*/
    $router->post('get_purchasing_user',[
        'uses' => 'Administrator\PurchasingController@get_purchasing_user',
        'as' => 'get_purchasing_user',
    ]);
    /*修改采购商权限*/
    $router->post('set_user_perrmission',[
        'uses' => 'Administrator\PurchasingController@set_user_perrmission',
        'as' => 'set_user_perrmission',
    ]);
});