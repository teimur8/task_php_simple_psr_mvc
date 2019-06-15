<?php

namespace Framework\Http\Template\Twig\Extension;

use Framework\Http\Router\Router;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Zend\Diactoros\ServerRequest;

class RouteExtension extends AbstractExtension
{
    private $router;
    /**
     * @var ServerRequest
     */
    private $request;
    
    public function __construct(Router $router, ServerRequest $request)
    {
        $this->router = $router;
        $this->request = $request;
//        dd($request);
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('path', [$this, 'generatePath']),
        ];
    }

    public function generatePath($name, array $params = [], array $query = []): string
    {
        if(!empty($query)){
            $path =  $this->router->generate($name, $params);
            return $path . '?' . http_build_query(array_merge($this->request->getQueryParams(), $query));
        }else{
            return $this->router->generate($name, $params);
        }
    }
    
    
    
}
