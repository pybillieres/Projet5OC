<?php
namespace Controller;

use Framework\Controller;
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
        $this->View('home.twig', ['page' => $page, 'orderBy' => $orderBy]);
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
        $this->View('home.twig', ['page' => $page, 'orderBy' => $orderBy]);
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
        $this->View('home.twig', ['keyword' => $keyword, 'page' => $page]);
    }

    function movieDetails()
    {
            $id = $this->request->Parameter('id');
            $reviewController = new ReviewController;
            $reviews = $reviewController->getReviews($id);
            if($reviews !== null)
            {
                echo $this->twig->render('details.twig', ['reviews' => $reviews, "idMovie"=>$id]);    
            }
            else
            {
                $this->View('details.twig', ["idMovie"=>$id]);
            }
    }


}