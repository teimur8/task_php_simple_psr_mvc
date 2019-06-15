<?php

use Framework\Http\Router\AuraRouterAdapter;
use Illuminate\Container\Container;
use Zend\Diactoros\ServerRequestFactory;

$ioc = new Container;

//config
$ioc->singleton("config", function(){
    return include('config.php');
});

// request
$request = ServerRequestFactory::fromGlobals();
$ioc->instance('request', $request);

// routes
$aura = new Aura\Router\RouterContainer();

$ioc->bind('routes', function() use ($aura){
    return $aura->getMap();
});

$ioc->bind('router', function() use ($aura){
    return new AuraRouterAdapter($aura);
});

// template

// database


$ioc->singleton(Container::class, function() use($ioc){
    return $ioc;
});

return $ioc;




