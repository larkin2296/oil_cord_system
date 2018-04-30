<?php
$router->group([],function($router){

    /*卡密附件*/
    $router->group(['prefix' => 'cam'],function($router){

        $router->post('upload',[
            'uses' => 'AttachmentController@upload',
            'as' => 'upload',
        ]);
    });

});