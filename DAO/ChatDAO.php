<?php namespace DAO;
use \Exception as Exception;
use DAo\Connection as Connection;
use Models\Chat as Chat;
    class ChatDAO
    {

        private $connection;
        private $tableName = "Chats";

        /**
         * @throws \Exception
         */
        public function Add($chat)
        {
            $query = "INSERT INTO " . $this->tableName . " (senderId, receiverId, id_request, sender_type ,message) VALUES (:senderId, :receiverId, :id_request, :sender_type ,:message);";
            var_dump($chat);
            $parameters["senderId"] = $chat->getSenderId();
            $parameters["receiverId"] = $chat->getReceiverId();
            $parameters["id_request"] = $chat->getIdRequest();
            $parameters["sender_type"] = $chat->getSenderType();
            $parameters["message"] = $chat->getMessage();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);

        }

        /**
         * @throws \Exception
         */
        public function SearchChatByReqId($idRequest)
        {
            $chatList = array();
            $query = "SELECT * FROM " . $this->tableName . " WHERE id_request = :id_request;";
            $parameters["id_request"] = $idRequest;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);
            foreach ($resultSet as $row) {
                $chat = new Chat();
                $chat->setId($row["id_chat"]);
                $chat->setSenderId($row["senderId"]);
                $chat->setReceiverId($row["receiverId"]);
                $chat->setSenderType($row["sender_type"]);
                $chat->setMessage($row["message"]);
                $chat->setIdRequest($row["id_request"]);
                array_push($chatList, $chat);
            }
            return $chatList;
        }


        public function createChat($message,$idReceiver,$idRequest, $senderType){
            $chat = new Chat();
            $chat->setSenderId($_SESSION["loggedUser"]->getId());
            $chat->setReceiverId($idReceiver);
            $chat->setSenderType($senderType);
            $chat->setMessage($message);
            $chat->setIdRequest($idRequest);
            $this->add($chat);
        }



    }


?>