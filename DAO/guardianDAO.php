<?php namespace DAO;

use Utils\Session;

use Models\Guardian;

    class guardianDAO
    {
      private $list = array();
      private $filename;
      private $id;

      public function __construct()
      {
        $this->filename = dirname(__DIR__)."/Data/guardianes.json";
      }

      public function findGuardianByID ($id){
        $this->LoadGuardianJson();
        foreach($this->list as $guardian){
          if($guardian->getIdGuardian() == $id){
            return $guardian;
          }
        }
        return null;
      }

      public function getGuardianByEmail($email){
        $this->LoadGuardianJson();
        $userAuth=null;
        foreach($this->list as $user){
          if ($user->getEmail() == $email)
            $userAuth=$user;
        }
        return $userAuth;
      }

      public function GetAllGuardians()
      {
        $this->LoadGuardianJson();
        return $this->list;
      }

      private function LoadGuardianJson() 
      {
        $this->list = array();
        if(file_exists($this->filename)) 
        {
          $jsonContent = file_get_contents($this->filename);
          $array = ($jsonContent) ? json_decode($jsonContent, true) : array();
          foreach($array as $item) 
          {
            $user = new Guardian($item['email'], $item['fullname'], $item['dni'], $item['age'], $item['password'], $item['tipoMascota'], $item['remuneracionEsperada'],$item['disponibilidad'],$item['initDate'],$item['finishDate']);
            $user->setReputacion($item['reputacion']);
            $user->setIdGuardian($item['idGuardian']);
            array_push($this->list, $user);

            if ($item["idGuardian"] > $this->id) {
              $this->id = $item["idGuardian"];
          }
          }
        }
      }

      public function addGuardian($user)
      {
        $this->LoadGuardianJson();
        $user->setIdGuardian($this->id + 1);
        array_push($this->list, $user);
        $this->saveGuardianJson();
      }

      public function updateUser ($user){
        $this->LoadGuardianJson();
        $search = $this->getGuardianByEmail($user->getEmail());
        if($search != null){
          $search->setFullname($user->getFullname());
          $search->setDni($user->getDni());
          $search->setAge($user->getAge());
          $search->setPassword($user->getPassword());
          $search->setTipoMascota($user->getTipoMascota());
          $search->setRemuneracionEsperada($user->getRemuneracionEsperada());
          $search->setReputacion($user->getReputacion());
          $search->reiniciarDisponibilidad();
          foreach ($user->getDisponibilidad() as $dia) {
            $search->setDisponibilidad($dia);
          }
          $search->setInitDate($user->getInitDate());
          $search->setFinishDate($user->getFinishDate());
          
          $this->saveGuardianJson();
        }
      }


        public function saveGuardianJson (){
            $arrayToEncode = array();
            
            foreach($this->list as $user) {
            $valuesArray["idGuardian"] = $user->getIdGuardian();
            $valuesArray['email'] = $user->getEmail();
            $valuesArray['fullname'] = $user->getFullName();
            $valuesArray['dni'] = $user->getDni();
            $valuesArray['age'] = $user->getAge();
            $valuesArray['password'] = $user->getPassword();
            $valuesArray['tipoMascota'] = $user->getTipoMascota();
            $valuesArray['disponibilidad'] = $user->getDisponibilidad();
            $valuesArray['reputacion'] = $user->getReputacion();
            $valuesArray['remuneracionEsperada'] = $user->getRemuneracionEsperada();
            $valuesArray['initDate'] = $user->getInitDate();
            $valuesArray['finishDate'] = $user->getFinishDate();
            array_push($arrayToEncode, $valuesArray);
            }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            file_put_contents($this->filename, $jsonContent);
        }
        
        public function modifyDispobibilidad($user){
          $this->LoadGuardianJson();
          $search = $this->getGuardianByEmail($user->getEmail());
          $search->reiniciarDisponibilidad();
          foreach($search->getDisponibilidad() as $value){
            $user->setDisponibilidad($value);
          }
          $this->updateUser($user);
          $this->saveGuardianJson();
        }

        public function LoginCheckGuardian ($email,$password){
          $user = $this->getGuardianByEmail($email);
          if($user != null && $user->getPassword() == $password){
              Session::CreateSession($user);
              Session::SetTypeUser("guardian");
              return true;
          }
          return false;
      }

      public function updateGuardianDiponibility($user, $initDate, $lastDate){
        $this->LoadGuardianJson();
        $search = $this->getGuardianByEmail($user);
        if ($search != null){
          $search->reiniciarDisponibilidad();
          $search->setfinishDate($lastDate);
          $search->setinitDate($initDate);
          $this->updateUser($search);
          $this->saveGuardianJson();
          Session::CreateSession($search);
          return true;
        }
        return false;

      }

      public function getGuardiansByDate($fechaI,$fechaF){
        $this->LoadGuardianJson();
        $date1 = strtotime($fechaI);
        $date2 = strtotime($fechaF);

        $array = array();
        foreach($this->list as $guardian){
          $date1guardian = strtotime($guardian->getInitDate());
          $date2guardian = strtotime($guardian->getFinishDate());
          if ($date1guardian >= $date1 && $date2guardian <= $date2){

            array_push($array,$guardian);
          }
        }
        return $array;
      }
    }
?>