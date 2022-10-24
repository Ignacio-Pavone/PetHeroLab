<?php
namespace Controllers;

use DAO\duenioDAO as duenioDAO;
use DAO\guardianDAO as guardianDAO;
use Models\Duenio as Duenio;
use Models\Mascota as Mascota;
use Utils\Session;

class DuenioController{
    private $duenioDAO;


    public function __construct(){
        $this->duenioDAO = new duenioDAO();
    }
 
    public function registerDuenio($fullname, $age, $dni, $email, $password){
        $user = new Duenio($email, $fullname, $dni, $age, $password);
        if($this->duenioDAO->getDuenioByEmail($email) == null)
        {
            $this->duenioDAO->addDuenio($user);
            Session::SetOkMessage("Duenio registrado con exito");
        }else{
            Session::SetBadMessage("El email ya esta en uso");
        }
        header ("location: ".FRONT_ROOT."Auth/showLogin");
    }

}
