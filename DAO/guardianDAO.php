<?php namespace DAO;

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
            $user = new Guardian($item['email'], $item['fullname'], $item['dni'], $item['age'], $item['password'], $item['tipoMascota'], $item['remuneracionEsperada']);
            foreach ($item['disponibilidad'] as $key => $value) {
              $user->setDisponibilidad($value);
            }
            
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


        public function saveGuardianJson (){
            $arrayToEncode = array();
            
            foreach($this->list as $user) {
            $valuesArray['email'] = $user->getEmail();
            $valuesArray['fullname'] = $user->getFullName();
            $valuesArray['dni'] = $user->getDni();
            $valuesArray['age'] = $user->getAge();
            $valuesArray['password'] = $user->getPassword();
            $valuesArray['tipoMascota'] = $user->getTipoMascota();
            $dias = array();
            foreach($user->getDisponibilidad() as $dia){
              array_push($dias,$dia);
            }
            $valuesArray['disponibilidad'] = $dias;
            $valuesArray['reputacion'] = $user->getReputacion();
            $valuesArray['remuneracionEsperada'] = $user->getRemuneracionEsperada();
            array_push($arrayToEncode, $valuesArray);
            }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            file_put_contents($this->filename, $jsonContent);
        }
        
        public function modifyUser($email= null, $fullname= null, $dni= null, $age= null, $password= null, $tipoMascota= null, $remuneracionEsperada= null, $disponibilidad= null, $reputacion= null){
            $this->LoadGuardianJson();
            foreach($this->list as $user){
              if ($user->getEmail() == $email){
                if ($fullname != null)
                  $user->setFullName($fullname);
                if ($dni != null)
                  $user->setDni($dni);
                if ($age != null)
                  $user->setAge($age);
                if ($password != null)
                  $user->setPassword($password);
                if ($tipoMascota != null)
                  $user->setTipoMascota($tipoMascota);
                if ($remuneracionEsperada != null)
                  $user->setRemuneracionEsperada($remuneracionEsperada);
                if ($disponibilidad != null)
                  $user->setDisponibilidad($disponibilidad);
                if ($reputacion != null)
                  $user->setReputacion($reputacion);
              }
            }
            $this->saveGuardianJson();

        }
      }

  
    


?>