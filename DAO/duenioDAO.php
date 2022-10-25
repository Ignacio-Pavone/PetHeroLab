<?php
namespace DAO;

use Models\Duenio;
use Models\Mascota;
use Utils\Session;

class duenioDAO{
    private $list = array();
    private $filename;
    private $id;
    private $idmascota;

    public function __construct(){
        $this->filename = dirname(__DIR__)."/Data/duenios.json";
    }
    
    public function findDuenioByID ($id){
        $this->LoadDuenioJson();
        foreach($this->list as $duenio){
            if($duenio->getIdDuenio() == $id){
                return $duenio;
            }
        }
        return null;
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

    public function GetAllDuenios(){
        $this->LoadDuenioJson();
        return $this->list;
    }

    private function LoadDuenioJson(){
        $this->list = array();
        if(file_exists($this->filename)){
            $jsonContent = file_get_contents($this->filename);
            $array = ($jsonContent) ? json_decode($jsonContent, true) : array();         
            foreach($array as $item) {
                $user = new Duenio($item['email'], $item['fullname'], $item['dni'], $item['age'], $item['password']);
                $user->setIdDuenio($item['idDuenio']);    
                array_push($this->list, $user);
                if ($item["idDuenio"] > $this->id) {
                    $this->id = $item["idDuenio"];
                }
            }
        }
    }

    public function saveDuenioJson (){
        $arrayToEncode = array();
        foreach($this->list as $user) {
            $valueArray['idDuenio'] = $user->getIdDuenio();
            $valuesArray['email'] = $user->getEmail();
            $valuesArray['fullname'] = $user->getFullname();
            $valuesArray['dni'] = $user->getDni();
            $valuesArray['age'] = $user->getAge();
            $valuesArray['password'] = $user->getPassword();
            array_push($arrayToEncode, $valuesArray);
        }
        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        file_put_contents($this->filename, $jsonContent);
    }

    public function addDuenio($user){
        $this->LoadDuenioJson();
        $user->setIdDuenio($this->id + 1);
        $user->getMascotas()->setIdMascota($this->idmascota + 1);
        array_push($this->list, $user);
        $this->saveDuenioJson();
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
}