<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Lucite\Utils\MockRequest;
use Lucite\Router\Router;

class SingleMatchPatternTest extends TestCase
{
    public function testHandlesPOSTAndSetsArgs(): void
    {
        $router = new Router();
        $router->post('/books/*', 'HandlerClass');
        $route = $router->determineRoute(new MockRequest('POST', '/books/999a9'));
        $this->assertSame($route->handler, 'HandlerClass');
        $this->assertSame($route->args[0], '999a9');
    }

    public function testHandlesParameterNames(): void
    {
        $router = new Router();
        $router->post('/books/*', 'HandlerClass', ['id']);
        $route = $router->determineRoute(new MockRequest('POST', '/books/343636'));
        $this->assertSame($route->handler, 'HandlerClass');
        $this->assertSame($route->args['id'], '343636');
    }
}
