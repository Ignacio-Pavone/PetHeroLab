<?php
namespace Controllers;
use DAO\ChatDAO as ChatDAO;
use DAO\GuardianDAO as GuardianDAO;
use DAO\OwnerDAO as OwnerDAO;
use DAO\PetDAO as PetDAO;
use DAO\RequestDAO as RequestDAO;
use Models\Chat as Chat;

class ChatController{
    private $chatDAO;
    private $guardianDAO;
    private $ownerDAO;
    private $petDAO;

    public function __construct(){
        $this->chatDAO = new ChatDAO();
        $this->guardianDAO = new GuardianDAO();
        $this->ownerDAO = new OwnerDAO();
        $this->petDAO = new PetDAO();
    }

    public function Add($message,$idReceiver,$idRequest, $senderType){
        $this->chatDAO->createChat($message,$idReceiver,$idRequest, $senderType);
        $this->showChat($idRequest,$idReceiver,$senderType);
    }

    public function searchChatByReqId($idRequest){
        return $this->chatDAO->searchChatByReqId($idRequest);
    }

    public function showChat($idRequest,$idReceiver,$senderType)
    {
        $sender_type = $senderType;
        $id_receiver = $idReceiver;
        $id_request = $idRequest;
        if($sender_type=="owner"){
            $sender = $this->ownerDAO->findbyId($_SESSION["loggedUser"]->getId());
            $receiver = $this->guardianDAO->findbyId($idReceiver);
        }else{
            $receiver = $this->guardianDAO->findbyId($_SESSION["loggedUser"]->getId());
            $sender = $this->ownerDAO->findbyId($idReceiver);
        }
        $chats = $this->chatDAO->SearchChatByReqId($idRequest);

        require_once(VIEWS_PATH . "chat.php");
    }

    public function refreshChat($sender_type,$id_receiver,$id_request){
        $this->showChat($id_request,$id_receiver,$sender_type);
    }


}