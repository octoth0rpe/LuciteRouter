<?php

declare(strict_types=1);

namespace Lucite\Router;

use Psr\Http\Message\RequestInterface;

class Router
{
    public $by_method = [
        'GET' => [
            'exact' => [],
            'pattern' => [],
        ],
        'POST' => [
            'exact' => [],
            'pattern' => [],
        ],
        'PATCH' => [
            'exact' => [],
            'pattern' => [],
        ],
        'DELETE' => [
            'exact' => [],
            'pattern' => [],
        ],
    ];

    protected function determinePathType(string $path): string
    {
        return (str_contains($path, '*')) ? 'pattern' : 'exact';
    }

    public function get(string $path, string $handler, $param_names = []): Router
    {
        $path_type = $this->determinePathType($path);
        $this->by_method['GET'][$path_type][$path] = [$handler, $param_names];
        return $this;
    }

    public function post(string $path, string $handler, $param_names = []): Router
    {
        $path_type = $this->determinePathType($path);
        $this->by_method['POST'][$path_type][$path] = [$handler, $param_names];
        return $this;
    }

    public function patch(string $path, string $handler, $param_names = []): Router
    {
        $path_type = $this->determinePathType($path);
        $this->by_method['PATCH'][$path_type][$path] = [$handler, $param_names];
        return $this;
    }

    public function delete(string $path, string $handler, $param_names = []): Router
    {
        $path_type = $this->determinePathType($path);
        $this->by_method['DELETE'][$path_type][$path] = [$handler, $param_names];
        return $this;
    }

    public function map(string $path, array $methods, string $handler, $param_names = []): Router
    {
        $path_type = $this->determinePathType($path);
        foreach ($methods as $method) {
            $this->by_method[$method][$path_type][$path] = [$handler, $param_names];
        }
        return $this;
    }

    public function determineRoute(RequestInterface $request): array
    {
        $method = $request->getMethod();
        $path = $request->getUri()->getPath();

        $possibles = $this->by_method[$method];
        # check for simple matches (ie, url is /books and path is /books)
        # if we don't find one, then check for pattern matches (url is /b/5, path is /b/*('
        if (isset($possibles['exact'][$path])) {
            return [$possibles['exact'][$path][0], strtolower($method), []];
        }
        foreach ($possibles['pattern'] as $pattern => $handler_details) {
            if (fnmatch($pattern, $path)) {
                [$handler, $param_names] = $handler_details;
                $regex = str_replace('/', '\/', $pattern);
                $regex = str_replace('*', '([^\/]*)', $regex);
                $regex = '/^'.$regex.'$/';
                $result = preg_match_all($regex, $path, $matches, PREG_SET_ORDER);
                if ($result === false) {
                    break;
                }
                $matches = $matches[0];
                array_shift($matches);
                if (count($param_names) === 0) {
                    return [$handler, strtolower($method), $matches];
                }
                $aliased_matches = [];
                foreach ($param_names as $index => $name) {
                    $aliased_matches[$name] = $matches[$index];
                }
                return [$handler, strtolower($method), $aliased_matches];
                ;
            }
        }

        throw new UnknownRouteException($request->getMethod(), $request->getUri()->getPath());
    }
}
