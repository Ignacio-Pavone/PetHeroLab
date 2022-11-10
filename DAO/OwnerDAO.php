<?php
namespace DAO;
use Models\Owner;
use Utils\Session;
use DAo\Connection as Connection;

class OwnerDAO
{
    private $connection;
    private $tableName = "Owners";

    public function GetAll()
    {
        try {
            $sql = "SELECT * FROM " . $this->tableName;
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($sql);
            $owners = array();
            foreach ($result as $row) {
                $owner = new Owner($row["email"], $row["fullname"], $row["dni"], $row["age"], $row["password"]);
                $owner->setId($row["id_owner"]);
                array_push($owners, $owner);
            }
            return $owners;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function updatePassword($id, $password)
    {
        try {
            $sql = "UPDATE " . $this->tableName . " SET password = :password WHERE id_owner = :id_owner";
            $parameters["id_owner"] = $id;
            $parameters["password"] = $password;
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($sql, $parameters);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function add($owner)
    {
        try {
            $sql = "INSERT INTO " . $this->tableName . " (id_owner,email,fullname,dni,age,password) VALUES (:id_owner,:email,:fullname,:dni,:age,:password)";
            $parameters["id_owner"] = $owner->getId();
            $parameters["email"] = $owner->getEmail();
            $parameters["fullname"] = $owner->getFullName();
            $parameters["dni"] = $owner->getDni();
            $parameters["age"] = $owner->getAge();
            $parameters["password"] = $owner->getPassword();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($sql, $parameters);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function findbyID($id_owner)
    {
        try {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE id_owner = :id_owner";
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($sql, array("id_owner" => $id_owner));
            foreach ($result as $row) {
                $owner = new Owner($row["email"], $row["fullname"], $row["dni"], $row["age"], $row["password"]);
                $owner->setId($row["id_owner"]);
            }
            return $owner;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function emailExistBoth($email)
    {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE email = :email";
        $sql2 = "SELECT * FROM " . "Guardians" . " WHERE email = :email";
        $this->connection = Connection::GetInstance();
        $result = $this->connection->Execute($sql, array("email" => $email));
        $result2 = $this->connection->Execute($sql2, array("email" => $email));
        if (!empty($result) || !empty($result2)) {
            return true;
        } else {
            return false;
        }
    }

    public function dniExistBoth($dni)
    {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE dni = :dni";
        $sql2 = "SELECT * FROM " . "Guardians" . " WHERE dni = :dni";
        $this->connection = Connection::GetInstance();
        $result = $this->connection->Execute($sql, array("dni" => $dni));
        $result2 = $this->connection->Execute($sql2, array("dni" => $dni));
        if (!empty($result) || !empty($result2)) {
            return true;
        } else {
            return false;
        }
    }

    public function getByEmail($email)
    {
        try {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE email = :email";
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($sql, array("email" => $email));
            foreach ($result as $row) {
                $owner = new Owner($row["email"], $row["fullname"], $row["dni"], $row["age"], $row["password"]);
                $owner->setId($row["id_owner"]);
                return $owner;
            }
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function LoginCheck($email, $password)
    {
        try {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE email = :email AND password = :password";
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($sql, array("email" => $email, "password" => $password));
            foreach ($result as $row) {
                $owner = new Owner($row["email"], $row["fullname"], $row["dni"], $row["age"], $row["password"]);
                $owner->setId($row["id_owner"]);
                Session::CreateSession($owner);
                Session::SetTypeUser("owner");
                return true;
            }
            return false;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }
}
?>