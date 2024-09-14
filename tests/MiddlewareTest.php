<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Lucite\Container\Container;
use Lucite\Factory\Factory;
use Lucite\Router\Router;
use Lucite\Utils\MockResponse;
use Lucite\Router\RouterMiddleware;

class MiddlewareTest extends TestCase
{
    public function testCanInstantiateRouterMiddleware(): void
    {
        $uri = new RouterMiddleware(
            new MockResponse(),
            new Router(),
            new Factory(new Container()),
        );
        $this->assertTrue(true);
    }
}
