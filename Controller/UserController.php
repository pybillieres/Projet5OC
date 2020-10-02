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

    public function UserHome()
    {
        if ($this->CheckAdmin()) {
            $reviews = $this->getMyReviews();
            if ($reviews != null) {
                $reviews = array_slice($reviews, 0, 5);
            }
            $this->View('dashBoard/UserHome.twig', ['reviews' => $reviews, 'admin' => true]);
        } else {
            $reviews = $this->getMyReviews();
            if ($reviews != null) {
                $reviews = array_slice($reviews, 0, 5);
            }

            $this->View('dashBoard/UserHome.twig', ['reviews' => $reviews]);
        }
    }

    function getMyReviews()
    {
        $controller = new ReviewController;
        $reviews = $controller->myReviews($this->request->getSession()->getAttribut('userId'));
        return $reviews;
    }

    function myReviews()
    {
        $reviews = $this->getMyReviews();
        $this->View('dashBoard/myReviews.twig', ['reviews' => $reviews]);
    }

    public function myAccount()
    {
        $login = $this->request->getSession()->getAttribut('login');
        $nbrReviews = count($this->getMyReviews());
        $this->View('dashBoard/myAccount.twig', ['pseudo' => $login, 'nbrReviews' => $nbrReviews]);
    }

    function changePassword()
    {
        $this->View('dashBoard/changePassword.twig');
    }

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

    function listUsers()
    {
        $manager = new UserManager;
        $users = $manager->getAllUsers();
        $this->View('dashboard/listUsers.twig', ['users' => $users]);
    }
}
