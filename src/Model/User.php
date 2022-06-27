<?php

namespace App\Model;

class User
{
    private $name;
    private $email;
    private $status;
    private $password;

    /************************/
    /** GETTERS AND SETTERS */
    /************************/

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

     /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }
}