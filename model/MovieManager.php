<?php
namespace Model;

use Framework\Manager;

class FilmManager extends Manager
{
    public function newMovie()
    {

    }

    public function lastMovie()
    {
        $req = $this->_db->prepare('SELECT * FROM movies ORDER BY date DESC LIMIT 0,10');
        $req->execute();
        while($row = $req->fetch())
        {
            $movie = new Movie($row);
            $movies[] = $movie;
        }
        return $movies;
    }


}