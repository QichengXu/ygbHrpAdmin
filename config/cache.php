<?php

// +----------------------------------------------------------------------
// | 缓存设置
// +----------------------------------------------------------------------

return [
    // 默认缓存驱动
    'default' => env('cache.driver', 'file'),

    // 缓存连接方式配置
    'stores'  => [
        'file' => [
            // 驱动方式
            'type'       => 'File',
            // 缓存保存目录
            'path'       => '',
            // 缓存前缀
            'prefix'     => '',
            // 缓存有效期 0表示永久缓存
            'expire'     => 0,
            // 缓存标签前缀
            'tag_prefix' => 'tag:',
            // 序列化机制 例如 ['serialize', 'unserialize']
            'serialize'  => [],
        ],
        //缓存用户信息Db
        'userDb' => [
            'type' => 'redis',
            'host' => '127.0.0.1',
            'port' => '6379',
            'select' => 0,
            'password'=> '',
            'timeout' => 0
        ],
        //角色权限DB
        'roleDb' => [
            'type' => 'redis',
            'host' => '127.0.0.1',
            'port' => '6379',
            'select' => 1,
            'password'=> '',
            'timeout' => 0
        ],
        //页面按钮DB
        'pathButtonRoleDb' => [
            'type' => 'redis',
            'host' => '127.0.0.1',
            'port' => '6379',
            'select' => 2,
            'password'=> '',
            'timeout' => 0
        ]

        // 更多的缓存连接
    ],
];
