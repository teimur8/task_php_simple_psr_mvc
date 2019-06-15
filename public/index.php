<?php

use Aura\Router\Map;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\RouteResolver;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

require __DIR__.'/../vendor/autoload.php';

$ioc = require __DIR__ . './../bootstrap.php';

/** @var Map $routes */
$routes = $ioc->routes;

/** @var AuraRouterAdapter $router */
$router = $ioc->router;

$resolver = $ioc->make(RouteResolver::class);

// routes
$routes->get('tasks', '/', "\App\Controller\TaskController@index");
$routes->post('tasks-store', '/', "\App\Controller\TaskController@store");

$routes->get('admin', '/admin', "\App\Controller\AdminController@index");
$routes->get('admin.edit', '/admin/{id}', "\App\Controller\AdminController@edit");
$routes->post('admin.update', '/admin/{id}', "\App\Controller\AdminController@update");





// run
try{
    $result = $router->match($request);
    $response = $resolver->handle($result);
}catch (RequestNotMatchedException $e){
    $response = new HtmlResponse('Undefined page', 404);
}


$emitter = new SapiEmitter();
$emitter->emit($response);



