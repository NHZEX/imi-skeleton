<?php

namespace ImiApp\ApiServer\Listener;

use Imi\Bean\Annotation\Listener;
use Imi\Db\Event\Param\DbExecuteEventParam;
use Imi\Event\EventParam;
use Imi\Event\IEventListener;
use Imi\Log\Log;
use Symfony\Component\VarExporter\VarExporter;
use function env;
use function sprintf;

/**
 * @Listener("IMI.DB.EXECUTE")
 */
class DbExecuteListener implements IEventListener
{
    /**
     * 事件处理方法.
     *
     * @param DbExecuteEventParam $e
     *
     * @return void
     */
    public function handle(EventParam $e): void
    {
        if (env('DB_DEBUG')) {
            Log::debug(sprintf('[%.3fs] %s (%s)', $e->time, $e->sql, VarExporter::export($e->bindValues)));
        }
    }
}