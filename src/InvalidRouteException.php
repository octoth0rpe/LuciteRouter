<?php

declare(strict_types=1);

namespace Lucite\Router;

class InvalidRouteException extends \Exception
{
    public function __construct(string $route, string $separator)
    {
        return parent::__construct("Invalid route, route must be constructed as classname{$separator}method, got $route");
    }
}
