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

    /**
     * Création de la vue de connection
     */
    function connectionView()
    {
        $this->View('connection.twig');
    }

    /**
     * Vérification du login et du mot de passe et redirection vers le userHome
     */
    function login()
    {

        if ($this->request->existParameter("login") && $this->request->existParameter("password")) {
            $login = $this->request->parameter('login');
            $password = md5($this->request->parameter('password'));
            $userManager = new UserManager;
            $user = $userManager->getUserByLogin($login);
            if ($user !== 0 && $user !== null) {
                if ($password === $user->password()) {
                    $this->request->getSession()->setAttribut('userId', $user->id());
                    $this->request->getSession()->setAttribut('login', $user->login());
                    $this->request->getSession()->setAttribut('admin', $user->admin());
                    $this->redirect('User', 'userHome');
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

    /**
     * Génération de la vue de création de compte
     */
    function createAccountView()
    {
        $this->View("createAccount.twig");
    }

    /**
     * Vérifie si login et mail ne sont pas utilisé et demande création de l'utilisateur au manager
     */
    function createAccount()
    {
        $login = $this->request->Parameter('login');
        $password = $this->request->Parameter('password');
        $email = $this->request->Parameter('email');
        $this->sendConfirmationMail($email);
        $data = ['login' => $login, 'password' => md5($password), 'email' => $email];
        $user = new User($data);
        $userManager = new UserManager;
        if ($userManager->getUserByLogin($login) == 0 && $userManager->getUserByEmail($email) == 0) {
            $userManager->createUser($user);
            $this->msgView('Votre demande a été prise en compte, vous pouvez maintenant vous connecter depuis le lien Connection');
        }
        elseif ($userManager->getUserByLogin($login) !== 0)
        {
            $this->msgView('Ce login est déja utilisé');
        }
        elseif ($userManager->getUserByEmail($email) !== 0)
        {
            $this->msgView('Cet email est déja utilisé');
        }
    }

    /**
     * Envoi de l'email de confirmation de création de compte
     */
    function sendConfirmationMail($to)
    {;
        $from = "cinéreview@p-billieres.com";
        $subject = "Compte CinéReview";
        $message = "Votre inscription a bien été prise en compte";
        $headers = "From:" . $from;
        mail($to, $subject, $message, $headers);
    }



    /**
     * déconnection
     */
    function logout()
    {
        $this->request->getSession()->destroySession();
        $this->redirect('connection', 'connectionView');
    }
}
