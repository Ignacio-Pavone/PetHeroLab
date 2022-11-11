<?php
namespace DAO;
use Models\Pet;
use DAO\Connection as Connection;

class PetDAO
{
    private $connection;
    private $tableName = "Pets";

    /**
     * @throws \Exception
     */
    public function GetAll()
    {
        $sql = "SELECT * FROM " . $this->tableName;
        $this->connection = Connection::GetInstance();
        $result = $this->connection->Execute($sql);
        $pets = array();
        foreach ($result as $row) {
            $pet = new Pet($row["id_owner"], $row['name'], $row["type"], $row["breed"], $row["pet_size"], $row["photo_url"], $row["vaccination_schedule"], $row["video_url"]);
            $pet->setId($row["id_pet"]);
            array_push($pets, $pet);
        }
        return $pets;
    }

    /**
     * @throws \Exception
     */
    public function findByID($id_pet)
    {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE id_pet = :id_pet";
        $this->connection = Connection::GetInstance();
        $result = $this->connection->Execute($sql, array("id_pet" => $id_pet));
        foreach ($result as $row) {
            $pet = new Pet($row["id_owner"], $row['name'], $row["type"], $row["breed"], $row["pet_size"], $row["photo_url"], $row["vaccination_schedule"], $row["video_url"]);
            $pet->setId($row["id_pet"]);
        }
        return $pet;
    }


    /**
     * @throws \Exception
     */
    public function add($pet)
    {
        $sql = "INSERT INTO " . $this->tableName . " (id_owner,name,type,breed,pet_size,vaccination_schedule,photo_url,video_url) VALUES (:id_owner,:name,:type,:breed,:pet_size,:vaccination_schedule,:photo_url,:video_url)";
        $parameters["id_owner"] = $pet->getidOwner();
        $parameters["name"] = $pet->getName();
        $parameters["type"] = $pet->getType();
        $parameters["breed"] = $pet->getBreed();
        $parameters["pet_size"] = $pet->getPetsize();
        $parameters["vaccination_schedule"] = $pet->getVaccinationschedule();
        $parameters["photo_url"] = $pet->getPhotoUrl();
        $parameters["video_url"] = $pet->getVideoUrl();
        $this->connection = Connection::GetInstance();
        $this->connection->ExecuteNonQuery($sql, $parameters);
    }

    /**
     * @throws \Exception
     */
    public function delete($id)
    {
        $sql = "DELETE FROM " . $this->tableName . " WHERE id_pet = :id";
        $this->connection = Connection::GetInstance();
        $this->connection->ExecuteNonQuery($sql, array("id" => $id));
    }

    /**
     * @throws \Exception
     */
    public function update($pet)
    {
        $sql = "UPDATE " . $this->tableName . " SET id_pet = :id_pet, id_owner = :id_owner, name = :name, type = :type, breed = :breed, pet_size = :pet_size, vaccination_schedule = :vaccination_schedule, photo_url = :photo_url, video_url = :video_url WHERE id_pet = " . $pet->getId();
        $parameters["id_pet"] = $pet->getId();
        $parameters["id_owner"] = $pet->getidOwner();
        $parameters["name"] = $pet->getName();
        $parameters["type"] = $pet->getType();
        $parameters["breed"] = $pet->getBreed();
        $parameters["pet_size"] = $pet->getPetsize();
        $parameters["vaccination_schedule"] = $pet->getVaccinationschedule();
        $parameters["photo_url"] = $pet->getPhotoUrl();
        $parameters["video_url"] = $pet->getVideoUrl();
        $this->connection = Connection::GetInstance();
        $this->connection->ExecuteNonQuery($sql, $parameters);
    }

    /**
     * @throws \Exception
     */
    public function returnByOwner($id)
    {
        if ($id != null) {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE id_owner = :id";
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($sql, array("id" => $id));
            $pets = array();
            foreach ($result as $row) {
                $pet = new Pet($row["id_owner"], $row['name'], $row["type"], $row["breed"], $row["pet_size"], $row["photo_url"], $row["vaccination_schedule"], $row["video_url"]);
                $pet->setId($row["id_pet"]);
                array_push($pets, $pet);
            }
            return $pets;
        }
    }
}
?>