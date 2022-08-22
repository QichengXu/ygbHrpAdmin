<?php

/**
 * author      : zhyzkl
 * createTime  : 2022/5/11 11:08 上午
 * description :
 */


return [
        'loginPathinfo' =>  'admin/v1/user/login',
         // 鉴权白名单
        'authentication_whitelist' => [
            'admin/v1/user/login'
        ],
        // 日志类目
        'log'=> [
            'openRequestActionLogMiddleware' => true,
        ]
];
