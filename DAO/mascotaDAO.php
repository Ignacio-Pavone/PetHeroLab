<?php
namespace DAO;

use Models\Mascota;
use DAO\Connection as Connection;

class mascotaDAO {
    private $connection;
    private $tableName = "Pets";

    public function GetAllMascotas(){
        try {
            $sql = "SELECT * FROM ".$this->tableName;
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($sql);
            $mascotas = array();
            foreach($result as $row){
                $mascota = new Mascota($row["id_owner"],$row['name'],$row["type"],$row["breed"],$row["pet_size"],$row["photo_url"],$row["vaccination_schedule"],$row["video_url"]);
                $mascota->setIdMascota($row["id_pet"]);
                array_push($mascotas, $mascota);
            }
            return $mascotas;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }
    
    public function findMascotaByID ($id){
        try{
            $sql = "SELECT * FROM ".$this->tableName." WHERE id_pet = " . $id;
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($sql);
            foreach ($result as $row){
                $mascota = new Mascota($row["id_owner"],$row['name'],$row["type"],$row["breed"],$row["pet_size"],$row["photo_url"],$row["vaccination_schedule"],$row["video_url"]);
                $mascota->setIdMascota($row["id_pet"]);
            }
            return $mascota;
        }catch(\PDOException $ex){
            throw $ex;
        }
    }


   public function addMascota ($mascota){
        try{
            $sql = "INSERT INTO ".$this->tableName." (id_owner,name,type,breed,pet_size,vaccination_schedule,photo_url,video_url) VALUES (:id_owner,:name,:type,:breed,:pet_size,:vaccination_schedule,:photo_url,:video_url)";
            $parameters["id_owner"] = $mascota->getidDuenio();
            $parameters["name"] = $mascota->getNombre();
            $parameters["type"] = $mascota->getTipo();
            $parameters["breed"] = $mascota->getRaza();
            $parameters["pet_size"] = $mascota->getTamanio();
            $parameters["vaccination_schedule"] = $mascota->getPlanVacunacion();
            $parameters["photo_url"] = $mascota->getFoto();
            $parameters["video_url"] = $mascota->getVideo();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($sql, $parameters);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function deleteMascota ($id){
        try{
            $sql = "DELETE FROM ".$this->tableName." WHERE id_pet = " . $id;
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($sql);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function updateMascota ($mascota){
        try{
            $sql = "UPDATE ".$this->tableName." SET id_pet = :id_pet, id_owner = :id_owner, name = :name, type = :type, breed = :breed, pet_size = :pet_size, vaccination_schedule = :vaccination_schedule, photo_url = :photo_url, video_url = :video_url WHERE id_pet = " . $mascota->getIdMascota();
            $parameters["id_pet"] = $mascota->getIdMascota();
            $parameters["id_owner"] = $mascota->getidDuenio();
            $parameters["name"] = $mascota->getNombre();
            $parameters["type"] = $mascota->getTipo();
            $parameters["breed"] = $mascota->getRaza();
            $parameters["pet_size"] = $mascota->getTamanio();
            $parameters["vaccination_schedule"] = $mascota->getPlanVacunacion();
            $parameters["photo_url"] = $mascota->getFoto();
            $parameters["video_url"] = $mascota->getVideo();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($sql, $parameters);
            return true;
        }catch(\PDOException $ex){
            throw $ex;
        }
        return false;
   }

   public function devolverMascotasporDuenio ($id){
        try{
            if ($id!=null){
                $sql = "SELECT * FROM ".$this->tableName." WHERE id_owner = " . $id;
                $this->connection = Connection::GetInstance();
                $result = $this->connection->Execute($sql);
                $mascotas = array();
                foreach($result as $row){
                    $mascota = new Mascota($row["id_owner"],$row['name'],$row["type"],$row["breed"],$row["pet_size"],$row["photo_url"],$row["vaccination_schedule"],$row["video_url"]);
                    $mascota->setIdMascota($row["id_pet"]);
                    array_push($mascotas, $mascota);
                }
                return $mascotas;
            }
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

   public function filtrarMascotasporTamanio($tamanio){
        try{
            $sql = "SELECT * FROM ".$this->tableName." WHERE pet_size = " . $tamanio;
            var_dump($sql);
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($sql);
            $mascotas = array();
            foreach($result as $row){
                $mascota = new Mascota($row["id_pet"],$row["id_owner"],$row['name'],$row["type"],$row["breed"],$row["pet_size"],$row["vaccination_schedule"],$row["photo_url"],$row["video_url"]);
                array_push($mascotas, $mascota);
            }
            return $mascotas;
        }catch(\PDOException $ex){
            throw $ex;
        }
    }
}