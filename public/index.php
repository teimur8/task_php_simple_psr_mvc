<?php

use Aura\Router\Map;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\RouteResolver;
use Zend\Diactoros\Response\HtmlResponse;

require __DIR__.'/../vendor/autoload.php';

$ioc = require __DIR__ . './../bootstrap.php';

/** @var Map $routes */
$routes = $ioc->routes;

/** @var AuraRouterAdapter $router */
$router = $ioc->router;

$resolver = $ioc->make(RouteResolver::class);

// routes
$routes->get('home', '/', [\App\Controller\TaskController::class, 'index']);

// run
try{
    $result = $router->match($request);
    $response = $resolver->handle($result);
}catch (RequestNotMatchedException $e){
    $response = new HtmlResponse('Undefined page', 404);
}





