<?php

namespace App\Controller;

use App\Services\TaskServices;
use Framework\Http\Template\TemplateRenderer;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Diactoros\ServerRequest;

class TaskController
{
    private $template;
    /**
     * @var TaskServices
     */
    private $services;
    
    public function __construct(TemplateRenderer $template, TaskServices $services)
    {
        $this->template = $template;
        $this->services = $services;
    }
    
    public function index(ServerRequest $request)
    {
        $items = $this->services->get($request);
        
        return new HtmlResponse($this->template->render('app/task/index', [
            'items' => $items
        ]));
    }
    
    public function store(ServerRequest $request)
    {
        $this->services->create($request);
        
        return new RedirectResponse('/');
    }
}
