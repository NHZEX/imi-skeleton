<?php

namespace ImiApp\ApiServer;

use function is_dir;
use function is_writable;
use function sys_get_temp_dir;

class Util
{
    public static function getTmpDir(): string
    {
        if (is_dir('/dev/shm') && is_writable('/dev/shm')) {
            $cacheDir = '/dev/shm';
        } elseif (is_dir('/run/shm') && is_writable('/run/shm')) {
            $cacheDir = '/run/shm';
        } else {
            $cacheDir = sys_get_temp_dir();
        }

        return $cacheDir;
    }

    public static function getTmpCacheDir(string $prefix = '', bool $autoCreate = true): string
    {
        $dir = self::getTmpDir() . '/' . uniqid($prefix, true);
        if ($autoCreate && !is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        return $dir;
    }
}
