<?php

use Imi\Swoole\Db\Pool\CoroutineDbPool;
use Imi\Swoole\Redis\Pool\CoroutineRedisPool;

return [
    // 主数据库
    'db_erp'      => [
        'pool'     => [
            'class'  => CoroutineDbPool::class,
            'config' => [
                'maxResources' => 8,
                'minResources' => 0,
                'maxActiveTime' => 3600,
                'maxIdleTime'   => 300,
            ],
        ],
        'resource' => [
            'host'     => env('DB_ERP_HOSTNAME', '127.0.0.1'),
            'port'     => (int) env('DB_ERP_HOSTPORT', 3306),
            'username' => env('DB_ERP_USERNAME'),
            'password' => env('DB_ERP_PASSWORD'),
            'database' => env('DB_ERP_DATABASE'),
            'charset'  => 'utf8mb4',
        ],
    ],
    'redis' => [
        'pool'     => [
            'class'  => CoroutineRedisPool::class,
            'config' => [
                'maxResources'  => 8,
                'minResources'  => 0,
                'maxActiveTime' => 3600,
                'maxIdleTime'   => 300,
            ],
        ],
        'resource' => [
            'host'      => env('REDIS_HOST', '127.0.0.1'),
            'port'      => (int) env('REDIS_PORT', 6379),
            'password'  => env('REDIS_PASSWORD'),
            'db'        => (int) env('REDIS_SELECT', 1),
            'timeout'   => (int) env('REDIS_TIMEOUT'),
            'serialize' => false,
        ],
    ],
    'redis_queue' => [
        'pool'     => [
            'class'  => CoroutineRedisPool::class,
            'config' => [
                'maxResources'  => 8,
                'minResources'  => 0,
                'maxActiveTime' => 3600,
                'maxIdleTime'   => 300,
            ],
        ],
        'resource' => [
            'host'      => env('REDIS_HOST', '127.0.0.1'),
            'port'      => (int) env('REDIS_PORT', 6379),
            'password'  => env('REDIS_PASSWORD'),
            'db'        => (int) env('REDIS_SELECT', 2),
            'timeout'   => (int) env('REDIS_TIMEOUT'),
            'serialize' => false,
        ],
    ],
];
