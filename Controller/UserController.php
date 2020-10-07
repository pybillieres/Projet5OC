<?php

namespace Controller;

use Framework\SecureController;
use Model\Review;
use Model\UserManager;

class UserController extends SecureController
{
    public function index()
    {
        $this->UserHome();
    }

    /**
     * Crée la vue de la page d'accueil des utilisateurs selon qu'ils sont administrateur ou non 
     */
    public function UserHome()
    {
        if ($this->CheckAdmin()) {
            $reviews = $this->getMyReviews();
            if ($reviews != null) {
                $reviews = array_slice($reviews, 0, 5);
            }
            $this->View('userHome.twig', ['reviews' => $reviews, 'admin' => true]);
        } else {
            $reviews = $this->getMyReviews();
            if ($reviews != null) {
                $reviews = array_slice($reviews, 0, 5);
            }

            $this->View('userHome.twig', ['reviews' => $reviews]);
        }
    }

    /**
     * Recupere auprès du reviewController les reviews d'un utilisateur en fonction de son Id puis la renvoie
     */
    function getMyReviews()
    {
        $controller = new ReviewController;
        $reviews = $controller->myReviews($this->request->getSession()->getAttribut('userId'));
        return $reviews;
    }

    /**
     * crée la vue avec reviews de l'utilisateur
     */
    function myReviews()
    {
        $reviews = $this->getMyReviews();
        $this->View('myReviews.twig', ['reviews' => $reviews]);
    }

    /**
     * créé la vue qui affiche informations sur le compte de l'utilisateur
     */
    public function myAccount()
    {
        $login = $this->request->getSession()->getAttribut('login');
        $nbrReviews = count($this->getMyReviews());
        $this->View('myAccount.twig', ['pseudo' => $login, 'nbrReviews' => $nbrReviews]);
    }

    /**
     * créé la vue de changement de mot de passe
     */
    function changePassword()
    {
        $this->View('changePassword.twig');
    }

    /**
     * envoie le changement de mot de passe au manager pour mise a jour de la BDD
     */
    function confirmPassword()
    {
        if ($this->checkSession()) {

            $newPassword = $this->request->Parameter('password');
            $newPasswordConfirm = $this->request->Parameter('passwordConfirm');
            if ($newPassword == $newPasswordConfirm) {
                $userId = $this->request->getSession()->getAttribut('userId');
                $userManager = new UserManager;
                $user = $userManager->getUserById($userId);
                $user->setPassword(md5($newPassword));
                $userManager->modifyPassword($user);
                $this->redirect('user');
            } else {
            }
        }
    }

    /**
     * Recupere la liste des utilisateurs et l'affiche
     */
    function listUsers()
    {
        if ($this->CheckAdmin()) {
            $manager = new UserManager;
            $users = $manager->getAllUsers();
            $this->View('listUsers.twig', ['users' => $users]);
        }
    }
}
