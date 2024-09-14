<?php

declare(strict_types=1);

namespace Lucite\Router;

use Lucite\Factory\Factory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RequestHandler implements RequestHandlerInterface
{
    public ResponseInterface $response;
    public Router $router;
    public Factory $factory;

    public function __construct(ResponseInterface $response, Router $router, Factory $factory)
    {
        $this->response = $response;
        $this->router = $router;
        $this->factory = $factory;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $route = $this->router->determineRoute($request);
        [$class, $method] = $route->determineClassAndMethod();
        $object = $this->factory->assemble($class);
        return $object->$method($request, $this->response, $route->args);
    }
}
