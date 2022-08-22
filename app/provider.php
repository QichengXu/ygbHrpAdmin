<?php
// 容器Provider定义文件
return [
    'think\Request'          => \app\Request::class,
   // 'think\exception\Handle' => ExceptionHandle::class,
    'think\exception\Handle'       => \app\exceptionHandleTakeover\ExceptionHandleTakeover::class,
    //基础服务都丢进容器里方便使用
];
