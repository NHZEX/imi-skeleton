<?php

use Imi\Event\Event;
use Imi\Event\EventParam;
use Imi\Log\Log;
use Imi\Swoole\Server\Event\Param\ManagerStartEventParam;
use Imi\Swoole\Server\Event\Param\StartEventParam;
use Imi\Swoole\Server\Event\Param\WorkerStartEventParam;
use Imi\Swoole\Server\Event\Param\WorkerStopEventParam;
use Swoole\Process;

require_once __DIR__ . '/helpers/func.php';

define('SERV_START_TIME', microtime(true));

Event::on('IMI.INITED', static function () {
    @mkdir(__DIR__ . '/.runtime/swoole', true);
});

Event::on('IMI.LOAD_CONFIG', static function () {
    date_default_timezone_set(env('APP_TIMEZONE', 'Asia/Shanghai'));

    if (extension_loaded('posix')) {
        $user = posix_getpwnam(env('RUN_USER'));

        if (!empty($user)) {
            posix_setgid($user['gid']);
            posix_setuid($user['uid']);
        }
    }
});

Event::on('IMI.MAIN_SERVER.START', static function (StartEventParam $param) {
    static $WORKER_START_TIME = null;
    if ($WORKER_START_TIME === null) {
        $WORKER_START_TIME = microtime(true);
    }
    Log::debug(sprintf(
        'master start [%s], pid:%d, start time: %.2fs',
        $param->server->getName(),
        $param->server->getSwooleServer()->master_pid,
        $WORKER_START_TIME - SERV_START_TIME,
    ));
});

Event::on('IMI.MAIN_SERVER.MANAGER.START', static function (ManagerStartEventParam $param) {
    static $WORKER_START_TIME = null;
    if ($WORKER_START_TIME === null) {
        $WORKER_START_TIME = microtime(true);
    }
    Log::debug(sprintf(
        'manager start [%s], pid:%d, start time: %.2fs',
        $param->server->getName(),
        $param->server->getSwooleServer()->master_pid,
        $WORKER_START_TIME - SERV_START_TIME,
    ));
});

Event::on('IMI.MAIN_SERVER.WORKER.START', static function (WorkerStartEventParam $param) {
    static $WORKER_START_TIME = null;
    if ($WORKER_START_TIME === null) {
        $WORKER_START_TIME = microtime(true);
    }
    Log::debug(sprintf(
        'worker start [%s]#%d, pid:%d, start time: %.2fs',
        $param->server->getName(),
        $param->workerId,
        posix_getpid(),
        $WORKER_START_TIME - SERV_START_TIME,
    ));
});

Event::on('IMI.PROCESS.BEGIN', static function (EventParam $param) {
    static $WORKER_START_TIME = null;
    if ($WORKER_START_TIME === null) {
        $WORKER_START_TIME = microtime(true);
    }
    /** @var Process $process */
    ['name' => $name, 'process' => $process] = $param->getData();
    Log::debug(sprintf(
        'process start [%s]#%d, pid:%d, start time: %.2fs',
        $name,
        $process->id,
        $process->pid,
        $WORKER_START_TIME - SERV_START_TIME,
    ));
});

Event::on('IMI.MAIN_SERVER.WORKER.STOP', static function (WorkerStopEventParam $param) {
    Log::debug(sprintf('worker stop #%d, pid:%d', $param->workerId, posix_getpid()));
});