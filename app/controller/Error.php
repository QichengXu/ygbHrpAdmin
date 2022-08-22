<?php

/**
 * author      : zhyzkl
 * createTime  : 2021/11/2 5:48 下午
 * description :
 */
namespace app\controller;


use app\helpers\SystemEnum;
use app\helpers\SystemResponse;
class Error{
    use SystemResponse;
    public function __call($name, $arguments){
        return $this->fail(SystemEnum::REQUEST_ERROR,'你在干嘛鸭！怎么乱访问！');
    }
}