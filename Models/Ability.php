<?php

class Ability
{
    private $id;
    private $name;
    private $type;
    private $note;

    public function __construct()
    {
        
    }

    public function create($name, $type, $note)
    {
        $this->name = $name;
        $this->type = $type;
        $this->note = $note;
    }

    public function createWithId($id, $name, $type, $note)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->note = $note;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNote()
    {
        return $this->note;
    }

    public function setNote($note)
    {
        $this->note = $note;

    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;

    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

    }

 
} 

?>