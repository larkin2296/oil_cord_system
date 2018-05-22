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
});