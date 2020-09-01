<?php
namespace Model;

use Framework\Manager;
use Model\Review;

class ReviewManager extends Manager
{

    function getReviewsByFilm($id)
    {
        $req = $this->_db->prepare('SELECT * FROM reviews WHERE idMovie=? ORDER BY date DESC');
        $req->execute(array($id));
        while($row = $req->fetch())
        {
            $review = new Review($row);
            $reviews[] = $review;
        }        
        return $reviews;
    }

}