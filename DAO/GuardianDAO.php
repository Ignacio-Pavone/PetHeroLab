<?php
namespace DAO;
use Utils\Session;
use DAo\Connection as Connection;
use Models\Guardian;

class GuardianDAO
{
    private $connection;
    private $tableName = "Guardians";

    /**
     * @throws \Exception
     */
    public function findByID($id_guardian)
    {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE id_guardian = :id_guardian";
        $this->connection = Connection::GetInstance();
        $result = $this->connection->Execute($sql, array("id_guardian" => $id_guardian));
        foreach ($result as $row) {
            $guardian = new Guardian($row["email"], $row["fullname"], $row["dni"], $row["age"], $row["password"], $row['pet_size'], $row['fee'], $row['init_date'], $row['finish_date']);
            $guardian->setId($row["id_guardian"]);
        }
        return $guardian;
    }

    /**
     * @throws \Exception
     */
    public function getByEmail($email)
    {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE email = :email";
        $this->connection = Connection::GetInstance();
        $result = $this->connection->Execute($sql, array("email" => $email));
        foreach ($result as $row) {
            $guardian = new Guardian($row["email"], $row["fullname"], $row["dni"], $row["age"], $row["password"], $row['pet_size'], $row['fee'], $row['init_date'], $row['finish_date']);
            $guardian->setId($row["id_guardian"]);
            $guardian->setReputation($row["reputation"]);
        }
        return $guardian;
    }

    /**
     * @throws \Exception
     */
    public function GetAll()
    {
        $sql = "SELECT * FROM " . $this->tableName;
        $this->connection = Connection::GetInstance();
        $result = $this->connection->Execute($sql);
        $guardians = array();
        foreach ($result as $row) {
            $guardian = new Guardian($row["email"], $row["fullname"], $row["dni"], $row["age"], $row["password"], $row['pet_size'], $row['fee'], $row['init_date'], $row['finish_date']);
            $guardian->setId($row["id_guardian"]);
            $guardian->setReputation($row["reputation"]);
            array_push($guardians, $guardian);
        }
        return $guardians;
    }

    /**
     * @throws \Exception
     */
    public function add($user)
    {
        $sql = "INSERT INTO " . $this->tableName . " (email, fullname, dni, age, password,pet_size,fee,reputation,init_date,finish_date) VALUES (:email, :fullname, :dni, :age, :password,:pet_size,:fee,:reputation,:init_date,:finish_date)";
        $parameters["email"] = $user->getEmail();
        $parameters["fullname"] = $user->getFullName();
        $parameters["dni"] = $user->getDni();
        $parameters["age"] = $user->getAge();
        $parameters["password"] = $user->getPassword();
        $parameters["pet_size"] = $user->getPetSize();
        $parameters["fee"] = $user->getFee();
        $parameters["reputation"] = $user->getReputation();
        $parameters["init_date"] = $user->getInitDate();
        $parameters["finish_date"] = $user->getFinishDate();
        $this->connection = Connection::GetInstance();
        $this->connection->ExecuteNonQuery($sql, $parameters);
    }

    /**
     * @throws \Exception
     */
    public function update($user)
    {
        $search = $this->getByEmail($user->getEmail());
        if ($search != null) {
            $sql = "UPDATE " . $this->tableName . " SET email = :email, fullname = :fullname, dni = :dni, age = :age, password = :password, pet_size = :pet_size, fee = :fee, reputation = :reputation, init_date = :init_date, finish_date = :finish_date WHERE email = :email";
            $parameters["email"] = $user->getEmail();
            $parameters["fullname"] = $user->getFullName();
            $parameters["dni"] = $user->getDni();
            $parameters["age"] = $user->getAge();
            $parameters["password"] = $user->getPassword();
            $parameters["pet_size"] = $user->getPetSize();
            $parameters["fee"] = $user->getFee();
            $parameters["reputation"] = $user->getReputation();
            $parameters["init_date"] = $user->getInitDate();
            $parameters["finish_date"] = $user->getFinishDate();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($sql, $parameters);
        }
    }

    /**
     * @throws \Exception
     */
    public function LoginCheck($email, $password)
    {
        $user = $this->getByEmail($email);
        if ($user != null) {
            if ($user->getPassword() == $password) {
                Session::CreateSession($user);
                Session::SetTypeUser("guardian");
                return true;
            }
        }
    }

    /**
     * @throws \Exception
     */
    public function dniExistboth($dni)
    {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE dni = :dni";
        $sql2 = "SELECT * FROM " . "Owners" . " WHERE dni = :dni";
        $this->connection = Connection::GetInstance();
        $result = $this->connection->Execute($sql);
        $result2 = $this->connection->Execute($sql2);
        if ($result != null || $result2 != null) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @throws \Exception
     */
    public function emailExistBoth($email)
    {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE email = :email";
        $sql2 = "SELECT * FROM " . "Owners" . " WHERE email = :email";
        $this->connection = Connection::GetInstance();
        $result = $this->connection->Execute($sql, array("email" => $email));
        $result2 = $this->connection->Execute($sql2, array("email" => $email));
        if ($result != null || $result2 != null) {
            return true;
        } else {
            return false;
        }
    }

    public function checkProfile($guardian)
    {
        if ($guardian->getInitDate() == null) {
            return true;
        }
        return false;
    }

    public function getByDate($fechaI, $fechaF)
    {
        $array = array();
        foreach ($this->GetAll() as $guardian) {
            if ($guardian->getInitDate() >= $fechaI && $guardian->getFinishDate() <= $fechaF) {
                array_push($array, $guardian);
            }
        }
        return $array;
    }

    /**
     * @throws \Exception
     */
    public function updateDisponibility($user, $initDate, $lastDate)
    {
        $search = $this->getByEmail($user);
        if ($search != null) {
            $search->setfinishDate($lastDate);
            $search->setinitDate($initDate);
            $this->update($search);
            Session::CreateSession($search);
            return true;
        }
        return false;
    }

    /**
     * @throws \Exception
     */
    public function updatePassword($id, $password)
    {
        $sql = "UPDATE " . $this->tableName . " SET password = :password WHERE id_guardian = :id_guardian";
        $parameters["id_guardian"] = $id;
        $parameters["password"] = $password;
        $this->connection = Connection::GetInstance();
        $this->connection->ExecuteNonQuery($sql, $parameters);
    }
}
?>