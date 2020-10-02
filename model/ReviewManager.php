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
        while ($row = $req->fetch()) {
            $review = new Review($row);
            $reviews[] = $review;
        }
        if (isset($reviews)) {
            return $reviews;
        }
    }

    function getReviewById($id)
    {
        $req = $this->_db->prepare('SELECT * FROM reviews WHERE id=?');
        $req->execute(array($id));
        $row = $req->fetch();
        $review = new Review($row);
        return $review;
    }

    function getReviewByUser($userId)
    {
        $req = $this->_db->prepare('SELECT * FROM reviews WHERE userId=? ORDER BY date DESC');
        $req->execute(array($userId));
        while ($row = $req->fetch()) {
            $review = new Review($row);
            $reviews[] = $review;
        }
        if (isset($reviews)) {
            return $reviews;
        }
    }

    function getLastReviews()
    {
        $req = $this->_db->prepare('SELECT * FROM reviews ORDER BY date DESC LIMIT 0,20');
        $req->execute();
        while ($row = $req->fetch()) {
            $review = new Review($row);
            $reviews[] = $review;
        }
        return $reviews;
    }

    /*function existReview($id)// verifier qui appelle cette fonction
    {
        $req = $this->_db->prepare('SELECT COUNT(*) FROM reviews WHERE idMovie=?');
        $req->execute(array($id));
        $nbr = $req->fetchColumn();
    }*/

    function createReview(Review $review)
    {
        $req = $this->_db->prepare('INSERT INTO reviews(idMovie, userId, userLogin, content, date, rating) VALUES(:idMovie, :userId, :userLogin, :content, :date, :rating) ');
        $req->execute(array(
            ':idMovie' => $review->idMovie(),
            ':userId' => $review->userId(),
            ':userLogin' => $review->userLogin(),
            ':content' => $review->content(),
            ':date' => $review->date(),
            ':rating' => $review->rating()
        ));
    }

    function reportReview(Review $review)
    {
        $req = $this->_db->prepare('UPDATE reviews SET reported=:reported WHERE id=:id');
        $req->execute(array(
            ':id' => $review->id(),
            ':reported' => $review->reported()
        ));
    }

    function getReportedReviews()
    {
        $req = $this->_db->prepare('SELECT * FROM reviews WHERE reported=1');
        $req->execute();
        while ($row = $req->fetch()) {
            $review = new Review($row);
            $reviews[] = $review;
        }
        if (isset($reviews)) {
            return $reviews;
        }
    }

    function deleteReview($id)
    {
        $req = $this->_db->prepare('DELETE FROM reviews WHERE id=? ');
        $req->execute(array($id));
    }

    function updateReview(Review $review)
    {
        $req = $this->_db->prepare('UPDATE reviews SET content=:content, rating=:rating WHERE id=:id');
        $req->execute(array(
            ':id' => $review->id(),
            ':content' => $review->content(),
            ':rating' => $review->rating()
        ));
    }
}
