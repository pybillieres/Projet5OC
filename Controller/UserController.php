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
        $this->View('UserHome.twig');
    }



}