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
        [$handler, $method, $args] = $router->determineRoute(new MockRequest('POST', '/books/999a9/sales'));
        $this->assertSame($handler, 'HandlerClass');
        $this->assertSame($method, 'post');
        $this->assertSame($args[0], '999a9');
    }

    public function testHandlesMultipleMatch(): void
    {
        $router = new Router();
        $router->get('/books/*/editions/*', 'HandlerClass');
        [$handler, $method, $args] = $router->determineRoute(new MockRequest('GET', '/books/1234/editions/5678'));
        $this->assertSame($handler, 'HandlerClass');
        $this->assertSame($method, 'get');
        $this->assertSame($args[0], '1234');
        $this->assertSame($args[1], '5678');
    }


    public function testHandlesMultipleMatchParamNames(): void
    {
        $router = new Router();
        $router->get('/books/*/editions/*', 'HandlerClass', ['bookId', 'editionId']);
        [$handler, $method, $args] = $router->determineRoute(new MockRequest('GET', '/books/1234/editions/5678'));
        $this->assertSame($handler, 'HandlerClass');
        $this->assertSame($method, 'get');
        $this->assertSame($args['bookId'], '1234');
        $this->assertSame($args['editionId'], '5678');
    }
}
