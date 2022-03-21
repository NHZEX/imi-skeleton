<?php

require __DIR__ . '/vendor/autoload.php';

use Imi\App;
use Imi\AppContexts;
use Imi\Util\Imi;
use ImiApp\ApiServer\Model\Express\OrderRecordTrack;
use Swoole\Timer;

return function (callable $fn) {
    class TestApp extends \Imi\Swoole\SwooleApp
    {
        /**
         * 运行应用.
         */
        public function run(): void
        {
        }
        /**
         * 加载运行时.
         */
        public function loadRuntime(): int
        {
            var_dump(Imi::getCurrentModeRuntimePath('imi-runtime'));
            // return \Imi\Core\App\Enum\LoadRuntimeResult\LoadRuntimeResult::NONE;
            return parent::loadRuntime();
        }
    }

    \Swoole\Coroutine\run(static function () use ($fn) {
        App::setNx(AppContexts::APP_PATH, __DIR__, true);
        App::runApp(__DIR__ . '/vendor', \TestApp::class);

        $fn();

        echo "stop...\n";
        Timer::clearAll();
    });
};
