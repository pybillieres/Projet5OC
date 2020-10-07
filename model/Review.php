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
        $id = (int) $id;
        $this->_id = $id;
    }

    public function setIdMovie($idMovie)
    {
        $idMovie = (int) $idMovie;
        $this->_idMovie = $idMovie;
    }

    public function setUserId($userId)
    {
        $userId = (int) $userId;
        $this->_userId = $userId;
    }

    public function setUserLogin($userLogin)
    {
        $userLogin = (string) $userLogin;
        $this->_userLogin = $userLogin;
    }

    public function setDate($date)
    {
        $this->_date = $date;
    }

    public function setRating($rating)
    {
        $rating = (int) $rating;
        if ($rating > 0 && $rating <= 5) {
            $this->_rating = $rating;
        }
    }

    public function setContent($content)
    {
        if (is_string($content)) {
            $this->_content = $content;
        }
    }

    public function setReported($reported)
    {
        $reported = (int) $reported;
        $this->_reported = $reported;
    }
}
