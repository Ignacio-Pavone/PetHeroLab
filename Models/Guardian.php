<?php
namespace Models;

class Guardian extends User {
    private $id;
    private $pet_size;
    private $fee;
    private $reputation;
    private $initDate;
    private $finishDate;

    public function __construct($email, $fullname, $dni, $age, $password, $pet_size, $fee, $initDate, $finishDate){
        parent::__construct($email, $fullname, $dni, $age, $password);
        $this->pet_size = $pet_size;
        $this->fee = $fee;
        $this->reputation = 0;
        $this->initDate = $initDate;
        $this->finishDate = $finishDate;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }
    public function setPetSize($pet_size){
        $this->pet_size = $pet_size;
    }

    public function setinitDate($initDate){
        $this->initDate = $initDate;
    }

    public function setfinishDate($finishDate){
        $this->finishDate = $finishDate;
    }

    public function getFinishDate(){
        return $this->finishDate;
    }

    public function getInitDate(){
        return $this->initDate;
    }

    public function getPetSize(){
        return $this->pet_size;
    }

    public function setFee($fee){
        $this->fee = $fee;
    }

    public function getFee(){
        return $this->fee;
    }

    public function setReputation($reputation){
        $this->reputation = $reputation;
    }

    public function getReputation(){
        return $this->reputation;
    }

    public function checkReputation ($rep, $count){
        $reputation = 0;
        $reputation = $rep/$count;
        $this->setReputation($reputation);
    }

}

?>