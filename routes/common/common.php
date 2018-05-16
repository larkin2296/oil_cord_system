<?php

$router->group(['prefix' => 'common','as' => 'common.'],function($router){

    /*附件上传专用接口*/
        $router->group(['middleware' => 'debug'], function($router){

        $router->group(['prefix' => 'attach','as' => 'attach.'],function($router){

            /*附件上传*/
            $router->post('upload',[
               'uses' => 'Api\AttachmentController@upload',
               'as' => 'upload'
            ]);

            /*附件查看*/
            $router->get('show/{id}',[
               'uses' => 'AttachmentController@show',
               'as' => 'show'
            ]);

            /*附件下载*/
            $router->get('download/{id}', [
                'uses' => 'AttachmentController@download',
                'as' => 'download'
            ]);

            $router->group(['prefix' => 'user','as' => 'user.'],function($router){

                /*查看头像*/
                $router->match(['get','post'],'avatarshow/{id}',[
                    'uses' => 'AttachmentController@avatar',
                    'as' => 'avatarshow',
                ]);

            });

        });
    });
});