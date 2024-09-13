<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Lucite\Utils\MockRequest;
use Lucite\Router\Router;

class MultipleMatchPatternTest extends TestCase
{
    public function testHandlesInfixMatch(): void
    {
        $router = new Router();
        $router->post('/books/*/sales', 'HandlerClass');
        $route = $router->determineRoute(new MockRequest('POST', '/books/999a9/sales'));
        $this->assertSame($route->handler, 'HandlerClass');
        $this->assertSame($route->args[0], '999a9');
    }

    public function testHandlesMultipleMatch(): void
    {
        $router = new Router();
        $router->get('/books/*/editions/*', 'HandlerClass');
        $route = $router->determineRoute(new MockRequest('GET', '/books/1234/editions/5678'));
        $this->assertSame($route->handler, 'HandlerClass');
        $this->assertSame($route->args[0], '1234');
        $this->assertSame($route->args[1], '5678');
    }


    public function testHandlesMultipleMatchParamNames(): void
    {
        $router = new Router();
        $router->get('/books/*/editions/*', 'HandlerClass', ['bookId', 'editionId']);
        $route = $router->determineRoute(new MockRequest('GET', '/books/1234/editions/5678'));
        $this->assertSame($route->handler, 'HandlerClass');
        $this->assertSame($route->args['bookId'], '1234');
        $this->assertSame($route->args['editionId'], '5678');
    }
}
