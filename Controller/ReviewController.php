<?php

namespace Controller;

use Framework\Controller;
use Model\ReviewManager;
use Model\Review;

class ReviewController extends Controller
{

/**
 * Obtient les reviews d'un film selon son id
 */
    function getReviews($id)
    {
        $manager = new ReviewManager;
        $reviews = $manager->getReviewsByFilm($id);
        return $reviews;
    }

/**
 * Renvoie liste des id des derniers films commenté
 */
    function lastReviewsId($page = 1)
    {
        $manager = new ReviewManager;
        $reviews = $manager->getLastReviews();
        foreach ($reviews as $review) {
            $id = $review->idMovie();
            $reviewsId[] = $id;
            $reviewsId = array_unique($reviewsId);
            $nbrPages = ceil(count($reviewsId) / 20);
            if (count($reviewsId) >= 20 * $page) {
                break;
            }
        }
        if ($page == 1) {
            $response['nbrPages'] = $nbrPages;
            $response['reviewsId'] = $reviewsId;
            return $response;
        } else {
            $to = ($page - 1) * 20;
            $from = $page * 20 - 1;
            $response['nbrPages'] = $nbrPages;
            $response['reviewsId'] = array_slice($reviewsId, $to, $from);
            return $response;
        }
    }

/**
 * Demande création de la review auprès du manager
 */
    function createReview()
    {
        if ($this->checkSession()) {
            $userId = $this->request->getSession()->getAttribut('userId');
            $userLogin = $this->request->getSession()->getAttribut('login');
            $content = $this->request->parameter('content');
            $date = date("Y-m-d H:i");
            $idMovie = $this->request->Parameter('id');
            $rating = $this->request->Parameter('rating');
            $data = ['userId' => $userId, 'userLogin' => $userLogin, 'content' => $content, 'date' => $date, 'idMovie' => $idMovie, 'rating' => $rating];
            $review = new Review($data);
            $manager = new ReviewManager;
            $manager->createReview($review);
            $this->redirect('movie', 'movieDetails', $idMovie);
        }
    }

    /**
     * Renvoie les reviews d'un utilisateur précis selon son id
     */
    function MyReviews($userId)
    {
        $manager = new ReviewManager;
        $reviews = $manager->getReviewByUser($userId);
        return $reviews;
    }

    /**
     * Signalement d'une reviews et création de la vue de confirmation
     */
    function reportReview()
    {
        $id = $this->request->Parameter('id');
        $reviewManager = new ReviewManager;
        $review = $reviewManager->getReviewById($id);
        $review->setReported(1);
        $reviewManager->reportReview($review);
        $this->View('report.twig', ['idMovie' => $review->idMovie()]);
    }

    /**
     * Renvoie la liste des reviews signalées
     */
    function getReportedReviews()
    {
        if ($this->CheckAdmin()) {
            $manager = new ReviewManager;
            $reviews = $manager->getReportedReviews();
            $this->View('reportedReviews.twig', ['reviews' => $reviews]);
        }
    }

    /**
     * Permet de supprimer toutes les reviews
     */
    function deleteReview()
    {
        if($this->CheckAdmin())
        {
            $id = $this->request->Parameter('id');
            $manager = new ReviewManager;
            $manager->deleteReview($id);
            $this->redirect('Review', 'getReportedReviews');    
        }
    }

    /**
     * Permet à un administrateur de valider un commentaire signalé
     */
    function validReview()
    {
        if($this->CheckAdmin())
        {
        $id = $this->request->Parameter('id');
        $manager = new ReviewManager;
        $review = $manager->getReviewById($id);
        $review->setReported(0);
        $manager->updateReview($review);
        $this->redirect('Review', 'getReportedReviews');            
        }

    }

    /**
     * Modification d'un commentaire par l'utilisateur qui l'a créé
     */
    function modifyReview()
    {if($this->checkSession())
        {
        $id = $this->request->Parameter('id');
        $manager = new ReviewManager;
        $review = $manager->getReviewById($id);
        if($review->userId() == $this->request->getSession()->getAttribut('userId'))
        {
        $i = $review->rating();
        $rating[$i] = 'checked';
        $this->View('modifyReview.twig', ['review' => $review, 'rating' => $rating]);             
        }
        }

    }

    /**
     * Envoie la modification à la BDD via le manager
     */
    function sendModifyReview()
    {
        $id = $this->request->Parameter('id');
        $content = $this->request->Parameter('content');
        $rating = $this->request->Parameter('rating');
        /*$manager = new ReviewManager;
        $review = $manager->getReviewById($id);

        if ($review->userId() == $this->request->getSession()->getAttribut('userId')) {
            $review->setContent($content);
            $review->setRating($rating);
            $manager->updateReview($review);
            $this->redirect('user', 'myReviews');
        }*/
    }
}
