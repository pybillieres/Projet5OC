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
            var_dump($this->request->Parameter('rating'));
            $pseudo = $this->request->getSession()->getAttribut('login');
            $content = $this->request->parameter('content');
            $date = date("Y-m-d H:i");
            $idMovie = $this->request->Parameter('idMovie');
            $rating = $this->request->Parameter('rating');
            $data = ['pseudo' => $pseudo, 'content' => $content, 'date' => $date, 'idMovie' => $idMovie, 'rating' => $rating];
            $review = new Review($data);
            $manager = new ReviewManager;
            $manager->createReview($review);
            $this->redirect('movie', 'movieDetails', $idMovie);
        }
    }

    function MyReviews()
    {

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
}