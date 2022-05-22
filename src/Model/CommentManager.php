<?php

namespace App\Model;

class CommentManager extends BaseManager
{
    public function getCommentsOfPostID($postID)
    {
        //TODO scd arg to allow 'waiting_approval' comments to show ? for admins sessions
        $req = $this->getCnx()->prepare(
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