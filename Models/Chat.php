<?php namespace Models;
class Chat{
    private $id;
    private $idOwner;
    private $idGuardian;
    private $idRequest;
    private $message;

    public function __construct($id,$idOwner,$idGuardian,$idRequest,$message){
        $this->id=$id;
        $this->idOwner=$idOwner;
        $this->idGuardian=$idGuardian;
        $this->idRequest=$idRequest;
        $this->message=$message;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIdOwner()
    {
        return $this->idOwner;
    }

    public function setIdOwner($idOwner)
    {
        $this->idOwner = $idOwner;
    }

    public function getIdGuardian()
    {
        return $this->idGuardian;
    }

    public function setIdGuardian($idGuardian)
    {
        $this->idGuardian = $idGuardian;
    }

    public function getIdRequest()
    {
        return $this->idRequest;
    }

    public function setIdRequest($idRequest)
    {
        $this->idRequest = $idRequest;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        return $this;
    }
} 
?>