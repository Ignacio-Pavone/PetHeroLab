<?php namespace DAO;

use Utils\Session;
use DAo\Connection as Connection;
use Models\Guardian;

    class guardianDAO{
      private $connection;
      private $tableName = "Guardians";

      public function findGuardianByID ($id){
        try{
          $sql = "SELECT * FROM ".$this->tableName." WHERE id_guardian = " . $id;
          $this->connection = Connection::GetInstance();
          $result = $this->connection->Execute($sql);
          foreach ($result as $row){
            $guardian = new Guardian($row["email"],$row["fullname"],$row["dni"],$row["age"],$row["password"],$row['pet_size'],$row['remuneracion'],$row['init_date'],$row['finish_date']);
            $guardian->setIdGuardian($row["id_guardian"]);
          }
          return $guardian;
        }catch(\PDOException $ex){
          throw $ex;
        }
      }

      public function getGuardianByEmail($email){
        try{
          $sql = "SELECT * FROM ".$this->tableName." WHERE email = '".$email."'";
          $this->connection = Connection::GetInstance();
          $result = $this->connection->Execute($sql);
          foreach ($result as $row){
            $guardian = new Guardian($row["email"],$row["fullname"],$row["dni"],$row["age"],$row["password"],$row['pet_size'],$row['remuneracion'],$row['init_date'],$row['finish_date']);
            $guardian->setIdGuardian($row["id_guardian"]);
            $guardian->setReputacion($row["reputation"]);
            return $guardian;
          }
          
        }catch(\PDOException $ex){
          throw $ex;
        }
      }

      public function GetAllGuardians(){
        try{
          $sql = "SELECT * FROM ".$this->tableName;
          $this->connection = Connection::GetInstance();
          $result = $this->connection->Execute($sql);
          $guardians = array();
          foreach($result as $row){
            $guardian = new Guardian($row["email"],$row["fullname"],$row["dni"],$row["age"],$row["password"],$row['pet_size'],$row['remuneracion'],$row['init_date'],$row['finish_date']);
            $guardian->setIdGuardian($row["id_guardian"]);
            $guardian->setReputacion($row["reputation"]);
            array_push($guardians, $guardian);
          }
          return $guardians;
        }catch(\PDOException $ex){
          throw $ex;
        }
      }

      public function addGuardian($user){
        try{
          $sql = "INSERT INTO ".$this->tableName." (email, fullname, dni, age, password,pet_size,remuneracion,reputation,init_date,finish_date) VALUES (:email, :fullname, :dni, :age, :password,:pet_size,:remuneracion,:reputation,:init_date,:finish_date)";
          $parameters["email"] = $user->getEmail();
          $parameters["fullname"] = $user->getFullName();
          $parameters["dni"] = $user->getDni();
          $parameters["age"] = $user->getAge();
          $parameters["password"] = $user->getPassword();
          $parameters["pet_size"] = $user->getTipoMascota();
          $parameters["remuneracion"] = $user->getRemuneracionEsperada();
          $parameters["reputation"] = $user->getReputacion();
          $parameters["init_date"] = $user->getInitDate();
          $parameters["finish_date"] = $user->getFinishDate();
          $this->connection = Connection::GetInstance();
          $this->connection->ExecuteNonQuery($sql, $parameters);
        }catch(\PDOException $ex){
          throw $ex;
        }
      }

      public function updateUser ($user){
        $search = $this->getGuardianByEmail($user->getEmail());
        if($search != null){
          try{
            $sql = "UPDATE ".$this->tableName." SET email = :email, fullname = :fullname, dni = :dni, age = :age, password = :password, pet_size = :pet_size, remuneracion = :remuneracion, reputation = :reputation, init_date = :init_date, finish_date = :finish_date WHERE email = :email";
            $parameters["email"] = $user->getEmail();
            $parameters["fullname"] = $user->getFullName();
            $parameters["dni"] = $user->getDni();
            $parameters["age"] = $user->getAge();
            $parameters["password"] = $user->getPassword();
            $parameters["pet_size"] = $user->getTipoMascota();
            $parameters["remuneracion"] = $user->getRemuneracionEsperada();
            $parameters["reputation"] = $user->getReputacion();
            $parameters["init_date"] = $user->getInitDate();
            $parameters["finish_date"] = $user->getFinishDate();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($sql, $parameters);
          }catch(\PDOException $ex){
            throw $ex;
          }
        }
      }

      public function LoginCheckGuardian ($email,$password){
          $user = $this->getGuardianByEmail($email);
          if($user != null){
            if($user->getPassword() == $password){
              Session::CreateSession($user);
              Session::SetTypeUser("guardian");
              return true;
            }
          }
    }
      
    public function checkPerfil ($guardian){
        if ($guardian->getInitDate() == null){
          return true;
        }
        return false;
   }

    public function getGuardiansByDate($fechaI,$fechaF){
        $date1 = strtotime($fechaI);
        $date2 = strtotime($fechaF);
        $array = array();
        foreach($this->GetAllGuardians() as $guardian){
          $date1guardian = strtotime($guardian->getInitDate());
          $date2guardian = strtotime($guardian->getFinishDate());
          if ($date1guardian >= $date1 && $date2guardian <= $date2){
            array_push($array,$guardian);
          }
        }
        return $array;
    }

    public function updateGuardianDiponibility($user, $initDate, $lastDate){
        $search = $this->getGuardianByEmail($user);
        if ($search != null){
          $search->setfinishDate($lastDate);
          $search->setinitDate($initDate);
          $this->updateUser($search);
          Session::CreateSession($search);
          return true;
       }
      return false;


}
}
?>