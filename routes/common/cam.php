<?php
$router->group([],function($router){

    /*卡密附件*/
    $router->group(['prefix' => 'cam'],function($router){

        /*上传文件*/
        $router->post('upload',[
            'uses' => 'AttachmentController@upload',
            'as' => 'upload',
        ]);

        /*查看文件*/
         $router->post('list',[
             'uses' => 'AttachmentController@uploadList',
             'as' => 'list',
         ]);

    });

    $router->group(['prefix' => 'user','as' => 'user.'],function($router){

        /*查看头像*/
        $router->match(['get','post'],'avatarshow/{id}',[
            'uses' => 'AttachmentController@avatar',
            'as' => 'avatarshow',
        ]);

    });
});