<?php

class ChatController{
    private $chatDAO;

    public function __construct(){
        $this->chatDAO = new ChatDAO();
    }

    public function Add($receiverId, $message, $idRequest){
        $chat = new Chat();
        $chat->setSenderId($_SESSION["loggedUser"]->getId());
        $chat->setReceiverId($receiverId);
        $chat->setMessage($message);
        $chat->setIdRequest($idRequest);
        $this->chatDAO->add($chat);
    }

    public function searchChatByReqId($idRequest){
        return $this->chatDAO->searchChatByReqId($idRequest);
    }




    public function showAddView()
    {
        require_once(VIEWS_PATH . "chat.php");
    }


}