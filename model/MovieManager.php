<?php
namespace Model;

use Framework\Manager;

class MovieManager extends Manager
{
    public function newMovie()
    {

    }

    public function lastMovies()//10 DERNIER FILMS
    {
        $req = $this->_db->prepare('SELECT * FROM movies ORDER BY title DESC LIMIT 0,10');
        $req->execute();
        while($row = $req->fetch())
        {
            $movie = new Movie($row);
            $movies[] = $movie;
        }
        return $movies;
    }

    
}