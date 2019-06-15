<?php

namespace App\Services;

use Illuminate\Container\Container;
use Zend\Diactoros\ServerRequest;

class AuthService
{
    /**
     * @var ServerRequest
     */
    private $request;
    
    public function __construct(ServerRequest $request)
    {
        session_start();
        $this->request = $request;
        
    }
    
    public function check()
    {
        if($_SESSION['auth']) return true;
        
        return false;
    }
    
    public function login()
    {
        $_SESSION['auth'] = true;
    }
    
    public function checkCredentials(ServerRequest $request, Container $ioc)
    {
        $admin = $ioc->config['admin'];
        $data = $request->getParsedBody();
        
        if(
            $admin['name'] == $data['username']
            && $admin['password'] == $data['password']
        ){
            $this->login();
            return true;
        }
        
        return false;
    }
    
    public function logout()
    {
        $_SESSION['auth'] = null;
    }
}
