<?php
namespace ImiApp\ApiServer\Middleware;

use Imi\Log\Log;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function env;
use function microtime;
use function sprintf;

/**
 * 增加一个响应头，仅作演示，生产环境请去除
 */
class DebugInfo implements MiddlewareInterface
{
    private ?bool $isDebug;

    public function __construct()
    {
        $this->isDebug = (bool) env('APP_DEBUG');
    }

    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $_t1 = microtime(true);
            return $handler->handle($request)->withAddedHeader('X-Powered-By', 'imi-2.0');
        } finally {
            if ($this->isDebug) {
                Log::debug(sprintf('[Http] %s (%.3fs)', $request->getUri(), microtime(true) - $_t1));
            }
        }
    }
}