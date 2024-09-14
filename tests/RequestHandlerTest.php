<?php

declare(strict_types=1);

use Lucite\Container\Container;
use Lucite\Factory\Factory;
use Lucite\Router\RequestHandler;
use Lucite\Router\Router;
use Lucite\Utils\MockResponse;
use PHPUnit\Framework\TestCase;

class RequestHandlerTest extends TestCase
{
    public function testCanInstantiateRequestHandler(): void
    {
        new RequestHandler(
            new MockResponse(),
            new Router(),
            new Factory(new Container()),
        );
        $this->assertTrue(true);
    }
}
