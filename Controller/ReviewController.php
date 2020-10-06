<?php

namespace Controller;

use Framework\Controller;
use Model\ReviewManager;
use Model\Review;

class ReviewController extends Controller
{


    function getReviews($id)
    {
        $manager = new ReviewManager;
        $reviews = $manager->getReviewsByFilm($id);
        return $reviews;
    }

    function lastReviewsId($page = 1) // revoir cette fonction ->doute
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

    function newReview()
    {
        if ($this->checkSession()) {
            $id = $this->request->Parameter('id');
            echo $this->twig->render('newReview.twig', ['id' => $id]);
        } else {
            $this->redirect('connection');
        }
    }

    function createReview()
    {
        if ($this->checkSession()) {
            $userId = $this->request->getSession()->getAttribut('userId');
            $userLogin = $this->request->getSession()->getAttribut('login');
            $content = $this->request->parameter('content');
            $date = date("Y-m-d H:i");
            $idMovie = $this->request->Parameter('idMovie');
            $rating = $this->request->Parameter('rating');
            $data = ['userId' => $userId, 'userLogin' => $userLogin, 'content' => $content, 'date' => $date, 'idMovie' => $idMovie, 'rating' => $rating];
            $review = new Review($data);
            $manager = new ReviewManager;
            $manager->createReview($review);
            $this->redirect('movie', 'movieDetails', $idMovie);
        }
    }

    function MyReviews($userId)
    {
        $manager = new ReviewManager;
        $reviews = $manager->getReviewByUser($userId);
        return $reviews;
    }

    function reportReview()
    {
        $id = $this->request->Parameter('id');
        $reviewManager = new ReviewManager;
        $review = $reviewManager->getReviewById($id);
        $review->setReported(1);
        $reviewManager->reportReview($review);
        $this->View('report.twig', ['idMovie' => $review->idMovie()]);
    }

    function getReportedReviews()
    {
        if ($this->CheckAdmin()) {
            $manager = new ReviewManager;
            $reviews = $manager->getReportedReviews();
            $this->View('reportedReviews.twig', ['reviews' => $reviews]);
        }
    }

    function deleteReviewAdmin() //proteger, permet de supprimer n'importe quel review (sert pour moderer les commentaires)
    {
    }

    function deleteReviewUser() //permet de supprimer seulement ses propres reviews
    {
    }

    function validReview() //ajouter checkadmin
    {
        $id = $this->request->Parameter('id');
        $manager = new ReviewManager;
        $review = $manager->getReviewById($id);
        $review->setReported(0);
        $manager->updateReview($review);
        $this->redirect('Review', 'getReportedReviews');
    }

    function modifyReview() //ajouter checkuser et que c'est le bon user qui modifie le commentaire
    {
        $id = $this->request->Parameter('id');
        $manager = new ReviewManager;
        $review = $manager->getReviewById($id);
        $i = $review->rating();
        $rating[$i] = 'checked';
        $this->View('modifyReview.twig', ['review' => $review, 'rating' => $rating]);
    }

    function sendModifyReview() //ajouter checkuser ET que c'est le bon user qui modifie le commentaire
    {
        $id = $this->request->Parameter('id');
        $content = $this->request->Parameter('content');
        $rating = $this->request->Parameter('rating');
        $manager = new ReviewManager;
        $review = $manager->getReviewById($id);

        if ($review->userId() == $this->request->getSession()->getAttribut('userId')) {
            $review->setContent($content);
            $review->setRating($rating);
            $manager->updateReview($review);
            $this->redirect('user', 'myReviews');
        }
    }
}
