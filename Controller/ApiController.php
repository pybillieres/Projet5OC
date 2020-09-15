<?php
namespace Controller;

use Framework\Controller;

class ApiController extends Controller
{


    function index()
    {

    }

    function lastReviewsApi()
    {
        
        if($this->request->existParameter('id'))
        {
        $page = $this->request->Parameter('id');   
        }
        else
        {
            $page = 1;
        }
        $controller = new ReviewController;
        $reviews = $controller->lastReviewsId($page); 
        foreach ($reviews as $review)
        {
            $data['id'] = $review;
            $datas[] = $data;
        } 
        $this->reponse_json($reviews);
        
    }

    function lastMovies()
    {
        $controller = new MovieController;
        $movies = $controller->lastReviewsApi($page);
        foreach ($movies as $movie)
        {
            $data['id'] = $movie->id();
            $data['idDb'] = $movie->idDb();
            $data['title'] = $movie->title();
            $datas[] = $data;
        }    
        $this->reponse_json($datas);
    }

    function MovieByName($name)
    {

    }


    function reponse_json($data) { //penser a ajouter variable sucess true or false

        $array['result'] = $data;
        header('Content-Type: application/json');
        echo json_encode($array);
    }
}