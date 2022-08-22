<?php

/**
 * author      : zhyzkl
 * createTime  : 2021/10/25 4:48 下午
 * description :
 */
namespace app\exceptionHandleTakeover;
use think\exception\{
    Handle,
    HTTPException,
    ErrorException
};
use app\Exception\{SystemException,SystemServicesException};
use think\Response;
use Throwable;
use app\helpers\SystemResponse;
use app\helpers\SystemEnum;
class ExceptionHandleTakeover extends Handle{
   use SystemResponse;
    public function render($request,Throwable $e):Response {
        if(method_exists($e,'getStatusCode')){
            $fialMessage[] = $e->getStatusCode()?:SystemEnum::SYSTEM_ERROR[0];
        }else{
            $fialMessage[] = SystemEnum::SYSTEM_ERROR[0];
        }
        $fialMessage[] = $e->getMessage()?:SystemEnum::SYSTEM_ERROR[1];
        return $this->fail($fialMessage);
        //return parent::render($request,$e);
    }
}

