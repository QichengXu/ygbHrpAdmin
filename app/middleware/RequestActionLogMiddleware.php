<?php

/**
 * author      : zhyzkl
 * createTime  : 2022/5/11 10:58 上午
 * description :
 */

namespace app\middleware;

use think\facade\Db;
use think\facade\Request;
use think\facade\Config;
use Godruoyi\Snowflake\Snowflake;

class RequestActionLogMiddleware
{
    public function handle( $request , \Closure $next )
    {

        if ( Request::isOptions() === true ) {
            return $request( $next );
        }

        if ( Config::get( 'system.log.openRequestActionLogMiddleware' ) === false ) {
            return $next( $request );
        }

        return $next( $request );
    }
}