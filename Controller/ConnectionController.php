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
        $this->View('connection.twig');
    }

    function login()
    {

        if ($this->request->existParameter("login") && $this->request->existParameter("password")) {
            $login = $this->request->parameter('login');
            $password = md5($this->request->parameter('password'));
            $userManager = new UserManager;
            $user = $userManager->getUserByLogin($login);
            if ($user !== null) {
                if ($password === $user->password()) {
                    $this->request->getSession()->setAttribut('userId', $user->id());
                    $this->request->getSession()->setAttribut('login', $user->login());
                    $this->request->getSession()->setAttribut('admin', $user->admin());
                    $this->redirect('User', 'UserHome');
                } else {
                    $this->msgView('Mot de passe ou login incorrect');
                }
            } else {
                $this->msgView('Mot de passe ou login incorrect');
            }
        } else {
            $this->msgView('Mot de passe incorrect');
        }
    }

    function createAccountView()
    {
        $this->View("createAccount.twig");
    }

    function createAccount()
    {
        $login = $this->request->Parameter('login');
        $password = $this->request->Parameter('password');
        $email = $this->request->Parameter('email');
        $this->sendConfirmationMail($email);
    }

    function sendConfirmationMail($to)
    {
        
;        $from = "test@p-billieres.com";
        $subject = "Vérification PHP Mail";
        $message = "PHP mail marche";
        $headers = "From:" . $from;
        var_dump($from, $subject, $message, $headers);
        //mail($to, $subject, $message, $headers);
    }



    function logout()
    {
        $this->request->getSession()->destroySession();
        $this->redirect('connection', 'connectionView');
    }
}
