<?php

namespace App\Controller;

use App\Services\AuthService;
use App\Services\TaskServices;
use Framework\Http\Template\TemplateRenderer;
use Illuminate\Container\Container;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Diactoros\ServerRequest;

class LoginController
{
    private $template;

    private $services;
    /**
     * @var Container
     */
    private $ioc;
    
    public function __construct(TemplateRenderer $template, AuthService $services, Container $ioc)
    {
        $this->template = $template;
        $this->services = $services;
        $this->ioc = $ioc;
    }
    
    public function index()
    {
        return new HtmlResponse($this->template->render('app/login/index'));
    }
    
    public function store(ServerRequest $request)
    {
        $result = $this->services->checkCredentials($request, $this->ioc);
        
        if($result) return new RedirectResponse('/admin');
        
        return new RedirectResponse('/login');
    }
    
    public function logout()
    {
        $this->services->logout();
    
        return new RedirectResponse('/');
    }
    

}
