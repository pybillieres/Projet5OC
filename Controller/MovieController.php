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
        if($this->request->existParameter('id') && $this->request->Parameter('id')>0)
        {
        $page = $this->request->Parameter('id');   
        }
        else
        {
            $page = 1;
        }
        $orderBy = ['label' => 'Le plus récent', 'parameter' => 'release_date.desc', 'action' => 'lastMovies'];
        $this->View('home.twig', ['page' => $page, 'orderBy' => $orderBy]);
    }

    function orderByReviews()
    {
        if($this->request->existParameter('id') && $this->request->Parameter('id')>0)
        {
        $page = $this->request->Parameter('id');   
        }
        else
        {
            $page = 1;
        }
        $orderBy = ['label' => 'Avis le plus récent', 'parameter' => 'lastComment'];
        $this->View('home.twig', ['page' => $page, 'orderBy' => $orderBy]);

    }

    function orderByPopularity()
    {
        if($this->request->existParameter('id') && $this->request->Parameter('id')>0)
        {
        $page = $this->request->Parameter('id');   
        }
        else
        {
            $page = 1;
        }
        $orderBy = ['label' => 'Le plus populaire', 'parameter' => 'popularity.desc', 'action' => 'orderByPopularity'];
        $this->View('home.twig', ['page' => $page, 'orderBy' => $orderBy]);
    }

    function Search()
    {
        $keyword = $this->request->Parameter('keyword');
        var_dump($keyword);
        if($this->request->existParameter('id') && $this->request->Parameter('id')>0)
        {
        $page = $this->request->Parameter('id');   
        var_dump($page);
        }
        else
        {
            $page = 1;
            var_dump($page);
        }
        $this->View('searchResults.twig', ['keyword' => $keyword, 'page' => $page, 'action' => 'Search']);
    }

    function movieDetails()
    {
            $id = $this->request->Parameter('id');
            $reviewController = new ReviewController;
            $reviews = $reviewController->getReviews($id);
            if($reviews !== null)
            {
                $this->View('details.twig', ['reviews' => $reviews, "idMovie"=>$id]);  
            }
            else
            {
                $this->View('details.twig', ["idMovie"=>$id]);
            }
    }


}