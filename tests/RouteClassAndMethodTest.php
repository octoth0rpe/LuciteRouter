<?php

declare(strict_types=1);

use Lucite\Router\Route;
use PHPUnit\Framework\TestCase;
use Lucite\Utils\MockRequest;

class RouteClassAndMethodTest extends TestCase
{
    public function testUsesHttpMethod(): void
    {
        $request = new MockRequest('GET', '/books');
        $route = new Route('HandlerClass', [], $request);
        [$class, $method] = $route->determineClassAndMethod();
        $this->assertEquals('HandlerClass', $class);
        $this->assertEquals('GET', $method);
    }

    public function testHandlesExplicitMethodWithDefaultSeparator(): void
    {
        $request = new MockRequest('POST', '/books');
        $route = new Route('HandlerClass->handleSave', [], $request);
        [$class, $method] = $route->determineClassAndMethod();
        $this->assertEquals('HandlerClass', $class);
        $this->assertEquals('handleSave', $method);
    }

    public function testHandlesExplicitMethodWithCustomSeparator(): void
    {
        $request = new MockRequest('POST', '/books');
        $route = new Route('HandlerClass::handleSave', [], $request);
        [$class, $method] = $route->determineClassAndMethod('::');
        $this->assertEquals('HandlerClass', $class);
        $this->assertEquals('handleSave', $method);
    }
}
