<?php
namespace DAO;
use Models\Duenio;
use Utils\Session;
use DAo\Connection as Connection;

class duenioDAO{
    private $connection;
    private $tableName = "Owners";

    public function GetAllDuenios (){
        try{
        $sql = "SELECT * FROM ".$this->tableName;
        $this->connection = Connection::GetInstance();
        $result = $this->connection->Execute($sql);
        $duenios = array();
        foreach($result as $row){
            $duenio = new Duenio($row["email"], $row["fullname"], $row["dni"], $row["age"], $row["password"]);
            $duenio->setIdDuenio($row["id_owner"]);
            array_push($duenios, $duenio);
        }
        return $duenios;
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function addDuenio(Duenio $duenio){
        try{
            $sql = "INSERT INTO ".$this->tableName." (id_owner,email,fullname,dni,age,password) VALUES (:id_owner,:email,:fullname,:dni,:age,:password)";
            $parameters["id_owner"] = $duenio->getIdDuenio();
            $parameters["email"] = $duenio->getEmail();
            $parameters["fullname"] = $duenio->getFullName();
            $parameters["dni"] = $duenio->getDni();
            $parameters["age"] = $duenio->getAge();
            $parameters["password"] = $duenio->getPassword();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($sql, $parameters);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function findbyID($id){
        try{
            $sql = "SELECT * FROM ".$this->tableName." WHERE id_owner = " . $id;
            $parameters["id_owner"] = $id;
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($sql, $parameters);
            foreach ($result as $row){
                $duenio = new Duenio($row["email"], $row["fullname"], $row["dni"], $row["age"], $row["password"]);
                return $duenio;
            }
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function getDuenioByEmail($email){
        try{
            $sql = "SELECT * FROM ".$this->tableName." WHERE email = '".$email."'";
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($sql);
            foreach ($result as $row){
                $duenio = new Duenio($row["email"], $row["fullname"], $row["dni"], $row["age"], $row["password"]);
                $duenio->setIdDuenio($row["id_owner"]);
                return $duenio;
            }
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function LoginCheckDuenio ($email, $password){
        try{
            $sql = "SELECT * FROM ".$this->tableName." WHERE email = '".$email."' AND password = $password;";
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($sql);
            foreach ($result as $row){
                $duenio = new Duenio($row["email"], $row["fullname"], $row["dni"], $row["age"], $row["password"]);
                $duenio->setIdDuenio($row["id_owner"]);
                Session::CreateSession($duenio);
                Session::SetTypeUser("duenio");
                return true;
            }
            return false;
        }catch(\PDOException $ex){
            throw $ex;
        }
    }
        
}