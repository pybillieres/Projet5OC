<?php

namespace Controller;

use Framework\SecureController;
use Framework\Configuration;
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
        if (file_exists('upload/' . $this->request->getSession()->getAttribut('login') . 'profil.jpg')) {
            $this->View('myAccount.twig', ['pseudo' => $login, 'nbrReviews' => $nbrReviews, 'imgProfil' => true]);
        } else {
            $this->View('myAccount.twig', ['pseudo' => $login, 'nbrReviews' => $nbrReviews]);
        }
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

    function modifyImg()
    {
        $this->View('modifyImg.twig');
    }

    function uploadProfilImg()
    {
        if (isset($_FILES['file']) and $_FILES['file']['error'] == 0) {
            $info = pathinfo($_FILES['file']['name']);
            if ($_FILES['file']['size'] <= 1024000) {
                if ($info['extension'] == 'jpg') {
                    $name = $this->request->getSession()->getAttribut('login');
                    move_uploaded_file($_FILES['file']['tmp_name'], 'upload/' . basename($name . "profil.jpg"));
                    $this->redirect('user', 'myAccount');
                } else {
                    $this->msgView('Le fichier doit être au format .jpg');
                }
            } else {
                $this->msgView('Le fichier est trop volumineux');
            }
        }
        else
        {
            $this->msgView('erreur lors du chargement du fichier');
        }
    }
}
