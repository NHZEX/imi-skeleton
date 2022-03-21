<?php

use Imi\App;
use Imi\AppContexts;

function app_real_root_path(): string
{
    return App::get(AppContexts::APP_PATH_PHYSICS);
}

function app_src_root_path(): string
{
    return IMI_IN_PHAR ? \Phar::running() : app_real_root_path();
}

/**
 * 获取环境变量值
 * @param string|null $name
 * @param mixed       $default
 * @return string|int|bool|null
 */
function env(string $name = null, $default = null)
{
    return $_ENV[$name] ?? $default;
}

/**
 * @param mixed $value
 * @param int   $options
 * @param int   $depth
 * @return false|string
 */
function json_encode_ex($value, int $options = 0, int $depth = 512)
{
    $options |= JSON_UNESCAPED_UNICODE;
    $options |= JSON_UNESCAPED_SLASHES;
    if (PHP_VERSION_ID >= 70300) {
        $options |= JSON_THROW_ON_ERROR;
    }
    return json_encode($value, $options, $depth);
}

/**
 * @param string $value
 * @param bool   $assoc
 * @param int    $depth
 * @param int    $options
 * @return mixed
 */
function json_decode_ex(string $value, bool $assoc = true, int $depth = 512, int $options = 0)
{
    if (PHP_VERSION_ID >= 70300) {
        $options |= JSON_THROW_ON_ERROR;
    }
    return json_decode($value, $assoc, $depth, $options);
}