<?php

namespace Framework\Http\Router;

use Illuminate\Container\Container;
use Zend\Diactoros\Response\HtmlResponse;

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
        
        try {
            $response = $this->ioc->call($handler, $result->getAttributes());
        } catch (\Exception $e) {
            $response = new HtmlResponse($e->getMessage(), 500);
        }
        
        return $response;
    }
}
