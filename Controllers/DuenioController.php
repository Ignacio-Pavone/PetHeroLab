<?php
namespace Controllers;

use DAO\duenioDAO as duenioDAO;
use DAO\guardianDAO as guardianDAO;
use Models\Duenio as Duenio;
use Models\Mascota as Mascota;
use Utils\Session;

class DuenioController{
    private $duenioDAO;
    private $guardianDAO;

    public function __construct()
    {
        $this->duenioDAO = new duenioDAO();
        $this->guardianDAO = new guardianDAO();
    }

    public function addPet($nombre,$raza,$tamanio,$foto,$planVacunacion,$video){
        $user = Session::GetLoggedUser();
        $mascota = new Mascota($nombre,$raza,$tamanio,$foto,$planVacunacion,$video);
        $this->duenioDAO->addMascota($user->getEmail(),$mascota);
    }

    public function deletePet ($petName){
        $user = Session::GetLoggedUser();
        $this->duenioDAO->deleteMascota($user,$petName);
        require_once(VIEWS_PATH."duenio-profile.php");
    }
    
}
