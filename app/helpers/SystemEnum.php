<?php

/**
 * author      : zhyzkl
 * createTime  : 2021/10/25 5:05 下午
 * description :
 */

namespace app\helpers;
class SystemEnum
{

    /**
     *  200表示服务器成功地接受了客户端请求
     */
    public const REQUEST_SUCCESS = [ 200001 , '请求成功' ];

    /**
     * 300开头的表示服务器重定向,指向的别的地方，客户端浏览器必须采取更多操作来实现请求
     * 302 - 对象已移动。
     * 304 - 未修改。
     * 307 - 临时重定向
     */


    /**
     *  400开头的表示客户端错误请求错误，请求不到数据，或者找不到等等
     *  400 - 错误的请求
     */
    public const REQUEST_ERROR = [ 400001 , '请求失败' ];
    public const NOT_USER_ERROR = [ 400002 , '未查找到对应用户信息！' ];
    public const NOT_FOUND = [ 400003 , '未查找到对应信息！' ];

    /**
     * 500开头的表示服务器错误，服务器因为代码，或者什么原因终止运行
     * 服务端操作错误码：500 ~ 599 开头，后拼接 3 位
     * 500 - 内部服务器错误
     */
    public const SYSTEM_ERROR = [ 500001 , '服务器错误' ];
    public const SYSTEM_UNAVAILABLE = [ 500002 , '服务器正在维护，暂不可用' ];
    public const SYSTEM_CACHE_CONFIG_ERROR = [ 500003 , '缓存配置错误' ];
    public const SYSTEM_CACHE_MISSED_ERROR = [ 500004 , '缓存未命中' ];
    public const SYSTEM_CONFIG_ERROR = [ 500005 , '系统配置错误' ];
    // 业务操作错误码（外部服务或内部服务调用）
    public const SERVICE_REGISTER_ERROR = [ 500101 , '注册失败' ];
    public const SERVICE_LOGIN_ERROR = [ 500102 , '登录失败' ];
    public const SERVICE_LOGIN_ACCOUNT_ERROR = [ 500103 , '账号或密码错误' ];


}