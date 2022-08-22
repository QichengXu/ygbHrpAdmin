<?php

/**
 * author      : zhyzkl
 * createTime  : 2021/10/25 4:14 下午
 * description :
 */

namespace app\middleware;

use think\facade\Request;
use app\helpers\SystemEnum ;
use app\helpers\SystemResponse;

class ValidateParamsMiddleware
{

    use SystemResponse;
    public function handle( $request , \Closure $next )
    {
        $params = Request::param();
        $module = app( 'http' )->getName();
        $controller = Request::controller();
        if ( strpos( $controller , '.' ) !== false ) {
            $controllerArray = explode( '.' , $controller );
            $validate = "app\\" . $module . "\\validate\\" . $controllerArray[ 0 ] . '\\' . $controllerArray[ 1 ] . 'Validate';
        } else {
            $validate = "app\\" . $module . "validate\\" . $controller . 'Validate';
        }
        $scene = Request::action();
        if ( class_exists( $validate ) ) {
            $v = new $validate;
            if ( $v->hasScene( $scene ) ) {
                $v->scene( $scene );
                if ( !$v->check( $params ) ) {
                    return $this->fail( SystemEnum::REQUEST_ERROR , '错误内容:' . $v->getError() );
                }
            }
        }
        return $next( $request );
    }
}