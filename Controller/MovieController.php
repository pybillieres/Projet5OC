<?php
namespace Controller;

use Framework\Controller;
use Model\MovieManager;
use Controller\ReviewController;

class MovieController extends Controller
{

    function index()
    {
        $this->lastMovies();
    }

    function lastMovies()
    {
        $manager = new MovieManager;
        $movies = $manager->lastMovies();
        echo $this->twig->render('home.twig');
    }

    function movieDetails()
    {
        $id = $this->request->Parameter('id');
        $manager = new MovieManager;
        $movie = $manager->movieDetails($id);
        if(is_bool($movie) !== true)
        {
            $reviewController = new ReviewController;
            $reviews = $reviewController->getReviews($id);
            echo $this->twig->render('details.twig', ['reviews' => $reviews, 'movie'=>$movie]);
        }
        else
        {
            echo $this->twig->render('');//creer vue pour films sans commentaires
        }
    }


}