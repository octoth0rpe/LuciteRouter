<?php

declare(strict_types=1);

namespace Lucite\Router;

class Router
{
    protected $paths = [];

    protected function setupRoute(string $path)
    {
        if (isset($this->paths[$path]) === false) {
            $this->paths[$path] = [];
        }
    }

    public function get(string $path, string $handler): Router
    {
        $this->setupRoute($path);
        $this->paths[$path]['GET'] = $handler;
        return $this;
    }

    public function post(string $path, string $handler): Router
    {
        $this->setupRoute($path);
        $this->paths[$path]['POST'] = $handler;
        return $this;
    }

    public function patch(string $path, string $handler): Router
    {
        $this->setupRoute($path);
        $this->paths[$path]['PATCH'] = $handler;
        return $this;
    }

    public function delete(string $path, string $handler): Router
    {
        $this->setupRoute($path);
        $this->paths[$path]['DELETE'] = $handler;
        return $this;
    }

    public function map(string $path, array $methods, string $handler): Router
    {
        $this->setupRoute($path);
        foreach ($methods as $method) {
            $this->paths[$path][$method] = $handler;
        }
        return $this;
    }

    public function determineRoute(string $method, string $path): array
    {
        $handler = ($this->paths[$path] ?? [])[$method] ?? null;
        if ($handler !== null) {
            return [$handler, strtolower($method)];
        }
        throw new UnknownRouteException($method, $path);
    }
}
