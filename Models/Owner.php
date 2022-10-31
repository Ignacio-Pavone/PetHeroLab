<?php
namespace Models;

class Owner extends User
{
    private $id;
    private $pets;


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getPets()
    {
        return $this->pets;
    }

    public function setPets($pets)
    {
        $this->pets = $pets;
    }


}


?>