<?php

namespace Model;

use Framework\Manager;
use Model\User;

class UserManager extends Manager
{

    public function getUserById($id)
    {
        $req = $this->_db->prepare('SELECT * FROM users WHERE id=?');
        $req->execute(array($id));
        $row = $req->fetch();
        $user = new User($row);
        return $user;
    }


    public function getUserByLogin($login)
    {
        $req = $this->_db->prepare('SELECT * FROM users WHERE login=?');
        $req->execute(array($login));
        $row = $req->fetch();
        if (is_bool($row) !== true) {
            $user = new User($row);
            return $user;
        }
    }

    public function modifyPassword(User $user)
    {
        $req = $this->_db->prepare('UPDATE users SET password=:password WHERE id=:id');
        $req->execute(array(
            ':password' => $user->password(),
            ':id' => $user->id()
        ));
    }

    public function getAllUsers()
    {
        $req = $this->_db->prepare('SELECT * FROM users ORDER BY login');
        $req->execute();
        while ($row = $req->fetch()) {
            $user = new User($row);
            $users[] = $user;
        }
        return $users;
    }

    function createUser(User $user)
    {
        var_dump($user->login());
        $req = $this->_db->prepare('INSERT INTO users(id, login, email, password, admin) VALUES(:id, :login, :email, :password, :admin) ');
        $req->execute(array(
            ':id'=>0,
            ':login'=>$user->login(),
            ':email'=>$user->email(),
            ':password'=>$user->password(),
            ':admin'=>0
        ));
    
    }
}
