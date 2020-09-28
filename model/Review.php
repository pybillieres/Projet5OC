<?php
namespace Model;

use Framework\ObjectClass;

class Review extends ObjectClass
{
    private $_id,
            $_idMovie,
            $_userId,
            $_date,
            $_rating,
            $_content,
            $_reported;

    public function id()
    {
        return $this->_id;
    }

    public function idMovie()
    {
        return $this->_idMovie;
    }

    public function userId()
    {
        return $this->_userId;
    }

    public function userLogin()
    {
        return $this->_userLogin;
    }

    public function date()
    {
        return $this->_date;
    }

    public function rating()
    {
        return $this->_rating;
    }

    public function content()
    {
        return $this->_content;
    }

    public function reported()
    {
        return $this->_reported;
    }

    public function setId($id)
    {
        $this->_id = $id;
    }

    public function setIdMovie($idMovie)
    {
        $this->_idMovie = $idMovie;
    }

    public function setUserId($userId)
    {
        $this->_userId = $userId;
    }

    public function setUserLogin($userLogin)
    {
        $this->_userLogin = $userLogin;
    }

    public function setDate($date)
    {
        $this->_date = $date;
    }

    public function setRating($rating)
    {
        $this->_rating = $rating;
    }

    public function setContent($content)
    {
        $this->_content = $content;
    }

    public function setReported($reported)
    {
        $this->_reported = $reported;
    }
}