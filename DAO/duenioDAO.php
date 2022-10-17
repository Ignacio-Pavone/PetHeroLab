<?php
namespace DAO;

use Models\Duenio;
use Models\Mascota;

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
        $mascotasArray = array();
        
        foreach($this->list as $user) {
            $valuesArray['email'] = $user->getEmail();
            $valuesArray['fullname'] = $user->getFullname();
            $valuesArray['dni'] = $user->getDni();
            $valuesArray['age'] = $user->getAge();
            $valuesArray['password'] = $user->getPassword();
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
    }
    

}