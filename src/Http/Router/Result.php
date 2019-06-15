<?php

namespace Framework\Http\Router;

class Result
{
    private $name;
    private $handler;
    private $attributes;

    public function __construct($name, $handler, array $attributes)
    {
        $this->name = $name;
        $this->handler = $handler;
        $this->attributes = $attributes;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHandler(): Handler
    {
        return new Handler($this->handler);
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
