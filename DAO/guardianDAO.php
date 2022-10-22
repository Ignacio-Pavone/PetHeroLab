<?php namespace DAO;

use Utils\Session;

use Models\Guardian;

    class guardianDAO
    {
      private $list = array();
      private $filename;

      public function __construct()
      {
        $this->filename = dirname(__DIR__)."/Data/guardianes.json";
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
      
            array_push($this->list, $user);
          }
        }
      }

      public function addGuardian($user)
      {
        $this->LoadGuardianJson();
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

      public function updateGuardianDiponibility($user, $initDate, $lastDate, $daysToWork){
        $this->LoadGuardianJson();
        $search = $this->getGuardianByEmail($user);
        $search->reiniciarDisponibilidad();
        foreach($daysToWork as $value){
          $search->setDisponibilidad($value);
        }
        $search->setfinishDate($lastDate);
        $search->setinitDate($initDate);
        $this->updateUser($search);
        $this->saveGuardianJson();
        Session::CreateSession($search);

      }
    }
?>