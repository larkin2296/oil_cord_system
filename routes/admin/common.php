<?php
$router->group(['prefix' => 'admin','as' => 'admin.'],function($router){

    $router->group(['namespace' => 'CommonApi'], function($router){

        /*获取所有供应商*/
        $router->match(['get','post'],'getSupplierAll',[
            'uses' => 'CommonsController@getSupplierAll',
            'as' => 'getSupplierAll',
        ]);

        /*获取所有采购商*/
        $router->match(['get','post'],'getPurchasersAll',[
            'uses' => 'CommonsController@getPurchasersAll',
            'as' => 'getPurchasersAll',
        ]);

        /*获取所有管理员*/
        $router->match(['get','post'],'getAdminAll',[
            'uses' => 'CommonsController@getAdminAll',
            'as' => 'getAdminAll',
        ]);
    });

});