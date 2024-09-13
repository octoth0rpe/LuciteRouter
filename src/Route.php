<?php

declare(strict_types=1);

namespace Lucite\Router;

use Psr\Http\Message\RequestInterface;

class Route
{
    public string $handler;
    public array $args;
    public RequestInterface $request;

    public function __construct(string $handler, array $args, RequestInterface $request)
    {
        $this->handler = $handler;
        $this->args = $args;
        $this->request = $request;
    }

    public function determineClassAndMethod(string $separator = '->'): array
    {
        if (str_contains($this->handler, $separator)) {
            return explode($separator, $this->handler);
        }
        return [$this->handler, $this->request->getMethod()];
    }
}
