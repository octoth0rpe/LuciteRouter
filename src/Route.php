<?php

declare(strict_types=1);

namespace Lucite\Router;

class Route
{
    public string $handler;
    public array $args;

    public function __construct(string $handler, array $args = [])
    {
        $this->handler = $handler;
        $this->args = $args;
    }
}
