<?php

namespace App\Model;

class UserManager extends BaseManager
{
    public function getUserByCredentials(string $email, string $password) : ?User
    {
        $pwdHash = $this->getHash($password);

        $req = $this->getCnx()->prepare(
                'SELECT u.name, u.email, u.fk_user_status as status
                FROM user u
                WHERE u.email = ? AND u.password = ?');

        $req->setFetchMode(\PDO::FETCH_CLASS, User::class);
        
        if(!$req->execute(array($email, $pwdHash))) {
            return null;
        }

        $rslt = $req->fetch();
        return !$rslt ? null : $rslt;
    }

    public function getUserEmail(string $name) : string
    {
        $req = $this->getCnx()->prepare('SELECT u.email FROM user u WHERE u.name = ?');
        $req->execute(array($name));
        return $req->fetch()[0];
    }

    public function registerUser(string $token)
    {
        $userStatus = 'visitor';

        $req = $this->getCnx()->prepare('UPDATE user SET fk_user_status = ? WHERE token = ?');
        $rslt = $req->execute(array($userStatus, $token));
        
        return $rslt;
    }

    public function checkUserExists(string $username)
    {
        $req = $this->getCnx()->prepare('SELECT * FROM user u WHERE u.name = ?');
        $req->execute(array($username));
        return $req->fetch() ? true : false;
    }

    public function checkEmailExists($email)
    {
        $req = $this->getCnx()->prepare('SELECT * FROM user u WHERE u.email = ?');
        $req->execute(array($email));
        return $req->fetch() ? true : false;
    }

    public function isUserAdmin($username)
    {
        $req = $this->getCnx()->prepare('SELECT u.fk_user_status FROM user u WHERE u.name = ?');
        $req->execute(array($username));
        return $req->fetch() === 'admin';
    }

    /*************************************************************************/
    /*** USER TOKEN & REGISTRATION ***/
    /*************************************************************************/

    public function preRegisterUser($name, $email, $password) : string
    {
        // Generate a token of random 64 hexadecimal characters string
        $token = bin2hex(random_bytes(32)); 
        
        $pwdHash = $this->getHash($password);
        $expireDate = new \DateTime();
        $expireDate->add(new \DateInterval("PT48H"));
        $userStatus = "signing_up";

        $req = $this->getCnx()->prepare(
            'INSERT INTO user (token, expire_date, name, email, password, fk_user_status)
            VALUES (?, ?, ?, ?, ?, ?)');
        
        $req->execute(array($token, $expireDate->format('Y-m-d H:i:s'), $name, $email, $pwdHash, $userStatus));

        return $token;
    }

    public function isTokenValid($token) : bool 
    {
        // Check if token exists for a "signing_up" user
        $userStatus = "signing_up";
        $req = $this->getCnx()->prepare('SELECT u.expire_date FROM user u WHERE u.token = ? AND u.fk_user_status = ?');
        $req->execute(array($token, $userStatus));

        $expireDate = $req->fetch();
        $req->closeCursor();
        if(!$expireDate) {
            return false;
        }

        // If token is expired for that "signing_up" user, delete the entry to allow for a new signup
        $tokExpired = strtotime($expireDate[0]) < time();
        if($tokExpired) {
            $req = $this->getCnx()->prepare('DELETE FROM user WHERE token = ?');
            $req->execute(array($token));
            return false;
        }

        // Token exists and is not expired, return true
        return true;
    }
}
