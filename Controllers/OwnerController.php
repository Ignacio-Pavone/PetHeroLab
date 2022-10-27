<?php
namespace Controllers;

use DAO\OwnerDAO as OwnerDAO;
use Models\Owner as Owner;
use Utils\Session;

class OwnerController{
    private $ownerDAO;


    public function __construct(){
        $this->ownerDAO = new OwnerDAO();
    }
 
    public function register($fullname, $age, $dni, $email, $password){
        $user = new Owner($email, $fullname, $dni, $age, $password);
        if($this->ownerDAO->getByEmail($email) == null){
            $this->ownerDAO->add($user);
            Session::SetOkMessage("Owner registrado con exito");
        }else{
            Session::SetBadMessage("El email ya esta en uso");
        }
       header ("location: ".FRONT_ROOT."Auth/showLogin");
    }

}
