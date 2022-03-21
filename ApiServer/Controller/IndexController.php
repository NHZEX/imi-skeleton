<?php

namespace ImiApp\ApiServer\Controller;

use Imi\Controller\HttpController;
use Imi\Server\Http\Message\Contract\IHttpResponse;
use Imi\Server\Http\Route\Annotation\Action;
use Imi\Server\Http\Route\Annotation\Controller;
use Imi\Server\Http\Route\Annotation\Route;
use ImiApp\ApiServer\Reply;

/**
 * @Controller("/")
 */
class IndexController extends HttpController
{
    /**
     * @Action
     * @Route(url="/index", method="GET")
     * @return void
     */
    public function index(): IHttpResponse
    {

        return Reply::text('hello world');
    }
}
