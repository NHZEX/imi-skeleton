<?php

namespace ImiApp\ApiServer\Listener;

use Imi\Bean\Annotation\Listener;
use Imi\Db\Event\Param\DbPrepareEventParam;
use Imi\Event\EventParam;
use Imi\Event\IEventListener;
use Imi\Log\Log;
use function env;

/**
 * @Listener("IMI.DB.PREPARE")
 */
class DbPrepareListener implements IEventListener
{
    /**
     * 事件处理方法.
     *
     * @param DbPrepareEventParam $e
     *
     * @return void
     */
    public function handle(EventParam $e): void
    {
        if (env('DB_DEBUG')) {
            Log::debug('[prepare] ' . $e->sql);
        }
    }
}