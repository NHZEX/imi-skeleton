<?php

use Imi\HotUpdate\Monitor\FileMTime;
use ImiApp\ApiServer\ErrorHandler;

$rootPath = dirname(__DIR__).'/';

return [
    'beanScan'    =>    [
    ],
    'hotUpdate'    =>    [
        'status'    =>    (bool) env('HOT_UPDATE', false), // 关闭热更新去除注释，不设置即为开启，建议生产环境关闭

        // --- 文件修改时间监控 ---
        'monitorClass'    =>    FileMTime::class,
        'timespan'    =>    1, // 检测时间间隔，单位：秒

        // --- Inotify 扩展监控 ---
        // 'monitorClass'    =>    \Imi\HotUpdate\Monitor\Inotify::class,
        // 'timespan'    =>    1, // 检测时间间隔，单位：秒，使用扩展建议设为0性能更佳

        // 'includePaths'    =>    [], // 要包含的路径数组
        'excludePaths'    =>    [
            $rootPath.'.git',
            $rootPath.'.idea',
            $rootPath.'.vscode',
            $rootPath.'vendor',
        ], // 要排除的路径数组，支持通配符*

        'process' => true,
    ],
    'AutoRunProcessManager' => [
        'processes' => [
            'CronProcess',
        ],
    ],
    'DbQueryLog' => [
        'enable' => true,
    ],
    'ErrorLog'  =>  [
        'level' =>  E_ALL,
        'catchLevel' => E_ALL | E_STRICT,
        'exceptionLevel' => env('APP_DEBUG')
            ? E_ALL
            : E_ALL & ~(E_NOTICE | E_USER_NOTICE | E_DEPRECATED | E_USER_DEPRECATED),
    ],
    'HttpErrorHandler'    =>    [
        // 指定默认处理器
        'handler'    =>    ErrorHandler::class,
    ],
    'imiQueue'  =>  [
        // 默认队列
        'default'   =>  null,
        // 队列列表
        'list'  =>  [
        ],
    ],
];
