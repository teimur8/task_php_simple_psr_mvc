<?php

namespace App\Controller;

use App\Services\TaskServices;
use Framework\Http\Template\TemplateRenderer;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Diactoros\ServerRequest;

class AdminController
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
       
        return new HtmlResponse($this->template->render('app/admin/index', compact('items')));
    }
    
    public function edit(ServerRequest $request, $id)
    {
        $item = $this->services->show($id);
        
        return new HtmlResponse($this->template->render('app/admin/edit', compact('item')));
    }
    
    public function update(ServerRequest $request, $id)
    {
        $this->services->update($request->getParsedBody(), $id);
        
        return new RedirectResponse("/admin");
    }
}
