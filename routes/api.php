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

        /*注册*/
        $router->group(['prefix' => 'register'],function($router){

            $router->match(['get','post'],'/',[
               'uses' => 'Login\RegisterController@register',
               'as' => 'index',
            ]);
        });
        /*登陆*/
        $router->group(['prefix' => 'login'],function($router){

            $router->match(['get','post'],'/',[
               'uses' => 'Login\LoginController@login',
               'as' => 'login',
            ]);
            /*手机短信登陆*/
            $router->match(['get','post'],'mobile',[
                'uses' => 'Login\LoginController@loginMassage',
                'as' => 'loginMassage',
            ]);
        });

        /*短信验证码*/
        $router->group(['prefix' => 'messages'],function ($router){
            /*登陆验证码*/
            $router->match(['get','post'],'loginMessage',[
                'uses' => 'Login\MessageController@loginMessage',
                'as' => 'loginMessage',
            ]);
            /*注册验证码*/
             $router->match(['get','post'],'registerMessage',[
                 'uses' => 'Login\MessageController@registerMessage',
                 'as' => 'registerMessage'
             ]);
             /*发送重置验证码*/
            $router->match(['get','post'],'resetpassMessage',[
                'uses' => 'Login\MessageController@resetpassMessage',
                'as' => 'resetpassMessage'
            ]);
            /*更改手机号绑定验证码*/
            $router->match(['get','post'],'editMobileMessage',[
                'uses' => 'Login\MessageController@editMobileMessage',
                'as' => 'editMobileMessage'
            ]);
        });

        /*用户信息*/
        $router->group(['middleware' => 'jwt.auth'],function($router){

            $router->group(['prefix' => 'user'],function($router){

                /*更改绑定手机号*/
                $router->match(['get','post'],'edit',[
                    'uses' => 'Login\MessageController@editMobile',
                    'as' => 'editMobile',
                ]);

                /*用户信息*/
                $router->match(['get','post'],'info',[
                    'uses' => 'UserController@userinfo',
                    'as' => 'info',
                ]);

                /*修改信息*/
                $router->post('update',[
                    'uses' => 'UserController@updateUser',
                    'as' => 'updateUser',
                ]);

                /*修改密码*/
                $router->post('modify',[
                    'uses' => 'UserController@updatePasswd',
                    'as' => 'updatePasswd',
                ]);
            });

             /*供应商*/
            $router->group(['prefix' => 'supply'],function ($router) {

//                require(__DIR__.'/api/accommed/api.php');
            });

        });

        $router->group(['prefix' => 'logout'],function($router){
            /*登陆*/
            $router->match(['get','post'],'/',[
                'uses' => 'Login\LoginController@logout',
                'as' => 'login',
            ]);
        });

        $router->group(['prefix' => 'purchasing'],function($router){
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
        });

    });



});