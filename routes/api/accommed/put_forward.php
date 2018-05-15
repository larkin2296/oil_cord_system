<?php
$router->group(['prefix' => 'forward'],function ($router){

    /*发起提现列表*/
    $router->match(['get','post'],'index',[
       'uses' => 'Supply\ForwardController@index',
       'as' => 'index',
    ]);

    /*提现金额*/
    $router->post('edit',[
        'uses' => 'Supply\ForwardController@edit',
        'as' => 'edit',
    ]);

    /*提现*/
    $router->post('store',[
        'uses' => 'Supply\ForwardController@store',
        'as' => 'store',
    ]);


    /*提现记录*/
    $router->post('show',[
        'uses' => 'Supply\ForwardController@show',
        'as' => 'show',
    ]);
});