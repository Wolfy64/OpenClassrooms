<?php

class Book  
{
    // mes attributs
    protected $title;
    protected $description;
    protected $author;
    protected $note;

    // SETTERS
    public function setTitle($string){
        $this->title = $string;
    }

    public function setDescription($string)
    {
        $this->description = $string;
    }

    public function setAuthor($string)
    {
        $this->author = $string;
    }

    public function setNote($string)
    {
        $this->note = $string;
    }

    // GETTERS
    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getNote()
    {
        return $this->note;
    }
}
