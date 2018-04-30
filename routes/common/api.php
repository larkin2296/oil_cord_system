<?php
                /*文件上传*/
$router->group(['prefix' => 'attachment','as' => 'attachment.'],function($router){

    /*上传附件*/
    require(__DIR__.'/cam.php');
});