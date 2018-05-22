<?php
$router->group(['prefix' => 'purchasing'],function($router){

    /*卡密供货查询*/
    $router->post('get_camilo',[
        'uses' => 'Administrator\PurchasingController@get_camilo',
        'as' => 'get_camilo',
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
    /*采购商用户获取*/
    $router->post('get_purchasing_user',[
        'uses' => 'Administrator\PurchasingController@get_purchasing_user',
        'as' => 'get_purchasing_user',
    ]);

});