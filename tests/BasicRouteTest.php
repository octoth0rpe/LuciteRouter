<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Lucite\Utils\MockRequest;
use Lucite\Router\Router;
use Lucite\Router\UnknownRouteException;

final class BasicRouteTest extends TestCase
{
    public function testCanMapGetRequest(): void
    {
        $router = new Router();
        $router->get('/books', 'HandlerClass');
        $route = $router->determineRoute(new MockRequest('GET', '/books'));
        $this->assertSame($route->handler, 'HandlerClass');
    }

    public function testThrowsExceptionForUnknownRoute(): void
    {
        $this->expectException(UnknownRouteException::class);
        $router = new Router();
        $router->determineRoute(new MockRequest('POST', '/books'));
    }

    public function testRegisterMultipleMethodsIndividually(): void
    {
        $router = new Router();
        $router->get('/books', 'HandlerClass');
        $router->post('/books', 'HandlerClass');

        $route = $router->determineRoute(new MockRequest('POST', '/books'));
        $this->assertSame($route->handler, 'HandlerClass');


        $route = $router->determineRoute(new MockRequest('GET', '/books'));
        $this->assertSame($route->handler, 'HandlerClass');
    }
}
