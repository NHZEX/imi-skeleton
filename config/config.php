<?php

use Imi\App;
use Imi\Log\Formatter\ConsoleLineFormatter;
use Imi\Log\Handler\ConsoleHandler;
use Imi\Swoole\Server\Type;
use ImiApp\ApiServer\Exception\ValidationException;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;

$mode = App::isInited() ? App::getApp()->getType() : null;

return [
    // 项目根命名空间
    'namespace' => 'ImiApp',

    // 运行时目录
    'runtimePath' => app_real_root_path() . '/.runtime',

    // 配置文件
    'configs'   => [
        'beans'  => __DIR__ . '/beans.php',
        'pools'  => __DIR__ . '/pools.php',
        'lock'   => __DIR__ . '/lock.php',
        'caches' => __DIR__ . '/caches.php',
        'tools'  => __DIR__ . '/tools.php',
    ],

    'ignoreNamespace' => [
    ],

    'ignorePaths' => [
        dirname(__DIR__) . DIRECTORY_SEPARATOR . 'public',
        dirname(__DIR__) . DIRECTORY_SEPARATOR . 'helpers',
        dirname(__DIR__) . DIRECTORY_SEPARATOR . 'test*.php',
    ],

    // Swoole 主服务器配置
    'mainServer'  => [
        'namespace' => 'ImiApp\ApiServer',
        'type'      => Type::HTTP,
        'host'      => env('SERV_HTTP_HOST', '127.0.0.1'),
        'port'      => (int) env('SERV_HTTP_PORT', 8087),
        'mode'      => SWOOLE_BASE,
        'configs'   => [
            //            'admin_server'  => '0.0.0.0:9502',
            'worker_num'      => (int) env('SERV_WORKER_NUM', 2),
            'task_worker_num' => (int) env('SERV_TASK_WORKER_NUM', 0),
            'dispatch_mode'   => 3,
            'log_file'        => app_real_root_path() . '/.runtime/swoole/swoole.log',
            'log_rotation'    => SWOOLE_LOG_ROTATION_DAILY,
            'package_max_length' => 1024 * 1024 * 64,
        ],
    ],

    // Swoole 子服务器（端口监听）配置
    'subServers'  => [],

    // 数据库配置
    'db'          => [
        // 数默认连接池名
        'defaultPool' => 'db_erp',
    ],

    // redis 配置
    'redis'       => [
        // 数默认连接池名
        'defaultPool' => 'redis',
    ],

    // 内存表配置
    'memoryTable' => [
        // 't1'    =>  [
        //     'columns'   =>  [
        //         ['name' => 'name', 'type' => \Swoole\Table::TYPE_STRING, 'size' => 16],
        //         ['name' => 'quantity', 'type' => \Swoole\Table::TYPE_INT],
        //     ],
        //     'lockId'    =>  'atomic',
        // ],
    ],

    'cache'   => [
        'default' => 'alias1',
    ],

    // atmoic 配置
    'atomics' => [
        // 'atomicLock'   =>  1,
    ],

    // 日志配置
    'logger'  => [
        'channels' => [
            'imi' => [
                'handlers' => [
                    [
                        'class'     => ConsoleHandler::class,
                        'formatter' => [
                            'class'     => ConsoleLineFormatter::class,
                            'construct' => [
                                'format'                     => null,
                                'dateFormat'                 => 'Y-m-d H:i:s',
                                'allowInlineLineBreaks'      => true,
                                'ignoreEmptyContextAndExtra' => true,
                            ],
                        ],
                    ],
                    [
                        'class'     => RotatingFileHandler::class,
                        'construct' => [
                            'filename' => app_real_root_path() . '/.runtime/logs/log.log',
                        ],
                        'formatter' => [
                            'class'     => LineFormatter::class,
                            'construct' => [
                                'dateFormat'                 => 'Y-m-d H:i:s',
                                'allowInlineLineBreaks'      => true,
                                'ignoreEmptyContextAndExtra' => true,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    'validation' => [
        'exception' => ValidationException::class,
        'exCode' => 0,
    ],
];
