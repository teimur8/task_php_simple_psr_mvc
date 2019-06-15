<?php

namespace Framework\Http\Router;

class Handler
{
    private $class;
    private $method;

    public function __construct($arr)
    {
        $this->class= $arr[0];
        $this->method= $arr[1];
    }
    
    public function getClass()
    {
        return $this->class;
    }
    
    public function getMethod()
    {
        return $this->method;
    }
}
