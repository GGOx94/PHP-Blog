<?php

namespace App\Model;

class Post
{
    private $id;
    private $title;
    private $head;
    private $content;
    private $createdAt;
    private $modifiedAt;
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
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of head
     */ 
    public function getHead()
    {
        return $this->head;
    }

    /**
     * Set the value of head
     *
     * @return  self
     */ 
    public function setHead($head)
    {
        $this->head = $head;

        return $this;
    }

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get the value of modifiedAt
     */ 
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * Get the value of author
     */ 
    public function getAuthor()
    {
        return $this->author;
    }
}
