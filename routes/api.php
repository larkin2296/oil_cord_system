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

            $router->match(['get','post'],'index/{id?}',[
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
            });

             /*供应商*/
            $router->group(['prefix' => 'supply'],function ($router) {

                require(__DIR__.'/api/accommed/api.php');
            });

            /*文件上传*/
            require(__DIR__.'/common/api.php');
        });

        $router->group(['prefix' => 'logout'],function($router){
            /*登出*/
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

            /*采购商创建短期直充订单*/
            $router->match(['get','post'],'set_sdirectly_order',[
                'uses' => 'Purchasing\PurchasingController@directly_order',
                'as' => 'set_sdirectly_order',
            ]);
            /*采购商短期直充*/
            $router->match(['get','post'],'get_sdirecty_order',[
                'uses' => 'Purchasing\PurchasingController@sdirectly_order',
                'as' => 'get_sdirecty_order',
            ]);
            /*采购商长期直充*/
            $router->match(['get','post'],'get_ldirecty_order',[
                'uses' => 'Purchasing\PurchasingController@ldirectly_order',
                'as' => 'get_ldirecty_order',
            ]);
            /*采购商短充卡密详情*/
            $router->match(['get','post'],'get_camilo_detail',[
                'uses' => 'Purchasing\PurchasingController@get_camilo_detail',
                'as' => 'get_camilo_detail',
            ]);
            /*采购商长期直充详情*/
            $router->match(['get','post'],'get_ldirectly_detail',[
                'uses' => 'Purchasing\PurchasingController@get_ldirectly_detail',
                'as' => 'get_ldirectly_detail',
            ]);
            /*采购商长期直充详情*/
            $router->match(['get','post'],'get_sdirectly_detail',[
                'uses' => 'Purchasing\PurchasingController@get_sdirectly_detail',
                'as' => 'get_sdirectly_detail',
            ]);
            /*采购商上报错误*/
            $router->match(['get','post'],'set_problem',[
                'uses' => 'Purchasing\PurchasingController@set_problem',
                'as' => 'set_problem',
            ]);
            /*采购商圈存数据获取*/
            $router->match(['get','post'],'get_initialize',[
                'uses' => 'Purchasing\PurchasingController@get_initializea',
                'as' => 'get_initialize',
            ]);
            /*采购商圈存详情*/
            $router->match(['get','post'],'get_initialize_detail',[
                'uses' => 'Purchasing\PurchasingController@get_initialize_detail',
                'as' => 'get_initialize_detail',
            ]);
            /*采购商上报圈存*/
            $router->match(['get','post'],'set_initialize_data',[
                'uses' => 'Purchasing\PurchasingController@set_initialize_data',
                'as' => 'set_initialize_data',
            ]);
            /*采购商对账数据获取*/
            $router->match(['get','post'],'get_reconciliation',[
                'uses' => 'Purchasing\PurchasingController@get_reconciliation',
                'as' => 'get_reconciliation',
            ]);
            /*采购商卡密补发自动发货*/
            $router->match(['get','post'],'auto_recharge',[
                'uses' => 'Purchasing\PurchasingController@auto_recharge',
                'as' => 'auto_recharge',
            ]);
            /*采购商卡密标记已使用*/
            $router->match(['get','post'],'set_camilo_userd',[
                'uses' => 'Purchasing\PurchasingController@set_camilo_userd',
                'as' => 'set_camilo_userd',
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