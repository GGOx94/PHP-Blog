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

    public function createPost(Post $post, string $userName) : ?int
    {
        $req = $this->getCnx()->prepare(
                'INSERT INTO post (title, head, content, creation_date, fk_user_name)
                VALUES (?, ?, ?, now(), ?);');

        $rslt = $req->execute(array($post->getTitle(), $post->getHead(), $post->getContent(), $userName));

        return $rslt ? $this->getCnx()->lastInsertId() : null;
    }

    public function updatePost(Post $post)
    {
        $req = $this->getCnx()->prepare(
                'UPDATE post
                SET title = ?, head = ?, content = ?, modification_date = now() 
                WHERE id = ?');

        $rslt = $req->execute(array($post->getTitle(), $post->getHead(), $post->getContent(), $post->getId()));

        return $rslt;
    }

    public function deletePost($postId)
    {
        $req = $this->getCnx()->prepare('DELETE FROM post WHERE id = ?');
        
        $rslt = $req->execute(array($postId));

        return $rslt;
    }
}