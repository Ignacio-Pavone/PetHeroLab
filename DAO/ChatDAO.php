<?php namespace DAO;
use Model\Chat as Chat;
use \Exception as Exception;
use DAo\Connection as Connection;
    class ChatDAO
    {

        private $connection;
        private $tableName = "Chats";

        /**
         * @throws \Exception
         */
        public function Add($chat)
        {
            $query = "INSERT INTO " . $this->tableName . " (senderId, receiverId, message, idRequest) VALUES (:senderId, :receiverId, :message, :idRequest);";
            $parameters["senderId"] = $chat->getSenderId();
            $parameters["receiverId"] = $chat->getReceiverId();
            $parameters["message"] = $chat->getMessage();
            $parameters["idRequest"] = $chat->getIdRequest();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);

        }

        /**
         * @throws \Exception
         */
        public function SearchChatByReqId($idRequest)
        {
            $chatList = array();
            $query = "SELECT * FROM " . $this->tableName . " WHERE idRequest = :idRequest;";
            $parameters["idRequest"] = $idRequest;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);
            foreach ($resultSet as $row) {
                $chat = new Chat();
                $chat->setId($row["id"]);
                $chat->setSenderId($row["senderId"]);
                $chat->setReceiverId($row["receiverId"]);
                $chat->setMessage($row["message"]);
                $chat->setIdRequest($row["idRequest"]);
                array_push($chatList, $chat);
            }
            return $chatList;
        }






    }


?>