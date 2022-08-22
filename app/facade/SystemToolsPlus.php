<?php

/**
 * author      : zhyzkl
 * createTime  : 2021/10/25 4:30 下午
 * description :
 */

namespace app\facade;
use think\Facade;

/**
 * Class SystemToolsPlus
 *
 * @package app\facade
 * author      : zhyzkl
 * createTime  : 2022/5/11 11:04 上午
 * description :
 * @see \app\helpers\SystemToolsPlus
 * @package think\facade
 * @mixin \app\helpers\SystemToolsPlus
 * @method static \app\helpers\SystemToolsPlus chineseToPinyin(?string $string) 中文转英文首字母.
 * @method static \app\helpers\SystemToolsPlus md5Str(string $string) md5加密方法 会带有固定盐值zhyzkl.
 * @method static \app\helpers\SystemToolsPlus friendlyTime(?float $num = 0 , string $conversionType='i', int $workHours = 8) 将时间友好化.
 * @method static \app\helpers\SystemToolsPlus getClientIp(int $tyoe = 0 ) 获取客户端ip.
 * @method static \app\helpers\SystemToolsPlus getRequestToken() 获取请求所携带的token。
 */

class SystemToolsPlus extends Facade
{
    public static function  getFacadeClass(){
        return 'app\helpers\systemToolsPlus';
    }
}