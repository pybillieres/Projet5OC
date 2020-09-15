<?php
namespace Model;

use Framework\ObjectClass;

class Review extends ObjectClass
{
    private $_id,
            $_idMovie,
            $_pseudo,
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

    public function pseudo()
    {
        return $this->_pseudo;
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

    public function setPseudo($pseudo)
    {
        $this->_pseudo = $pseudo;
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