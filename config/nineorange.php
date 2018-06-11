<?php
/*
|--------------------------------------------------------------------------
| HskyZhou NineOrange Config
|--------------------------------------------------------------------------
|
|
*/
return [
    /*
    | api 请求地址
    */
    'apiURL' => 'http://gd.ums86.com:8899/sms/Api/Send.do',
    /*
	| api spcode
	*/
    'SpCode' => '201971',
    /*
    | 登录名
    */
    'LoginName' => 'nt_htwl',
    /*
    | 密码
    */
    'Password' => 'qwer1234',
    'ScheduleTime' => '',
    'ExtendAccessNum' => '',
    'f' => 1,
    /*
    | 模板 -- 目前只支持一个参数
    */
    //'msg_template' => '您的验证码是%u请不要告诉任何人,30分钟内有效,如非本人操作,请忽略本短信.',
    'msg_template' => '您的验证码为%u.',
];
