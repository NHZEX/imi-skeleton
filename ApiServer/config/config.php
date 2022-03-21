<?php

use Imi\Server\Http\Middleware\RouteMiddleware;
use Imi\Server\Session\Handler\File;
use Imi\Server\Session\Middleware\HttpSessionMiddleware;
use ImiApp\ApiServer\Middleware\DebugInfo;

return [
    'configs'    =>    [
    ],
    // bean扫描目录
    'beanScan'    =>    [
    ],
    'beans'    =>    [
        'SessionManager'    =>    [
            'handlerClass'    =>    File::class,
        ],
        'SessionFile'    =>    [
            'savePath'    =>    app_real_root_path() . '/.runtime/.session/',
        ],
        'SessionConfig'    =>    [

        ],
        'SessionCookie'    =>    [
            'lifetime'    =>    86400 * 30,
        ],
        'HttpDispatcher'    =>    [
            'middlewares'    =>    [
                DebugInfo::class,
                HttpSessionMiddleware::class,
                RouteMiddleware::class,
            ],
        ],
        'HtmlView'    =>    [
            'templatePath'    =>    dirname(__DIR__) . '/template/',
            // 支持的模版文件扩展名，优先级按先后顺序
            'fileSuffixs'        =>    [
                'tpl',
                'html',
                'php'
            ],
        ]
    ],
];