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

    function getReviewById($id)
    {
        $req = $this->_db->prepare('SELECT * FROM reviews WHERE id=?');
        $req->execute(array($id));
        $row= $req->fetch();
        $review = new Review($row);
        var_dump($review);
        return $review;   
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

    function updateReview(Review $review)
    {

        var_dump($review);
        /*$req=$this->_db->prepare('UPDATE reviews SET idMovie=:idMovie, pseudo=:pseudo, content=:content, date=:date, rating=:rating reported=:reported WHERE id=:id');
        $req->execute(array(
                ':id'=>$review->id(),
                ':idMovie'=>$review->idMovie(), 
                ':pseudo'=>$review->pseudo(), 
                ':content'=>$review->content(), 
                ':date'=>$review->date(),
                ':rating'=>$review->rating(),
                ':reported'=>$review->reported()));
*/
            var_dump($review->id(), $review->reported());
            $req=$this->_db->prepare('UPDATE reviews SET reported=:reported WHERE id=:id');
            $req->execute(array(
                ':id'=>$review->id(),
                ':reported'=>$review->reported()
            ));
    }

}