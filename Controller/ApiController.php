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
        $movies = $controller->lastMovies(1);
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

    /*function utf8ize($d) {
        if (is_array($d)) {
            foreach ($d as $k => $v) {
                $d[$k] = $this->utf8ize($v);
            }
        } else if (is_string ($d)) {
            return utf8_encode($d);
        }
        return $d;
    }*/


    function reponse_json($data) { //penser a ajouter variable sucess true or false

        //var_dump($array);
        $array['result'] = $data;
        //$arr = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
        //header('Content-Type: application/json');
        echo json_encode($array);
        //echo json_encode($arr);
    }
}