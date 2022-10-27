<?php
namespace DAO;

use Models\Pet;
use DAO\Connection as Connection;

class petDAO {
    private $connection;
    private $tableName = "Pets";

    public function GetAll(){
        try {
            $sql = "SELECT * FROM ".$this->tableName;
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($sql);
            $mascotas = array();
            foreach($result as $row){
                $mascota = new Pet($row["id_owner"],$row['name'],$row["type"],$row["breed"],$row["pet_size"],$row["photo_url"],$row["vaccination_schedule"],$row["video_url"]);
                $mascota->setId($row["id_pet"]);
                array_push($mascotas, $mascota);
            }
            return $mascotas;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }
    
    public function findByID ($id){
        try{
            $sql = "SELECT * FROM ".$this->tableName." WHERE id_pet = " . $id;
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($sql);
            foreach ($result as $row){
                $mascota = new Pet($row["id_owner"],$row['name'],$row["type"],$row["breed"],$row["pet_size"],$row["photo_url"],$row["vaccination_schedule"],$row["video_url"]);
                $mascota->setId($row["id_pet"]);
            }
            return $mascota;
        }catch(\PDOException $ex){
            throw $ex;
        }
    }


   public function add ($mascota){
        try{
            $sql = "INSERT INTO ".$this->tableName." (id_owner,name,type,breed,pet_size,vaccination_schedule,photo_url,video_url) VALUES (:id_owner,:name,:type,:breed,:pet_size,:vaccination_schedule,:photo_url,:video_url)";
            $parameters["id_owner"] = $mascota->getidOwner();
            $parameters["name"] = $mascota->getName();
            $parameters["type"] = $mascota->getType();
            $parameters["breed"] = $mascota->getBreed();
            $parameters["pet_size"] = $mascota->getPetsize();
            $parameters["vaccination_schedule"] = $mascota->getVaccinationschedule();
            $parameters["photo_url"] = $mascota->getPhotoUrl();
            $parameters["video_url"] = $mascota->getVideoUrl();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($sql, $parameters);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function delete ($id){
        try{
            $sql = "DELETE FROM ".$this->tableName." WHERE id_pet = " . $id;
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($sql);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function update ($mascota){
        try{
            $sql = "UPDATE ".$this->tableName." SET id_pet = :id_pet, id_owner = :id_owner, name = :name, type = :type, breed = :breed, pet_size = :pet_size, vaccination_schedule = :vaccination_schedule, photo_url = :photo_url, video_url = :video_url WHERE id_pet = " . $mascota->getId();
            $parameters["id_pet"] = $mascota->getId();
            $parameters["id_owner"] = $mascota->getidOwner();
            $parameters["name"] = $mascota->getName();
            $parameters["type"] = $mascota->getType();
            $parameters["breed"] = $mascota->getBreed();
            $parameters["pet_size"] = $mascota->getPetsize();
            $parameters["vaccination_schedule"] = $mascota->getVaccinationschedule();
            $parameters["photo_url"] = $mascota->getPhotoUrl();
            $parameters["video_url"] = $mascota->getVideoUrl();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($sql, $parameters);
            return true;
        }catch(\PDOException $ex){
            throw $ex;
        }
        return false;
   }

   public function returnByOwner ($id){
        try{
            if ($id!=null){
                $sql = "SELECT * FROM ".$this->tableName." WHERE id_owner = " . $id;
                $this->connection = Connection::GetInstance();
                $result = $this->connection->Execute($sql);
                $mascotas = array();
                foreach($result as $row){
                    $mascota = new Pet($row["id_owner"],$row['name'],$row["type"],$row["breed"],$row["pet_size"],$row["photo_url"],$row["vaccination_schedule"],$row["video_url"]);
                    $mascota->setId($row["id_pet"]);
                    array_push($mascotas, $mascota);
                }
                return $mascotas;
            }
        }catch(\PDOException $ex){
            throw $ex;
        }
    }
}