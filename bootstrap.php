<?php

use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\Router;
use Framework\Http\Template\TemplateRenderer;
use Framework\Http\Template\Twig\Extension\RouteExtension;
use Framework\Http\Template\Twig\TwigRenderer;
use Illuminate\Container\Container;
use Twig\Environment;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\ServerRequestFactory;
use Illuminate\Database\Capsule\Manager as Capsule;

$ioc = new Container;

//config
$ioc->singleton("config", function(){
    return include('config.php');
});

// request
$request = ServerRequestFactory::fromGlobals();
$ioc->instance('request', $request);
$ioc->alias('request', ServerRequest::class);

// routes
$aura = new Aura\Router\RouterContainer();

$ioc->bind('routes', function() use ($aura){
    return $aura->getMap();
});

$ioc->bind(Router::class, function() use ($aura){
    return new AuraRouterAdapter($aura);
});

$ioc->alias(Router::class, 'router');

// template
$ioc->bind(Environment::class, function(Container $ioc){
    
    $templateDir = __DIR__ . '/template';
    
    $loader = new Twig\Loader\FilesystemLoader();
    $loader->addPath($templateDir);
    
    $environment = new Twig\Environment($loader, [
        'cache'            => false,
        'debug'            => true,
        'strict_variables' => true,
        'auto_reload'      => true,
    ]);
    
    $environment->addExtension($ioc->make(RouteExtension::class));
    
    return $environment;
});

$ioc->bind(TemplateRenderer::class, TwigRenderer::class);


// database
$capsule = new Capsule;
$capsule->addConnection([
    "driver" => "mysql",
    "host" => $ioc->config['db']['host'],
    "database" => $ioc->config['db']['database'],
    "username" => $ioc->config['db']['username'],
    "password" => $ioc->config['db']['password'],
]);
//Make this Capsule instance available globally.
$capsule->setAsGlobal();
// Setup the Eloquent ORM.
$capsule->bootEloquent();
$capsule->bootEloquent();


// self init
$ioc->singleton(Container::class, function() use ($ioc){
    return $ioc;
});

return $ioc;




