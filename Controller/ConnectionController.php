<?php

namespace Controller;

use Framework\Controller;
use Model\UserManager;
use Model\User;
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
        $data = ['login'=>$login, 'password'=>md5($password), 'email'=>$email];
        $user = new User($data);
        $userManager = new UserManager;
        $userManager->createUser($user);
    }

    function sendConfirmationMail($to)
    {
        
;       $from = "cinéreview@p-billieres.com";
        $subject = "Compte CinéReview";
        $message = "Votre inscription a bien été prise en compte";
        $headers = "From:" . $from;
        mail($to, $subject, $message, $headers);
    }



    function logout()
    {
        $this->request->getSession()->destroySession();
        $this->redirect('connection', 'connectionView');
    }
}
