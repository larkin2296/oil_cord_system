<?php


$router->group([],function($router){

    /*采购商添加卡密采购*/
    $router->match(['get','post'],'camilo_order',[
        'uses' => 'Purchasing\PurchasingController@camilo_order',
        'as' => 'camilo_order',
    ]);
    /*采购商查询界面卡密查询*/
    $router->match(['get','post'],'get_camilo_order',[
        'uses' => 'Purchasing\PurchasingController@get_camilo_order',
        'as' => 'get_camilo_order',
    ]);
    /*采购商查询界面直充查询*/
    $router->match(['get','post'],'get_directy_order',[
        'uses' => 'Purchasing\PurchasingController@get_directy_order',
        'as' => 'get_directy_order',
    ]);
    /*采购商油卡绑定*/
    $router->match(['get','post'],'binding_card',[
        'uses' => 'Purchasing\PurchasingController@binding_card',
        'as' => 'binding_card',
    ]);
    /*采购商油卡上传回显*/
    $router->match(['get','post'],'get_oilcard_upload',[
        'uses' => 'Purchasing\PurchasingController@get_oilcard_upload',
        'as' => 'get_oilcard_upload',
    ]);
    /*采购商油卡*/
    $router->match(['get','post'],'get_card',[
        'uses' => 'Purchasing\PurchasingController@get_card',
        'as' => 'get_card',
    ]);
    /*采购商油卡启用*/
    $router->match(['get','post'],'card_start',[
        'uses' => 'Purchasing\PurchasingController@card_start',
        'as' => 'card_start',
    ]);
    /*采购商油卡设置为长期*/
    $router->match(['get','post'],'set_longtrem',[
        'uses' => 'Purchasing\PurchasingController@set_longtrem',
        'as' => 'set_longtrem',
    ]);
    /*获取短期采购商油卡*/
    $router->match(['get','post'],'get_short_card',[
        'uses' => 'Purchasing\PurchasingController@get_short_card',
        'as' => 'get_short_card',
    ]);

    /*采购商创建短期直充订单*/
    $router->match(['get','post'],'set_sdirectly_order',[
        'uses' => 'Purchasing\PurchasingController@directly_order',
        'as' => 'set_sdirectly_order',
    ]);
    /*采购商短期直充*/
    $router->match(['get','post'],'get_sdirecty_order',[
        'uses' => 'Purchasing\PurchasingController@sdirectly_order',
        'as' => 'get_sdirecty_order',
    ]);
    /*采购商长期直充*/
    $router->match(['get','post'],'get_ldirecty_order',[
        'uses' => 'Purchasing\PurchasingController@ldirectly_order',
        'as' => 'get_ldirecty_order',
    ]);
    /*采购商短充卡密详情*/
    $router->match(['get','post'],'get_camilo_detail',[
        'uses' => 'Purchasing\PurchasingController@get_camilo_detail',
        'as' => 'get_camilo_detail',
    ]);
    /*采购商长期直充详情*/
    $router->match(['get','post'],'get_ldirectly_detail',[
        'uses' => 'Purchasing\PurchasingController@get_ldirectly_detail',
        'as' => 'get_ldirectly_detail',
    ]);
    /*采购商短期直充详情*/
    $router->match(['get','post'],'get_sdirectly_detail',[
        'uses' => 'Purchasing\PurchasingController@get_sdirectly_detail',
        'as' => 'get_sdirectly_detail',
    ]);
    /*采购商上报错误*/
    $router->match(['get','post'],'set_problem',[
        'uses' => 'Purchasing\PurchasingController@set_problem',
        'as' => 'set_problem',
    ]);
    /*采购商圈存数据获取*/
    $router->match(['get','post'],'get_initialize',[
        'uses' => 'Purchasing\PurchasingController@get_initialize',
        'as' => 'get_initialize',
    ]);
    /*采购商圈存详情*/
    $router->match(['get','post'],'get_initialize_detail',[
        'uses' => 'Purchasing\PurchasingController@get_initialize_detail',
        'as' => 'get_initialize_detail',
    ]);
    /*采购商上报圈存*/
    $router->match(['get','post'],'set_initialize_data',[
        'uses' => 'Purchasing\PurchasingController@set_initialize_data',
        'as' => 'set_initialize_data',
    ]);
    /*采购商对账数据获取*/
    $router->match(['get','post'],'get_reconciliation',[
        'uses' => 'Purchasing\PurchasingController@get_reconciliation',
        'as' => 'get_reconciliation',
    ]);
    /*采购商卡密补发自动发货*/
    $router->match(['get','post'],'auto_recharge',[
        'uses' => 'Purchasing\PurchasingController@auto_recharge',
        'as' => 'auto_recharge',
    ]);
    /*采购商卡密标记已使用*/
    $router->match(['get','post'],'set_camilo_userd',[
        'uses' => 'Purchasing\PurchasingController@set_camilo_userd',
        'as' => 'set_camilo_userd',
    ]);

    /*采购商油卡状态更改审核*/
    $router->match(['get','post'],'confirm_status',[
        'uses' => 'Purchasing\PurchasingController@confirm_status',
        'as' => 'confirm_status',
    ]);

    /*采购商提交圈存记录*/
    $router->post('send_initialize',[
        'uses' => 'Purchasing\PurchasingController@send_initialize',
        'as' => 'send_initialize',
    ]);

    $router->post('get_reconciliation_data',[
        'uses' => 'Purchasing\PurchasingController@get_reconciliation_data',
        'as' => 'get_reconciliation_data',
    ]);

});