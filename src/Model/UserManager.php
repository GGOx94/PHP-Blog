<?php

namespace App\Model;

class UserManager extends BaseManager
{
    public function loginUser($email, $password)
    {
        $pwdHash = $this->getHash($password);

        $req = $this->getCnx()->prepare(
                'SELECT u.name, u.email, u.fk_user_status as status
                FROM user u
                WHERE u.email = ? AND u.password = ?');

        $req->setFetchMode(\PDO::FETCH_CLASS, User::class);
        $rslt = $req->execute(array($email, $pwdHash));
        
        return !$rslt ? false : $req->fetch();
    }

    public function registerUser($name, $email, $password)
    {
        $pwdHash = $this->getHash($password);

        $req = $this->getCnx()->prepare(
                'INSERT INTO user (name, email, password, fk_user_status)
                VALUES (?, ?, ?, "visitor")');

        return $req->execute(array($name, $email, $pwdHash));
    }

    public function checkUserExists($username)
    {
        $req = $this->getCnx()->prepare( 'SELECT * FROM user u WHERE u.name = ?');
        $req->execute(array($username));
        return $req->fetch() ? true : false;
    }

    public function checkEmailExists($email)
    {
        $req = $this->getCnx()->prepare( 'SELECT * FROM user u WHERE u.email = ?');
        $req->execute(array($email));
        return $req->fetch() ? true : false;
    }
}