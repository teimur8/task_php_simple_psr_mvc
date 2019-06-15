<?php

namespace Framework\Http\Router;

use Illuminate\Container\Container;

class RouteResolver
{
    /**
     * @var Container
     */
    private $ioc;
    
    public function __construct(Container $ioc){
        $this->ioc = $ioc;
    }
    
    public function handle(Result $result)
    {
        $handler = $result->getHandler();
    
        $controller = $this->ioc->make($handler->getClass());
        $method = $handler->getMethod();
        
        $response = call_user_func_array([$controller,$method], $result->getAttributes());
        
    }
}
