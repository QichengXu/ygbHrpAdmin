<?php

/**
 * author      : zhyzkl
 * createTime  : 2022/5/12 9:35 下午
 * description :
 */

namespace app\api\controller\v1;

use app\common\controller\BaseController;
use  app\facade\SystemToolsPlus;
use app\helpers\SystemEnum;


class IndexController extends BaseController
{
    public function index(){

        return $this->success(SystemEnum::REQUEST_SUCCESS,'这是[api]的v1版本');
    }

}