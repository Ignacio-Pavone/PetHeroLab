<?php
namespace DAO;

use Models\Duenio;
use Models\Mascota;
use Utils\Session;

class duenioDAO{
    private $list = array();
    private $filename;

    public function __construct()
    {
        $this->filename = dirname(__DIR__)."/Data/duenios.json";
    }

    public function getDuenioByEmail($email){
        $this->LoadDuenioJson();
        $userAuth=null;
        foreach($this->list as $user){
            if ($user->getEmail() == $email)
                $userAuth=$user;
        }
        return $userAuth;
    }

    public function GetAllDuenios()
    {
        $this->LoadDuenioJson();
        return $this->list;
    }

    private function LoadDuenioJson() 
    {
        $this->list = array();
        $arraypets = array();
        if(file_exists($this->filename)) 
        {
            $jsonContent = file_get_contents($this->filename);
            $array = ($jsonContent) ? json_decode($jsonContent, true) : array();
            
            foreach($array as $item) 
            {
                $user = new Duenio($item['email'], $item['fullname'], $item['dni'], $item['age'], $item['password']);
                foreach ($item['mascotas'] as $mascota) {
                    $mascota = new Mascota($mascota['nombre'], $mascota['raza'], $mascota['tamanio'], $mascota['foto'], $mascota['planVacunacion'], $mascota['video']);
                    $user->addMascota($mascota);
                }            
                array_push($this->list, $user);
            }
        }
    }

    public function saveDuenioJson (){
        $arrayToEncode = array();
       
        
        foreach($this->list as $user) {
            $valuesArray['email'] = $user->getEmail();
            $valuesArray['fullname'] = $user->getFullname();
            $valuesArray['dni'] = $user->getDni();
            $valuesArray['age'] = $user->getAge();
            $valuesArray['password'] = $user->getPassword();
            $mascotasArray = array();
            foreach ($user->getMascotas() as $mascota) {
                $mascotas['nombre'] = $mascota->getNombre();
                $mascotas['raza'] = $mascota->getRaza();
                $mascotas['tamanio'] = $mascota->getTamanio();
                $mascotas['foto'] = $mascota->getFoto();
                $mascotas['planVacunacion'] = $mascota->getPlanVacunacion();
                $mascotas['video'] = $mascota->getVideo();
                array_push($mascotasArray, $mascotas);
            }
        
            $valuesArray['mascotas'] = $mascotasArray;
            array_push($arrayToEncode, $valuesArray);
        }
        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        file_put_contents($this->filename, $jsonContent);
    }

    public function addDuenio($user)
    {
        $this->LoadDuenioJson();
        array_push($this->list, $user);
        $this->saveDuenioJson();
    }

    public function addMascota($email, $mascota){
        $user = $this->getDuenioByEmail($email);
        if ($user != null){
            $user->addMascota($mascota);
            $this->saveDuenioJson();
        }
        Session::CreateSession($user);
    }

    public function searchPetByName ($name){
        $this->LoadDuenioJson();
        $pet = null;
        foreach($this->list as $user){
            foreach ($user->getMascotas() as $mascota) {
                if ($mascota->getNombre() == $name){
                    $pet = $mascota;
            }
        }
        return $pet;
        }
    }


    public function deleteMascota ($user,$nombre){
        $this->LoadDuenioJson();
        $userSearch = $this->getDuenioByEmail($user->getEmail());
        $petSearch = $this->searchPetByName($nombre);
        if ($userSearch!=null && $petSearch!=null){
            $nuevousuario = $this->deletePetbyName($userSearch,$petSearch);
            Session::CreateSession($nuevousuario);
            $this->saveDuenioJson();
        }else{
            
        }
       
    }

    public function deletePetbyName ($user,$mascota){
        $newarraPets = array();
        $flag = 0;
        foreach($this->list as $usersfromList){
            if ($usersfromList->getEmail() == $user->getEmail() && $flag == 0){
                foreach ($usersfromList->getMascotas() as $pet) {
                    if ($pet->getNombre() != $mascota->getNombre()){
                        array_push($newarraPets, $pet);
                    }
                }
                $usersfromList->setMascotas($newarraPets);
                return $usersfromList;
            }
        }
       
    }

    public function devolverTodaslasMascotas (){
        $this->LoadDuenioJson();
        $mascotas = array();
        foreach($this->list as $user){
            foreach ($user->getMascotas() as $mascota) {
                array_push($mascotas, $mascota);
            }
        }
        return $mascotas;
    }

    public function filtrarMascotasporTamanio($tamanio){
        $this->LoadDuenioJson();
        $mascotas = array();
        $todaslasmascotas = $this->devolverTodaslasMascotas();
        foreach ($todaslasmascotas as $mascota) {
            if (strtolower($mascota->getTamanio()) == strtolower($tamanio)){
                array_push($mascotas, $mascota);
            }
        }
        return $mascotas;
    }

    public function LoginCheckDuenio ($email, $password){
        $user = $this->getDuenioByEmail($email);
        if($user != null && $user->getPassword() == $password){
            Session::CreateSession($user);
            Session::SetTypeUser("duenio");
            return true;
        } 
        return false;
    }

    public function updateMascota ($user=NULL,$mascota=NULL,$nuevamascota=NULL){
        if ($user != NULL && $mascota != NULL && $nuevamascota != NULL){
            $this->LoadDuenioJson();
            $userSearch = $this->getDuenioByEmail($user->getEmail());
            $petSearch = $this->searchPetByName($mascota->getNombre());
            if ($userSearch!=null){
               $usernew= $this->updatePetbyName($userSearch,$petSearch,$nuevamascota);
               $this->saveDuenioJson();
               Session::CreateSession($usernew);
            }
        }
    }

    public function updatePetbyName ($userSearch,$petSearch,$search){
        $newarraPets = array();
        $flag = 0;
        foreach($this->list as $usersfromList){
            if ($usersfromList->getEmail() == $userSearch->getEmail() && $flag == 0){
                foreach ($usersfromList->getMascotas() as $pet) {
                    if ($pet->getNombre() == $petSearch->getNombre()){
                        $pet->setNombre($search->getNombre());
                        $pet->setRaza($search->getRaza());
                        $pet->setTamanio($search->getTamanio());
                        $pet->setFoto($search->getFoto());
                        $pet->setPlanVacunacion($search->getPlanVacunacion());
                        $pet->setVideo($search->getVideo());
                        $flag = 1;
                    }
                    array_push($newarraPets, $pet);
                }
                $usersfromList->setMascotas($newarraPets);
                return $usersfromList;
            }
        }
    }



    
}