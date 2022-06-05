<?php

namespace App\Model;

use DateTime;

class CommentManager extends BaseManager
{
    public function getCommentsOfPostID($postId)
    {
        $req = $this->getCnx()->prepare(
                'SELECT c.id, c.content, c.creation_date createdAt, c.fk_comment_status status,
                        u.name author
                FROM comment c, user u
                WHERE c.fk_user_name = u.name AND c.fk_post_id = ?
                ORDER BY createdAt DESC');

        $req->setFetchMode(\PDO::FETCH_CLASS, Comment::class);
        $req->execute(array($postId));

        $result = $req->fetchAll();
        return $result;
    }

    public function addOnPostID(int $postId, string $comment, string $username, bool $isAdmin)
    {
        $status = $isAdmin ? 'approved' : 'waiting_approval';
        $req = $this->getCnx()->prepare(
                'INSERT INTO comment (fk_post_id, fk_user_name, fk_comment_status, content, creation_date)
                VALUES (?, ?, ?, ?, now() )');

        return $req->execute(array($postId, $username, $status, $comment));
    }

    public function deleteById(int $commentId)
    {
        $req = $this->getCnx()->prepare(
                'DELETE FROM comment WHERE id = ?');

        $rslt = $req->execute(array($commentId));
        return $rslt ? $req->rowCount() > 0 : false;
    }

    public function approveById(int $commentId)
    {
        $req = $this->getCnx()->prepare(
            'UPDATE comment SET fk_comment_status = "approved" WHERE id = ?');
        $rslt = $req->execute(array($commentId));
        return $rslt ? $req->rowCount() > 0 : false;
    }
}