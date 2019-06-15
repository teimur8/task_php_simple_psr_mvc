<?php

namespace Framework\Http\Router;

use App\Services\AuthService;
use Illuminate\Container\Container;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;

class RouteResolver
{
    /**
     * @var Container
     */
    private $ioc;
    
    public function __construct(Container $ioc)
    {
        $this->ioc = $ioc;
    }
    
    public function handle(Result $result)
    {
        $handler = $result->getHandler();
        
        
        $handler = explode("|", $handler);
        
        if (!$this->checkAuth($handler[1]))
            return new RedirectResponse("/login");
        
        try {
            $response = $this->ioc->call($handler[0], $result->getAttributes());
        } catch (\Exception $e) {
            $response = new HtmlResponse($e->getMessage(), 500);
        }
        
        return $response;
    }
    
    private function checkAuth($auth = null)
    {
        if (!empty($auth) && $auth == 'auth') {
            return $this->ioc->make(AuthService::class)->check();
        }
        
        return true;
        
    }
}
