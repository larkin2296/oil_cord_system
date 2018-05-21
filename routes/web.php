<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//$router->group(['middleware' => ['web']],function($router){
//
//    $router->group(['prefix' => 'web'],function($router){
//
//        $router->group(['namespace' => 'Api'],function($router){
//
//            $router->group(['prefix' => 'register','as' => 'register.'],function($router){
//
//                $router->get('index', [
//                    'uses' => 'Login\RegisterController@register',
//                    'as' => 'index',
//                ]);
//
//            });
//
//        });
//
//
//    });
//});

/*通用路由*/
require(__DIR__ . '/common/common.php');


