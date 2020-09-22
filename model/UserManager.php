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
        if(is_bool($row) !== true)
        {
        $user = new User($row);
        return $user;   
        }
    }

    public function modifyPassword(User $user)
    {
        $req = $this->_db->prepare('UPDATE users SET password=:password WHERE id=:id'); 
        $req->execute(array(':password'=>$user->password(),
                            ':id'=>$user->id()));
    }

}