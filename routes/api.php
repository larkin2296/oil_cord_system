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
 *         1:Accommed 供应商  -api
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

            $router->match(['get','post'],'index/{id?}',[
               'uses' => 'Login\RegisterController@register',
               'as' => 'index',
            ]);

            $router->match(['get','post'],'again_check',[
                'uses' => 'Login\RegisterController@again_check',
                'as' => 'again_check',
            ]);

            $router->match(['get','post'],'updatePasswd',[
                'uses' => 'Login\RegisterController@updatePasswd',
                'as' => 'updatePasswd',
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
        /*下载*/
        $router->group(['prefix' => 'download'],function ($router){

            $router->match(['get','post'],'export',[
                'uses' => 'Supply\CatSupplyController@export',
                'as' => 'export',
            ]);

            $router->match(['get','post'],'export_card',[
                'uses' => 'Supply\CatSupplyController@export_card',
                'as' => 'export_card',
            ]);
        });

        /*jwt auth token 验证*/
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

                /*刷新token*/
                $router->match(['get','post'],'refresh',[
                    'uses' => 'UserController@refresh_token',
                    'as' => 'refresh',
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

                /*生成邀请链接*/
                $router->post('link',[
                    'uses' => 'UserController@setLink',
                    'as' => 'link',
                ]);

                /*查看已邀请人*/
                $router->post('show',[
                    'uses' => 'UserController@show',
                    'as' => 'show',
                ]);

                /*修改头像*/
                $router->post('editAvatar',[
                    'uses' => 'UserController@editAvatar',
                    'as' => 'editAvatar',
                ]);

                /*获取头像文件访问路径*/
                $router->get('showAvatar/{id}',[
                    'uses' => 'UserController@showAvatar',
                    'as' => 'showAvatar',
                ]);
            });

             /*供应商*/
            $router->group(['prefix' => 'supply'],function ($router) {

                require(__DIR__.'/api/accommed/api.php');
            });

            /*采购供应管理*/
            $router->group(['prefix' => 'system','as' => 'system.'],function($router){

                require(__DIR__.'/api/system/api.php');
            });

            /*管理员*/
            $router->group(['prefix' => 'administrator'],function ($router) {

                require(__DIR__.'/api/administrator/api.php');
            });

            /*管理员公用接口*/
            require(__DIR__.'/admin/common.php');

            $router->group(['prefix' => 'purchasing'],function($router){
                require(__DIR__.'/api/purchasing/api.php');
            });


        });
        $router->group(['prefix' => 'configure'],function($router){
            require(__DIR__.'/api/configure/api.php');
        });

        $router->group(['prefix' => 'logout'],function($router){
            /*登出*/
            $router->match(['get','post'],'/',[
                'uses' => 'Login\LoginController@logout',
                'as' => 'login',
            ]);
        });


        $router->group(['middleware' => 'cors'],function($router) {

            $router->group(['prefix' => 'upload'], function ($router) {

                /*上传文件*/
                $router->match(['get', 'post'], '/', [
                    'uses' => 'UserController@upfile',
                    'as' => 'upfile',
                ]);
            });
        });
    });

});

