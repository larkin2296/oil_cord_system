<?php

return [
    /**
     * 可选为 metronic
     */
    'theme' => [
        /**
         * 主题文件夹
         */
        'folder' => 'themes',
        /**
         * 主题名称
         */
        'name' => 'metronic',
    ],

    /**
     * redis 配置
     */
    'redis' => [
        /**
         * 前缀
         */
        'prefix' => 'consulation:back:',
    ],

    /**
     * cache 配置
     */
    'cache' => [
        /**
         * 前缀
         */
        'prefix' => 'back_'
    ],

    /*开关配置*/
    'switch' => [
        /*注册开关是否开启*/
        'register' => true,
    ],

    /* 通用验证是否 */
    'commoncheck' => [
        'value' => [
            '1' => '是',
            '2' => "否"
        ],
        'map' => [
            'true' => 1,
            'false' => 2,
        ]
    ],

    /*菜单位置*/
    'menu_position' => [
        'value' => [
            '1' => '通用',
            '2' => '后台',
            '3' => '公司',
        ],
        'map' => [
            'all' => 1,
            'admin' => 2,
            'company' => 3,
        ],
    ],

    'wechat' => [
        'order' => [
            'body' => [
                'consulation' => '购买问诊',
                'privatedoctor' => '购买私人医生服务',
                'plussign' => '购买加号',
            ],
        ]
    ],

    'status' => [
        'order' => [
            'wait' => 1,
            'doing' => 2,
            'complete' => 3,
            'refunding' => 4,
            'refunded' => 5,
            'closed' => 6,
        ],
    ],

    'account' => [
        'alipay' => '1111111',
    ],
];