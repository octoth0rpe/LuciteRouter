<?php

declare(strict_types=1);

use Lucite\Router\Router;
use Lucite\Router\UnknownRouteException;
use PHPUnit\Framework\TestCase;

final class BasicRouteTest extends TestCase
{
    public function testCanMapGetRequest(): void
    {
        $router = new Router();
        $router->get('/books', 'book_get_handler');
        $handler = $router->determineRoute('GET', '/books');
        $this->assertSame($handler, 'book_get_handler');
    }

    public function testThrowsExceptionForUnknownRoute(): void
    {
        $this->expectException(UnknownRouteException::class);
        $router = new Router();
        $router->determineRoute('GET', '/books');

    }
}
