<?php

namespace Models;

class Request
{
    private $id_request;
    private $id_guardian;
    private $id_owner;
    private $id_pet;
    private $init_date;
    private $finish_date;
    private $req_status;
    private $score;
    private $final_price;
    private $type;
    private $breed;
    private $days_amount;

    public function __construct($id_pet, $id_owner, $id_guardian, $init_date, $finish_date, $final_price, $type, $breed, $days_amount)
    {
        $this->id_pet = $id_pet;
        $this->id_owner = $id_owner;
        $this->id_guardian = $id_guardian;
        $this->init_date = $init_date;
        $this->finish_date = $finish_date;
        $this->final_price = $final_price;
        $this->type = $type;
        $this->breed = $breed;
        $this->score = 0;
        $this->days_amount = $days_amount;
    }


    public function getIdRequest()
    {
        return $this->id_request;
    }


    public function setIdRequest($id_request)
    {
        $this->id_request = $id_request;
    }


    public function getIdGuardian()
    {
        return $this->id_guardian;
    }


    public function setIdGuardian($id_guardian)
    {
        $this->id_guardian = $id_guardian;
    }


    public function getIdOwner()
    {
        return $this->id_owner;
    }


    public function setIdOwner($id_owner)
    {
        $this->id_owner = $id_owner;
    }


    public function getIdPet()
    {
        return $this->id_pet;
    }


    public function setIdPet($id_pet)
    {
        $this->id_pet = $id_pet;
    }


    public function getInitDate()
    {
        return $this->init_date;
    }


    public function setInitDate($init_date)
    {
        $this->init_date = $init_date;
    }


    public function getFinishDate()
    {
        return $this->finish_date;
    }


    public function setFinishDate($finish_date)
    {
        $this->finish_date = $finish_date;
    }


    public function getReqStatus()
    {
        return $this->req_status;
    }


    public function setReqStatus($req_status)
    {
        $this->req_status = $req_status;
    }


    public function getScore()
    {
        return $this->score;
    }

    public function setScore(int $score)
    {
        $this->score = $score;
    }


    public function getFinalPrice()
    {
        return $this->final_price;
    }

    public function getType()
    {
        return $this->type;
    }


    public function setType($type)
    {
        $this->type = $type;
    }


    public function getBreed()
    {
        return $this->breed;
    }


    public function setBreed($breed)
    {
        $this->breed = $breed;
    }


    public function getDaysAmount()
    {
        return $this->days_amount;
    }


    public function setDaysAmount($days_amount)
    {
        $this->days_amount = $days_amount;
    }

    public function setFinalPrice($costo)
    {
        $this->final_price = $costo * $this->days_amount;
    }

}