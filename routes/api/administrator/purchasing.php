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
    /*卡密下发*/
    $router->post('stop_send_camilo',[
        'uses' => 'Administrator\PurchasingController@stop_send_camilo',
        'as' => 'stop_send_camilo',
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
    /*供应商用户权限获取*/
    $router->post('get_supplier_user',[
        'uses' => 'Administrator\PurchasingController@get_supplier_user',
        'as' => 'get_supplier_user',
    ]);
    /*修改采购商权限*/
    $router->post('set_user_perrmission',[
        'uses' => 'Administrator\PurchasingController@set_user_perrmission',
        'as' => 'set_user_perrmission',
    ]);
    /*修改供应商权限*/
    $router->post('set_supplier_perrmission',[
        'uses' => 'Administrator\PurchasingController@set_supplier_perrmission',
        'as' => 'set_supplier_perrmission',
    ]);

    /*直充短期查询*/
    $router->post('get_sdirectly',[
        'uses' => 'Administrator\PurchasingController@get_sdirectly',
        'as' => 'get_sdirectly',
    ]);
    /*短期充值*/
    $router->post('charge',[
        'uses' => 'Administrator\PurchasingController@charge',
        'as' => 'charge',
    ]);

    /*短期充值详情*/
    $router->post('get_sdirectly_detail',[
        'uses' => 'Administrator\PurchasingController@get_sdirectly_detail',
        'as' => 'get_sdirectly_detail',
    ]);

    /*身份核实*/
    $router->post('get_audit_data',[
        'uses' => 'Administrator\PurchasingController@get_audit_data',
        'as' => 'get_audit_data',
    ]);

    /*核实对账*/
    $router->post('set_reconciliation_status',[
        'uses' => 'Administrator\PurchasingController@set_reconciliation_status',
        'as' => 'set_reconciliation_status',
    ]);
});