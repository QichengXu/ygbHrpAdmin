<?php
// 全局中间件定义文件
return [

    // 全局请求缓存
    // \think\middleware\CheckRequestCache::class,
    // 多语言加载
    // \think\middleware\LoadLangPack::class,
    // Session初始化
    // \think\middleware\SessionInit::class
    //跨域

    \think\middleware\AllowCrossDomain::class,

    //\app\middleware\InitLoginUserInfoMiddleware::class,
    //验证器
    \app\middleware\ValidateParamsMiddleware::class,

    \app\middleware\RequestActionLogMiddleware::class

];
