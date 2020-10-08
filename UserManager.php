<?php

namespace Model;

use Framework\Manager;
use Model\User;

class UserManager extends Manager
{

    /**
     * Récupère les données d'un utilisateur via son id
     */
    public function getUserById($id)
    {
        $req = $this->_db->prepare('SELECT * FROM users WHERE id=?');
        $req->execute(array($id));
        $row = $req->fetch();
        $user = new User($row);
        return $user;
    }

    /**
     * Récupère les données d'un utilisateur via son login
     */
    public function getUserByLogin($login)
    {
        $req = $this->_db->prepare('SELECT * FROM users WHERE login=?');
        $req->execute(array($login));
        $row = $req->fetch();
        if (is_bool($row) !== true) {
            $user = new User($row);
            return $user;
        }
        else
        {
            return 0;
        }
    }

    /**
     * Récupère les données d'un utilisateur via son email
     */
    public function getUserByEmail($email)
    {
        $req = $this->_db->prepare('SELECT * FROM users WHERE email=?');
        $req->execute(array($email));
        $row = $req->fetch();
        if (is_bool($row) !== true) {
            $user = new User($row);
            return $user;
        }
        else
        {
            return 0;
        }
    }

    /**
     * Modifie un mot de passe dans la BDD
     */
    public function modifyPassword(User $user)
    {
        $req = $this->_db->prepare('UPDATE users SET password=:password WHERE id=:id');
        $req->execute(array(
            ':password' => $user->password(),
            ':id' => $user->id()
        ));
    }

    /**
     * Retourne la liste complète des utilisateurs inscrits
     */
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

    /**
     * crée un nouvel utilisateur dans la BDD
     */
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
