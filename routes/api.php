<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
 * ============ API ============
 *
 * 刘通
 *
 *
 * ============ END ============
 */

$router->group(['middleware' => ['api']],function($router){

    $router->group(['namespace' => 'Api'],function($router){

        $router->group(['prefix' => 'register'],function($router){

            $router->match(['get','post'],'index',[
               'uses' => 'Login\RegisterController@register',
               'as' => 'index',
            ]);
        });
    });



});