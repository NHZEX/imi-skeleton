<?php

namespace ImiApp\ApiServer;

use Imi\App;
use Imi\Log\Log;
use Imi\RequestContext;
use Imi\Server\Http\Error\JsonErrorHandler;
use Imi\Server\View\Handler\Json;
use ImiApp\ApiServer\Exception\ValidationException;
use function explode;

class ErrorHandler extends JsonErrorHandler
{
    protected bool $releaseShow = false;

    protected bool $cancelThrow = false;

    public function handle(\Throwable $throwable): bool
    {
        if ($throwable instanceof ValidationException) {
            $data = [
                'success' => false,
                'message' => '[Validation] ' . $throwable->getMessage(),
            ];

            /** @var Json $jsonView */
            $jsonView = RequestContext::getServer()->getBean('JsonView');
            $jsonView
                ->handle($this->viewAnnotation, null, $data, RequestContext::getContext()['response'] ?? null)
                ->withStatus(400)
                ->send();

            Log::warning($data['message']);

            return true;
        }
        if ($this->releaseShow || App::isDebug())
        {
            $data = [
                'message'   => $throwable->getMessage(),
                'code'      => $throwable->getCode(),
                'file'      => $throwable->getFile(),
                'line'      => $throwable->getLine(),
                'trace'     => explode(\PHP_EOL, $throwable->getTraceAsString()),
            ];
        }
        else
        {
            $data = [
                'success' => false,
                'message' => 'error',
            ];
        }
        $requestContext = RequestContext::getContext();
        /** @var Json $jsonView */
        $jsonView = $requestContext['server']->getBean('JsonView');
        $jsonView
            ->handle($this->viewAnnotation, null, $data, $requestContext['response'] ?? null)
            ->withStatus(500)
            ->send();

        return $this->cancelThrow;
    }
}
