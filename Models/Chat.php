<?php namespace Models;
class Chat{
    private $id;
    private $senderId;
    private $receiverId;
    private $message;
    private $idRequest;


    public function getId()
    {
        return $this->id;
    }


    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getSenderId()
    {
        return $this->senderId;
    }


    public function setSenderId($senderId): void
    {
        $this->senderId = $senderId;
    }

    public function getReceiverId()
    {
        return $this->receiverId;
    }


    public function setReceiverId($receiverId): void
    {
        $this->receiverId = $receiverId;
    }


    public function getIdRequest()
    {
        return $this->idRequest;
    }


    public function setIdRequest($idRequest): void
    {
        $this->idRequest = $idRequest;
    }

    public function getMessage()
    {
        return $this->message;
    }


    public function setMessage($message): void
    {
        $this->message = $message;
    }


} 
?>