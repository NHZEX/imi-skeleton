<?php

declare(strict_types=1);

namespace ImiApp\ApiServer;

use Imi\RequestContext;
use Imi\Server\Http\Message\Response;
use Imi\Util\Stream\MemoryStream;
use RuntimeException;
use function is_array;
use function is_object;
use function json_encode_ex;

class Reply
{
    /**
     * 响应请求资源创建成功
     * @param mixed  $data
     * @return Response
     */
    public static function create($data = ''): Response
    {
        return self::success($data, 201);
    }

    /**
     * 响应请求资源不存在
     * @param int|null    $code
     * @param string|null $msg
     * @param array|null  $data
     * @return Response
     */
    public static function notFound(?int $code = null, ?string $msg = null, ?array $data = null): Response
    {
        return self::bad($code, $msg, $data, 404);
    }

    /**
     * 响应成功
     * @param string|int|array|object $data
     * @param int                     $code
     * @return Response
     */
    public static function success($data = '', int $code = 200): Response
    {
        if (200 > $code || $code > 299) {
            throw new RuntimeException('http code only 200 ~ 299');
        }
        if (is_array($data) || is_object($data)) {
            return self::json($data, $code);
        }
        if ($data === '') {
            $code = 204;
        } elseif ($code === 204) {
            $data = '';
        }
        return self::text((string) $data, $code);
    }

    /**
     * 响应请求被拒绝
     * @param int|null    $code
     * @param string|null $msg
     * @param array|null  $data
     * @param int         $httpCode
     * @return Response
     */
    public static function bad(
        ?int $code = null,
        ?string $msg = null,
        ?array $data = null,
        int $httpCode = 400
    ): Response {
        if (400 > $httpCode || $httpCode > 499) {
            throw new RuntimeException('http code only 400 ~ 499');
        }

        return self::message($code, $msg, $data, $httpCode);
    }

    /**
     * 响应请求发生错误
     * @param int|null    $code
     * @param string|null $msg
     * @param array|null  $data
     * @param int         $httpCode
     * @return Response
     */
    public static function error(
        ?int $code = null,
        ?string $msg = null,
        ?array $data = null,
        int $httpCode = 500
    ): Response {
        if (500 > $httpCode || $httpCode > 599) {
            throw new RuntimeException('http code only 500 ~ 599');
        }

        return self::message($code, $msg, $data, $httpCode);
    }

    /**
     * 响应通用消息结构
     * @param int|null    $code
     * @param string|null $msg
     * @param array|null  $data
     * @param int         $httpCode
     * @return Response
     */
    public static function message(?int $code, ?string $msg, ?array $data, int $httpCode): Response
    {
        $code    = $code ?? 1;
        $content = [
            'message' => $msg,
            'errno'   => $code,
        ];
        if ($data) {
            $content += $data;
        }
        return self::json($content, $httpCode);
    }

    /**
     * 响应text内容
     * @param mixed $data
     * @param int   $code
     * @return Response
     */
    public static function text(string $data, int $code = 200): Response
    {
        /** @var Response $response */
        $response = RequestContext::get('response');
        return $response->withStatus($code)
            ->withAddedHeader('Content-Type', 'text/plain')
            ->withBody(new MemoryStream($data));
    }

    /**
     * 响应json内容
     * @param array|object $data
     * @param int   $code
     * @return Response
     */
    public static function json($data = [], int $code = 200): Response
    {
        /** @var Response $response */
        $response = RequestContext::get('response');
        return $response->withStatus($code)
            ->withAddedHeader('Content-Type', 'application/json')
            ->withBody(new MemoryStream(json_encode_ex($data)));
    }
}
