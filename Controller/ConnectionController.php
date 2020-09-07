<?php
namespace Controller;
use Framework\Controller;
use Model\UserManager;
use Controller\UserController;

class ConnectionController extends Controller
{
    function index()
    {
        $this->connectionView();
    }

    function connectionView()
    {
        echo $this->twig->render('connection.twig');
    }

    function login()
    {

        if($this->request->existParameter("login") && $this->request->existParameter("password"))
        {
            $login = $this->request->parameter('login');
            $password = md5($this->request->parameter('password'));
            $userManager = new UserManager;
            $user = $userManager->getUserByLogin($login);
            if($user !== null)
            {
                if($password === $user->password())
                {
                    $this->request->getSession()->setAttribut('userId', $user->id());
                    $this->request->getSession()->setAttribut('login', $user->login());
                    $controller = new UserController;
                    $controller->UserHome();
                }
                else
                {
                    //A voir
                }
            }
            else
            {
                //A voir
            }    
        }
            
        else
        {
            //A voir
        }
    }

    function createAccount()
    {
        echo $this->twig->render("createAccount.twig");
    }

    function logout()
    {

    }
}