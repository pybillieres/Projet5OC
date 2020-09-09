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
        if(isset($reviews))
        {
        return $reviews;
        }      
        
    }

    function getLastReviews()
    {
        $req = $this->_db->prepare('SELECT * FROM reviews ORDER BY date DESC LIMIT 0,20');
        $req->execute();
        while($row = $req->fetch())
        {
            $review = new Review($row);
            $reviews[] = $review;
        }        
        return $reviews;

    }

    function existReview($id)
    {
        $req = $this->_db->prepare('SELECT COUNT(*) FROM reviews WHERE idMovie=?');
        $req->execute(array($id));
        $nbr = $req->fetchColumn();
    }

    function createReview(Review $review)
    {
            $req = $this->_db->prepare('INSERT INTO reviews(idMovie, pseudo, content, date, rating) VALUES(:idMovie, :pseudo, :content, :date, :rating) ');
            $req->execute(array (
                ':idMovie'=>$review->idMovie(), 
                ':pseudo'=>$review->pseudo(), 
                ':content'=>$review->content(), 
                ':date'=>$review->date(),
                ':rating'=>$review->rating()));

    }

}