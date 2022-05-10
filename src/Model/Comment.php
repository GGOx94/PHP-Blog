<?php

namespace App\Model;

class Comment
{
    private $id;
    private $content;
    private $createdAt;
    private $author;

    /************************/
    /** GETTERS AND SETTERS */
    /************************/

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get the value of author
     */ 
    public function getAuthor()
    {
        return $this->author;
    }
}
