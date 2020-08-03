<?php
namespace Model;

use Framework\ObjectClass;

class Movie extends ObjectClass
{
    private $_id,
            $_idDb,
            $_title;

    public function id()
    {
        return $this->_id;
    }

    public function idDb()
    {
        return $this->_idDb;
    } 

    public function title()
    {
        return $this->_title;
    }

    public function setId($id)
    {
        $this->_id = $id;
    }

    public function setIdDb($idDb)
    {
        $this->_idDb = $idDb;
    }

    public function setTitle($title)
    {
        $this->_title = $title;
    }
    
}