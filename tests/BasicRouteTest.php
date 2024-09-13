<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Lucite\Router\Router;
use Lucite\Router\UnknownRouteException;

final class BasicRouteTest extends TestCase
{
    public function testCanMapGetRequest(): void
    {
        $router = new Router();
        $router->get('/books', 'HandlerClass');
        $handler = $router->determineRoute('GET', '/books');
        $this->assertSame($handler[0], 'HandlerClass');
        $this->assertSame($handler[1], 'get');
    }

    public function testThrowsExceptionForUnknownRoute(): void
    {
        $this->expectException(UnknownRouteException::class);
        $router = new Router();
        $router->determineRoute('POST', '/books');
    }

    public function testRegisterMultipleMethodsIndividually(): void
    {
        $router = new Router();
        $router->get('/books', 'HandlerClass');
        $router->post('/books', 'HandlerClass');

        $handler = $router->determineRoute('POST', '/books');
        $this->assertSame($handler[0], 'HandlerClass');
        $this->assertSame($handler[1], 'post');

        $handler = $router->determineRoute('GET', '/books');
        $this->assertSame($handler[0], 'HandlerClass');
        $this->assertSame($handler[1], 'get');
    }
}
