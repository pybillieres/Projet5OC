<?php
namespace Controller;

use Framework\Controller;
use Model\MovieManager;

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
        echo $this->twig->render('home.twig', ['movies' => $movies]);
    }

    //FONCTION DE L'API

    function lastMoviesApi()
    {
        $manager = new MovieManager;
        $movies = $manager->lastMovies();
        return $movies;
    }


}