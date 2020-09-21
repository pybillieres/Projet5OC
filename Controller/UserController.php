<?php
namespace Controller;
use Framework\SecureController;

class UserController extends SecureController
{
    public function index()
    {
        
    }

    public function UserHome()
    {
        var_dump($this->CheckAdmin());
        $this->View('UserHome.twig');
    }



}