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
        $orderBy = ['label' => 'Le plus récent', 'parameter' => 'release_date.desc'];
        echo $this->twig->render('home.twig', ['page' => $page, 'orderBy' => $orderBy]);
    }

    function orderByReviews()
    {
        if($this->request->existParameter('id'))//est ce que je peux laisser ca avec 'id' ?
        {
        $page = $this->request->Parameter('id');   
        }
        else
        {
            $page = 1;
        }
        $controller = new ReviewController;
        $reviews = $controller->lastReviewsId(); 
    }

    function orderByPopularity()
    {
        if($this->request->existParameter('id'))//est ce que je peux laisser ca avec 'id' ?
        {
        $page = $this->request->Parameter('id');   
        }
        else
        {
            $page = 1;
        }
        $orderBy = ['label' => 'Le plus populaire', 'parameter' => 'popularity.desc'];
        echo $this->twig->render('home.twig', ['page' => $page, 'orderBy' => $orderBy]);
    }

    function Search()
    {
        $keyword = $this->request->Parameter('keyword');
        if($this->request->existParameter('id'))
        {
        $page = $this->request->Parameter('id');   
        }
        else
        {
            $page = 1;
        }
        var_dump($this->request);
        echo $this->twig->render('searchResults.twig', ['keyword' => $keyword, 'page' => $page]);
    }

    function movieDetails()
    {
        /*$id = $this->request->Parameter('id');
        $controller = new ReviewController;
        $movie = $controller->reviewsById($id);
        if(is_bool($movie) !== true)
        {*/
            $id = $this->request->Parameter('id');
            $reviewController = new ReviewController;
            $reviews = $reviewController->getReviews($id);
            if($reviews !== null)
            {
                echo $this->twig->render('details.twig', ['reviews' => $reviews, "idMovie"=>$id]);    
            }
            else
            {
                echo $this->twig->render('details.twig', ["idMovie"=>$id]);
            }
            
        /*}
        else
        {
            echo $this->twig->render('details.twig', ["idMovie"=>$id]);//creer vue pour films sans commentaires
        }*/
    }


}