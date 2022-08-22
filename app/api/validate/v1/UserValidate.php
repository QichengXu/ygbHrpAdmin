<?php

/**
 * author      : zhyzkl
 * createTime  : 2022/5/10 10:15 下午
 * description :
 */

namespace app\admin\validate\v1;

use think\Validate;

class UserValidate extends Validate
{
    protected $rule = [
        'account'  =>  'require',

    ];
    protected $message  =   [
        'account.require' => '工号为必须',

    ];
    protected $scene = [
        'login'  =>  ['account'],
    ];
}