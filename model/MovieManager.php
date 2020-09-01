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

    public function movieDetails($id)
    {
        $req = $this->_db->prepare('SELECT * FROM movies WHERE idDb=?');
        $req->execute(array($id));
        $row = $req->fetch();
        if(is_bool($row) !== true)
        {
            $movie = new Movie($row); //essayer de changer ca et de fetch sans boucle;
            return $movie;
        }
        else
        {
            return false;
        }
    }
    
}