<?php

namespace App\Model;

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

    public function getPostByID($postID)
    {
        $req = $this->cnx->prepare(
                'SELECT p.id, p.title, p.head, p.content, p.creation_date createdAt, p.modification_date modifiedAt,
                        u.name author
                FROM post p, user u
                WHERE p.fk_user_name = u.name AND p.id = ?');

        $req->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        $req->execute(array($postID));
        return $req->fetch();
    }

    public function getCommentsOfPostID($postID)
    {
        //TODO scd arg to allow 'waiting_approval' comments to show ? for admins sessions
        $req = $this->cnx->prepare(
                'SELECT c.id, c.content, c.creation_date createdAt,
                        u.name author
                FROM comment c, user u
                WHERE c.fk_user_name = u.name AND c.fk_comment_status = "approved" AND c.fk_post_id = ?');

        $req->setFetchMode(\PDO::FETCH_CLASS, Comment::class);
        $req->execute(array($postID));

        $result = $req->fetchAll();
        return $result;
    }
}