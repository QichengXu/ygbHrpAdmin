<?php

/**
 * author      : zhyzkl
 * createTime  : 2021/11/29 11:29 上午
 * description :
 */

namespace app\businessStatus;


class BasisStatus
{
    /**
     * status 正常
     */
    public const NORMAL_STATUS = 1;
    /**
     * status 禁用
     */
    public const DISABLED_STAUTUS = 0;

    /**
     * 数据库字符串类型空值
     */
    public const SYSTEM_DB_STRING_NULL = '-';
    /**
     * 数据库数值类型空值
     */
    public const SYSTEM_DB_INT_NULL = 0;


}