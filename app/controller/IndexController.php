<?php

/**
 * author      : zhyzkl
 * createTime  : 2021/11/26 10:38 上午
 * description :
 */

namespace app\controller;
use app\helpers\SystemEnum;
use app\helpers\SystemResponse;

class IndexController
{
    use SystemResponse;
    public function index(){
        return $this->fail(SystemEnum::REQUEST_ERROR,'你在干嘛鸭！');


    }
}