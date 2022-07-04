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

    private array $comments = []; // Used in admin panel page

    function __set($name, $value)
    {
        $str = 'IN __SET OF POST.PHP -> '.$name.' : '.$value.'</br>';
        \App\Utils\Server::Log($str);
        error_log(print_r('- - - -' . $str, TRUE)); 
    }

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
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return htmlspecialchars_decode($this->title);
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
        return htmlspecialchars_decode($this->head);
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
        return htmlspecialchars_decode($this->content);
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

    /**
     * Get the value of comments
     */ 
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set the value of the comments array
     * 
     * @return  self
     */ 
    public function setComments(array $com)
    {
        $this->comments = $com;

        return $this;
    }
}