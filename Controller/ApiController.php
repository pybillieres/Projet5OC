<?php
namespace Controller;

use Framework\Controller;

class ApiController extends Controller
{


    function index()
    {

    }

    function lastMovies()
    {
        $controller = new MovieController;
        $movies = $controller->lastMoviesApi();
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