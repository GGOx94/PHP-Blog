<?php

namespace App\Model;

class PostManager extends BaseManager
{
    public function getAllPosts() : array
    {
        $req = $this->getCnx()->query(
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
        $req = $this->getCnx()->prepare(
                'SELECT p.id, p.title, p.head, p.content, p.creation_date createdAt, p.modification_date modifiedAt,
                        u.name author
                FROM post p, user u
                WHERE p.fk_user_name = u.name AND p.id = ?');

        $req->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        $req->execute(array($postID));
        return $req->fetch();
    }
}