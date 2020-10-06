<?php

namespace Model;

use Framework\ObjectClass;


class User extends ObjectClass
{
    private $_id,
        $_login,
        $_email,
        $_password,
        $_admin;


    public function id()
    {
        return $this->_id;
    }

    public function login()
    {
        return $this->_login;
    }

    public function email()
    {
        return $this->_email;
    }

    public function password()
    {
        return $this->_password;
    }

    public function admin()
    {
        return $this->_admin;
    }

    public function setId($id)
    {
        $id = (int) $id;
        if ($id > 0) {
            $this->_id = $id;
        }
    }

    public function setLogin($login)
    {
        if (is_string($login)) {
            $this->_login = $login;
        }
    }

    public function setEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->_email = $email;
        }
    }

    public function setPassword($password)
    {
        if (is_string($password)) {
            $this->_password = $password;
        }
    }

    public function setAdmin($admin)
    {
        if (is_int($admin))
        {
        $this->_admin = $admin;    
        }
        
    }
}
