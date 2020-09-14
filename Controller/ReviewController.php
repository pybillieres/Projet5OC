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

    function lastReviewsId()
    {
        $manager = new ReviewManager;
        $reviews = $manager->getLastReviews();
        foreach($reviews as $review)
        {
            $id=$review->idMovie();
            $reviewsId[] = $id;
        }
        return $reviewsId;
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
            echo $this->twig->render('connection.twig');
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
}