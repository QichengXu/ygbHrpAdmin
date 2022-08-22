<?php

/**
 * author      : zhyzkl
 * createTime  : 2021/10/25 5:09 下午
 * description :
 */
namespace app\Exception;
use think\exception\HttpException;
class SystemException extends HttpException
{
    public function __construct(array $codeResponse, string $otherMessage = null,int $code=0,array $header = [])
    {
        [ $statusCode , $message ] = $codeResponse;
        parent::__construct( $statusCode , $otherMessage ?: $message ,null , $header , $code );
    }

}