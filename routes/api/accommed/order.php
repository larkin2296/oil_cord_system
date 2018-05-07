<?php
$router->group(['prefix' => 'verb'],function($router){

    /*卡密供货查询*/
    $router->post('index',[
        'uses' => 'Supply\OrderController@index',
        'as' => 'index',
    ]);

    /*供货详情*/
    $router->get('{id}/show',[
        'uses' => 'Supply\OrderController@show',
        'as' => 'index',
    ]);

    /*直充供货查询*/
    $router->post('charge',[
        'uses' => 'Supply\OrderController@charge',
        'as' => 'charge',
    ]);

    /*直充详情*/
    $router->get('{id}/attachmentCharge',[
        'uses' => 'Supply\OrderController@attachmentCharge',
        'as' => 'attachmentCharge',
    ]);
});