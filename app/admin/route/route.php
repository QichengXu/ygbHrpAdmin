<?php

/**
 * author      : zhyzkl
 * createTime  : 2022/3/23 5:43 下午
 * description :
 */
use think\Facade\Route;
Route::rule(':version/:controller/:action',':version.:controller/:action')
    ->middleware(\app\middleware\ValidateParamsMiddleware::class);