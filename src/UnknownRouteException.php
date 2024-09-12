<?php

declare(strict_types=1);

namespace Lucite\Router;

class UnknownRouteException extends \Exception
{
    public function __construct(string $method, string $path)
    {
        return parent::__construct("Unknown route: [$method] $path");
    }
}
