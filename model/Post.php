<?php

class Post
{
    private $id;
    private $title;
    private $head;
    private $content;
    private $createdAt;
    private $modifiedAt;
    private $author;

    // GETTERS
    public function getId()         { return $this->id; }
    public function getTitle()      { return $this->title; }
    public function getHead()       { return $this->head; }
    public function getContent()    { return $this->content; }
    public function getCreatedAt()  { return $this->createdAt; }
    public function getModifiedAt() { return $this->modifiedAt; }
    public function getAuthor()     { return $this->author; }
    
    public function __set($name, $value)
    {
        // $this->$name = $value;
        // echo '<p>From DB : ' . $name . ' --> ' . $value . '</p>';
    }
}