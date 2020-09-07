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
        if($this->request->existParameter('id'))//est ce que je peux laisser ca avec 'id' ?
        {
        $page = $this->request->Parameter('id');   
        }
        else
        {
            $page = 1;
        }
        
        $manager = new MovieManager;
        $movies = $manager->lastMovies();
        echo $this->twig->render('home.twig', ['page' => $page]);
    }

    function Search()
    {
        $keyword = $this->request->Parameter('searchKeyword');
        if($this->request->existParameter('id'))
        {
        $page = $this->request->Parameter('id');   
        }
        else
        {
            $page = 1;
        }
        var_dump($keyword);
        echo $this->twig->render('searchResults.twig', ['keyword' => $keyword, 'page' => $page]);
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