<?php

declare(strict_types=1);

namespace Lucite\Router;

use Psr\Http\Message\RequestInterface;

class UnknownRouteException extends \Exception
{
    public function __construct(RequestInterface $request)
    {
        $method = $request->getMethod();
        $path = $request->getUri()->getPath();
        return parent::__construct("Unknown route: [$method] $path");
    }
}
