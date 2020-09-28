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

    function lastReviewsId($page = 1)
    {
        $manager = new ReviewManager;
        $reviews = $manager->getLastReviews();
        foreach($reviews as $review)
        {
            $id=$review->idMovie();
            $reviewsId[] = $id;
            $reviewsId = array_unique($reviewsId);
            if(count($reviewsId) >= 20*$page)
            {
            break;
            }
        }
        if($page == 1)
        {
            return $reviewsId;    
        }
        else
        {
            var_dump('toto');
            $to = $page-1*20;
            $from = $page*20-1;
            return array_slice($reviewsId, $to, $from);
        }
        
    }

    function newReview()
    {
        if($this->checkSession())
        {
            $id = $this->request->Parameter('id');
            echo $this->twig->render('newReview.twig', ['id' => $id]);            
        }
        else
        {
            $this->redirect('connection');
        }

    }

    function createReview()
    {
        if($this->checkSession())
        {
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
            $reviewManager->updateReview($review);
            $this->View('report.twig', ['idMovie'=>$review->idMovie()]);
            //$this->redirect('movie', 'movieDetails', $review->idMovie());

    }

    function getReportedReviews()
    {
        if($this->CheckAdmin())
        {
            $manager = new ReviewManager;
            $reviews = $manager->getReportedReviews();
            $this->View('dashboard/reportedReviews.twig', ['reviews' => $reviews]);
        }
    }

    function deleteReview()
    {
        $id = $this->request->Parameter('id');
        $manager = new ReviewManager;
        $review = $manager->getReviewById($id);
        $review->setReported(0);
        $manager->updateReview($review);
    }

    function validReview()
    {
        $id = $this->request->Parameter('id');
        $manager = new ReviewManager;
        $review = $manager->getReviewById($id);
        $review->setReported(0);
        $manager->updateReview($review);
    }
}