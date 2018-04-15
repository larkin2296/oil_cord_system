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
 *刘通
 *api路由写在api下 
 *         1:accommed 供应商  -api
 *         2:purchase 采购商  -api
 *common 公共路由
 *
 *admin  管理员
 *
 * 只需建立你自己业务的路由 他人路由无需建立
 * ============ END ============
 */

$router->group(['middleware' => ['api']],function($router){

    $router->group(['namespace' => 'Api'],function($router){

        $router->group(['prefix' => 'register'],function($router){
        	 /*注册*/
            $router->match(['get','post'],'/',[
               'uses' => 'Login\RegisterController@register',
               'as' => 'index',
            ]);
        });
            
        $router->group(['prefix' => 'login'],function($router){
        	 /*登陆*/
            $router->match(['get','post'],'/',[
               'uses' => 'Login\LoginController@login',
               'as' => 'login',
            ]);
        });

        $router->group(['prefix' => 'getinfo'],function($router){
            /*登陆*/
            $router->match(['get','post'],'/',[
                'uses' => 'Login\LoginController@get_info',
                'as' => 'login',
            ]);
        });
        $router->group(['prefix' => 'logout'],function($router){
            /*登陆*/
            $router->match(['get','post'],'/',[
                'uses' => 'Login\LoginController@logout',
                'as' => 'login',
            ]);
        });
    });



});