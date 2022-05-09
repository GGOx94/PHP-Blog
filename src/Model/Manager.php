<?php

namespace App\Model;
use App\Model\Post;

class Manager
{
    private $cnx;
    
    public function __construct()
    {
        //TODO config file ?
        $this->cnx = new \PDO('mysql:host=localhost;dbname=p5phpblog;charset=utf8', 'ggo', '');
    }

    public function getAllPosts() : array
    {
        $req = $this->cnx->query(
                'SELECT p.id, p.title, p.head, p.content,
                        p.creation_date createdAt, p.modification_date modifiedAt, 
                        u.name author
                 FROM post p, user u
                 WHERE p.fk_user_name = u.name
                 ORDER BY creation_date DESC');

        $req->execute();

        $result = $req->fetchAll(\PDO::FETCH_CLASS, Post::class);
        return $result;
    }
}