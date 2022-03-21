<?php

use Imi\Util\Format\PhpSerialize;

return [
    // 缓存名称
    'cache'    =>    [
        // 缓存驱动类
        'handlerClass'    =>    \Imi\Cache\Handler\Redis::class,
        // 驱动实例配置
        'option'        =>    [
            'poolName'              =>  'redis',
            'prefix'                =>  'cache:', // 缓存键前缀
            'formatHandlerClass'    =>  PhpSerialize::class, // 数据读写修改器
            'replaceDot'            =>  false, // 将 key 中的 "." 替换为 ":"
        ],
    ],
];