<?php

/**
 * author      : zhyzkl
 * createTime  : 2022/5/20 10:00 下午
 * description :
 */

namespace app\middleware;

use app\helpers\SystemEnum;
use think\facade\Request;
use think\facade\Config;
use Godruoyi\Snowflake\Snowflake;
use app\facade\SystemToolsPlus;

class InitLoginUserInfoMiddleware
{
    use \app\helpers\SystemResponse;

    public function handle( $request , \Closure $next )
    {
        if ( Request::isOptions() === true ) {
            return $request( $next );
        }
        $request->uuid = ( new Snowflake() )->id();
        if ( Request::pathinfo() === Config::get( 'system.loginPathinfo' ) ) {
            return $next( $request );
        }
        if ( !$request->currentUserToken = SystemToolsPlus::getRequestToken() ) {
            return $this->fail( SystemEnum::REQUEST_ERROR , '未能获取到当前登陆凭证' );
        }

        if(!$request->currentUser = app()->userService->getCacheUserLoginInfoByToken( $request->currentUserToken )){
            return $this->fail(SystemEnum::SYSTEM_CACHE_MISSED_ERROR,'未能正确根据获取到用户信息！请重新登陆！');
        }
        return $next( $request );
    }
}