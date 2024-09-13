<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Lucite\Router\Router;

class SingleMatchPatternTest extends TestCase
{
    public function testHandlesPOSTAndSetsArgs(): void
    {
        $router = new Router();
        $router->post('/books/*', 'HandlerClass');
        $handler = $router->determineRoute('POST', '/books/999a9');
        $this->assertSame($handler[0], 'HandlerClass');
        $this->assertSame($handler[1], 'post');
        $this->assertSame($handler[2][0], '999a9');
    }

    public function testHandlesParameterNames(): void
    {
        $router = new Router();
        $router->post('/books/*', 'HandlerClass', ['id']);
        $handler = $router->determineRoute('POST', '/books/343636');
        $this->assertSame($handler[0], 'HandlerClass');
        $this->assertSame($handler[1], 'post');
        $this->assertSame($handler[2]['id'], '343636');
    }
}
