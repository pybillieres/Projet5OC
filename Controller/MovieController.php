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

    function movieDetails()
    {
        $id = $this->request->Parameter('id');
        $manager = new MovieManager;
        $movie = $manager->movieDetails($id);
        echo $this->twig->render('details.twig', ['movie' => $movie]);
    }


}