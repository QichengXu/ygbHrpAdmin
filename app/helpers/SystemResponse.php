<?php

/**
 * author      : zhyzkl
 * createTime  : 2022/3/26 20:10 下午
 * description :
 */

namespace app\helpers;
use app\helpers\SystemEnum;
use think\response\Json as sendJson;
use app\Exception\{SystemException,SystemServicesException};
use Godruoyi\Snowflake\Snowflake;

trait SystemResponse
{
    /**
     * 统一成功返回
     * @param int $code
     * @param string $message
     * @param array $data
     * @param  array $otherData
     * @return sendJson
     */
    public function success( array $codeResponse = SystemEnum::REQUEST_SUCCESS , string $otherMessage = '' , array $data = [] , array $otherData = [] )
    {
        return $this->jsonResponse( $codeResponse , $otherMessage , $data , $otherData );
    }
    /**
     * 统一失败返回
     * @param array $codeResponse
     * @param string $otherMessage
     * @param array $data
     * @param array $otherData
     * @return sendJson
     */
    public function fail( array $codeResponse = SystemEnum::REQUEST_ERROR , string $otherMessage = '' , array $data = [] , array $otherData = [] )
    {
           return $this->jsonResponse( $codeResponse , $otherMessage , $data , $otherData );
    }

    /**
     * @param array  $codeResponse
     * @param string $otherMessage
     * @param array  $data
     * @param array  $otherData
     * @return sendJson
     */
    public function  jsonResponse( array $codeResponse , string $otherMessage, array $data , array $otherData ){
        [ $code , $message ] = $codeResponse;
        return json( [
            'code' => $code ,
            'message' => $otherMessage ?: $message ,
            'data' => $data ,
            'other_data' => $otherData
        ] );
    }

    /**
     * 统一抛出系统的异常抛出
     * @param array  $codeResponse
     * @param string $otherMessage
     * @param int    $code
     * @param array  $header
     */
    public function throwBusinessException( array $codeResponse , string $otherMessage = '' , int $code=0 , array $header = [] ) :SystemException{
        throw new SystemException( $codeResponse , $otherMessage , $code , $header );
    }

    /**
     * 统一抛出系统服务层的异常抛出
     * @param array  $codeResponse
     * @param string $otherMessage
     * @param int    $code
     * @param array  $header
     */
    public function throwSystemServiceException( array $codeResponse , string $otherMessage = '' , int $code=0 , array $header = [] ) :SystemException{
        throw new SystemServicesException( $codeResponse , $otherMessage , $code , $header );
    }

    /**
     * 生成全局唯一id( 雪花算法 )
     * @return int
     */
    public function generateSnowId():int{
        return  (new Snowflake)->id();
    }

}