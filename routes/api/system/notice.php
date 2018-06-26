<?php
$router->group(['prefix' => 'notice', 'as' => 'notice.'],function($router){


    /*公告列表*/
    $router->get('index',[
        'uses' => 'System\Notice\NoticeController@index',
        'as' => 'index',
    ]);

    /*公告添加*/
    $router->post('add',[
        'uses' => 'System\Notice\NoticeController@add',
        'as' => 'add',
    ]);

    /*公告修改*/
    $router->post('update',[
        'uses' => 'System\Notice\NoticeController@update',
        'as' => 'update',
    ]);

    /*公告展示*/
    $router->post('choice',[
        'uses' => 'System\Notice\NoticeController@choice',
        'as' => 'choice',
    ]);

    /*公告删除*/
    $router->delete('{id}/delete',[
        'uses' => 'System\Notice\NoticeController@delete',
        'as' => 'delete',
    ]);

    /*公告显示*/
    $router->get('display',[
        'uses' => 'System\Notice\NoticeController@display',
        'as' => 'display',
    ]);
});