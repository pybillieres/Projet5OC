<?php

namespace Framework;

class Session
{

    public function __construct()
    {
        session_start();
    }

    function destroySession()
    {   
        session_destroy();
    }

    function setAttribut($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    function existAttribut($name)
    {        
        return (isset($_SESSION[$name]) && $_SESSION[$name] != "");
    }


    function getAttribut($name)
    {
        if ($this->existAttribut($name)) {
            return $_SESSION[$name];
        }
        else {
            throw new \Exception("attribut $name introuvable");
        }
    }
}