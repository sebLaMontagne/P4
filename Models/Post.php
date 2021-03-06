<?php

class Post
{
    private $_id;
    private $_title;
    private $_chapterNumber;
    private $_content;
    private $_date;
    private $_isPublished;
    
    //--------------------------------------------------------------------
    // GETTERS
    //--------------------------------------------------------------------
    
    public function id()            { return $this->_id; }
    public function title()         { return $this->_title; }
    public function chapterNumber() { return $this->_chapterNumber; }
    public function content()       { return $this->_content; }
    public function date()          { return $this->_date; }
    public function isPublished()   { return $this->_isPublished; }
    
    //--------------------------------------------------------------------
    // SETTERS
    //--------------------------------------------------------------------
    
    public function setId($id)
    {
        if(intval($id) > 0)
        {
            $this->_id = $id;
        }
        else
        {
            throw new Exception('The Post id must be a strictly positive integer value');
        }
    }

    public function setTitle($title)
    {
        if(is_string($title))
        {
            $this->_title = htmlspecialchars($title);
        }
        else
        {
            throw new Exception('The Post title must be a string value');
        }
    }

    public function setChapterNumber($chapterNumber)
    {
        if(intval($chapterNumber) > 0)
        {
            $this->_chapterNumber = $chapterNumber;
        }
        else
        {
            throw new Exception('The Post chapter number must be a strictly positive integer value');
        }
    }

    public function setContent($content)
    {
        if(is_string($content))
        {
            $this->_content = htmlspecialchars($content);
        }
        else
        {
            throw new Exception('The Post illustration must be a string value');
        }
    }

    public function setDate($date)
    {
        if(preg_match("#^20[0-9]{2}(-[0-9]{2}){2} ([0-9]{2}:){2}([0-9]){2}$#", $date))
        {
            $this->_date = $date;
        }
        else
        {
            throw new Exception('The date don\'t respect the date format');
        }
    }
    
    public function setIsPublished($isPublished)
    {
        if($isPublished == 0 || $isPublished == 1)
        {
            $this->_isPublished = $isPublished;
        }
        else
        {
            throw new Exception('The isPublished status must be a boolean value');
        }
    }
    
    //--------------------------------------------------------------------
    // ABOUT CONSTRUCTOR
    //--------------------------------------------------------------------
    
    public function hydrate(array $data)
    {
        foreach($data as $key => $value)
        {
            $method = 'set'.ucfirst($key);
            if(method_exists($this, $method))
            {
                $this->$method($value);
            }
        }
    }
    
    public function __construct(array $data)
    {
        $this->hydrate($data);
    }
}