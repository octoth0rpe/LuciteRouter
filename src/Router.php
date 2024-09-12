<?php

declare(strict_types=1);

namespace Lucite\Router;

class Router
{
    protected $paths = [];

    public function get(string $path, string $handler): Router
    {
        $this->paths[$path] = [['GET'], $handler];
        return $this;
    }
    public function post(string $path, string $handler): Router
    {
        $this->paths[$path] = [['POST'], $handler];
        return $this;
    }

    public function patch(string $path, string $handler): Router
    {
        $this->paths[$path] = [['PATCH'], $handler];
        return $this;
    }

    public function delete(string $path, string $handler): Router
    {
        $this->paths[$path] = [['DELETE'], $handler];
        return $this;
    }

    public function map(string $path, array $methods, string $handler): Router
    {
        $this->paths[$path] = [$methods, $handler];
        return $this;
    }

    public function determineRoute(string $method, string $path): string
    {
        if (isset($this->paths[$path])) {
            $details = $this->paths[$path];
            if (in_array($method, $details[0])) {
                return $details[1];
            }
        }
        throw new UnknownRouteException($method, $path);
    }
}
