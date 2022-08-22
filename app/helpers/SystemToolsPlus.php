<?php
declare( strict_types = 1 );
/**
 * author      : zhyzkl
 * createTime  : 2021/10/25 4:24 下午
 * description :
 */

namespace app\helpers;

use Overtrue\Pinyin\Pinyin;
use think\facade\Request;

class SystemToolsPlus
{
    /**
     * 获取登陆后携带的Token；
     *
     */
    public function getRequestToken()
    {
        $authorization = Request::header( 'authorization' );
        if ( $authorization ) {
            $prefix = 'Bearer';
            return trim( str_ireplace( $prefix , '' , $authorization ) );
        }
        return null;
    }



    /**
     * 中文转英文首字母.
     * params 为空时返回中文暂无
     * params 不保留字符串中的数字/英文，只会将 lyu => lv
     *
     * @param string|null $string
     *
     * @return string
     */
    public function chineseToPinyin( ?string $string ): string
    {

        if ( !$string ) {
            return '暂无';
        }
        $pinYinObject = new PinYin();
        return $pinYinObject->abbr( $string , '' , PINYIN_UMLAUT_V );

    }


    /**
     * md5加密方法
     * 带上固定盐值
     *
     * @param string $string
     *
     * @return string
     */
    public function md5Str( string $string ): string
    {
        return md5( $string . 'zhyzkl' );
    }

    /**
     *  将时间友好化
     *  场景例子
     *  比如维修单，工程师维修时间填写0.15
     *  0.15* 60 得出  9分钟
     *  假设填写0.005 时间会向上取整，精确到分钟
     *  $num = 10,$conversionType = 'i', $workHours = 8  ====>600分钟
     *  $num = 10,$conversionType = 'h', $workHours = 8  ====>10小时0分钟
     *  $num = 10,$conversionType = 'd', $workHours = 8  ====>1天2小时0分钟
     *
     * @param string $conversionType d:d天h时i分, h:h时i分，i:i分
     * @param ?float $num            用户填写的时间
     * @param int    $workHours      工作时间 填0 时不按照工作时间转成天按24小时算
     *
     * @return string $time
     */
    public function friendlyTime( ?float $num = 0 , string $conversionType = 'i' , int $workHours = 8 )
    {
        if ( $num === '0' || is_null( $num ) ) {
            return $num;
        }
        $convertToMinutes = ceil( (float)$num * 60 );
        switch ( $conversionType ) {
            case 'i':
                return $convertToMinutes . '分钟';
            case 'h':
                $convertToHours = floor( $convertToMinutes / 60 );
                $redundantMinutes = $convertToMinutes % 60;
                return $convertToHours . '小时' . $redundantMinutes . '分钟';
            case 'd':
                $convertToHours = floor( $convertToMinutes / 60 );
                $redundantMinutes = $convertToMinutes % 60;
                if ( $workHours === 0 ) {
                    if ( $convertToHours < 24 ) {
                        return '0天' . $convertToHours . '小时' . $redundantMinutes . '分钟';
                    }
                    $convertToDays = floor( $convertToHours / 24 );
                    $redundantHours = $convertToHours - ( $convertToDays * 24 );
                    return $convertToDays . '天' . $redundantHours . '小时' . $redundantMinutes . '分钟';
                }
                $convertToDays = floor( $convertToHours / $workHours );
                $redundantHours = $convertToHours - ( $convertToDays * $workHours );
                return $convertToDays . '天' . $redundantHours . '小时' . $redundantMinutes . '分钟';
            default:
                return $num;
        }
    }
    /**
     * 获取客户端的IP地址
     *
     * @param $type 表示返回类型 0 返回IP地址， 1 返回IPV4地址数字
     */
    public function getClientIp( $type = 0 )
    {
        $type = $type ? 1 : 0;
        static $ip = null;
        if ( $ip !== null ) return $ip[ $type ];
        if ( isset( $_SERVER[ 'HTTP_X_FORWARDED_FOR' ] ) ) {
            $arr = explode( ',' , $_SERVER[ 'HTTP_X_FORWARDED_FOR' ] );
            $pos = array_search( 'unknown' , $arr );
            if ( false !== $pos ) unset( $arr[ $pos ] );
            $ip = trim( $arr[ 0 ] );
        } else if ( isset( $_SERVER[ 'HTTP_CLIENT_IP' ] ) ) {
            $ip = $_SERVER[ 'HTTP_CLIENT_IP' ];
        } else if ( isset( $_SERVER[ 'REMOTE_ADDR' ] ) ) {
            $ip = $_SERVER[ 'REMOTE_ADDR' ];
        }
        // IP地址合法验证
        $long = ip2long( $ip );
        $ip = $long ? [ $ip , $long ] : [ '0.0.0.0' , 0 ];
        return $ip[ $type ];
    }


}