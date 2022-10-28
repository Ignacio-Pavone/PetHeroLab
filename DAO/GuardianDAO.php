<?php namespace DAO;

use Utils\Session;
use DAo\Connection as Connection;
use Models\Guardian;

    class GuardianDAO{
      private $connection;
      private $tableName = "Guardians";

      public function findByID ($id){
        try{
          $sql = "SELECT * FROM ".$this->tableName." WHERE id_guardian = " . $id;
          $this->connection = Connection::GetInstance();
          $result = $this->connection->Execute($sql);
          foreach ($result as $row){
            $guardian = new Guardian($row["email"],$row["fullname"],$row["dni"],$row["age"],$row["password"],$row['pet_size'],$row['fee'],$row['init_date'],$row['finish_date']);
            $guardian->setId($row["id_guardian"]);
          }
          return $guardian;
        }catch(\PDOException $ex){
          throw $ex;
        }
      }

      public function getByEmail($email){
        try{
          $sql = "SELECT * FROM ".$this->tableName." WHERE email = '".$email."'";
          $this->connection = Connection::GetInstance();
          $result = $this->connection->Execute($sql);
          foreach ($result as $row){
            $guardian = new Guardian($row["email"],$row["fullname"],$row["dni"],$row["age"],$row["password"],$row['pet_size'],$row['fee'],$row['init_date'],$row['finish_date']);
            $guardian->setId($row["id_guardian"]);
            $guardian->setReputation($row["reputation"]);
            return $guardian;
          }     
        }catch(\PDOException $ex){
          throw $ex;
        }
      }

      public function GetAll(){
        try{
          $sql = "SELECT * FROM ".$this->tableName;
          $this->connection = Connection::GetInstance();
          $result = $this->connection->Execute($sql);
          $guardians = array();
          foreach($result as $row){
            $guardian = new Guardian($row["email"],$row["fullname"],$row["dni"],$row["age"],$row["password"],$row['pet_size'],$row['fee'],$row['init_date'],$row['finish_date']);
            $guardian->setId($row["id_guardian"]);
            $guardian->setReputation($row["reputation"]);
            array_push($guardians, $guardian);
          }
          return $guardians;
        }catch(\PDOException $ex){
          throw $ex;
        }
      }

      public function add($user){
        try{
          $sql = "INSERT INTO ".$this->tableName." (email, fullname, dni, age, password,pet_size,fee,reputation,init_date,finish_date) VALUES (:email, :fullname, :dni, :age, :password,:pet_size,:fee,:reputation,:init_date,:finish_date)";
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
        }catch(\PDOException $ex){
          throw $ex;
        }
      }

      public function update ($user){
        $search = $this->getByEmail($user->getEmail());
        if($search != null){
          try{
            $sql = "UPDATE ".$this->tableName." SET email = :email, fullname = :fullname, dni = :dni, age = :age, password = :password, pet_size = :pet_size, fee = :fee, reputation = :reputation, init_date = :init_date, finish_date = :finish_date WHERE email = :email";
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
          }catch(\PDOException $ex){
            throw $ex;
          }
        }
      }

      public function LoginCheck ($email, $password){
          $user = $this->getByEmail($email);
          if($user != null){
            if($user->getPassword() == $password){
              Session::CreateSession($user);
              Session::SetTypeUser("guardian");
              return true;
            }
          }
    }
      
    public function checkProfile ($guardian){
        if ($guardian->getInitDate() == null){
          return true;
        }
        return false;
   }

    public function getByDate($fechaI, $fechaF){
        $date1 = strtotime($fechaI);
        $date2 = strtotime($fechaF);
        $array = array();
        foreach($this->GetAll() as $guardian){
          $date1guardian = strtotime($guardian->getInitDate());
          $date2guardian = strtotime($guardian->getFinishDate());
          if ($date1guardian >= $date1 && $date2guardian <= $date2){
            array_push($array,$guardian);
          }
        }
        return $array;
    }

    public function updateDisponibility($user, $initDate, $lastDate){
        $search = $this->getByEmail($user);
        if ($search != null){
          $search->setfinishDate($lastDate);
          $search->setinitDate($initDate);
          $this->update($search);
          Session::CreateSession($search);
          return true;
       }
      return false;
    }

    public function updatePassword($id, $password){
      try{
          $sql = "UPDATE ".$this->tableName." SET password = :password WHERE id_guardian = :id_guardian";
          $parameters["id_guardian"] = $id;
          $parameters["password"] = $password;
          $this->connection = Connection::GetInstance();
          $this->connection->ExecuteNonQuery($sql, $parameters);
      }catch(\PDOException $ex){
          throw $ex;
      }
  }
}
?>