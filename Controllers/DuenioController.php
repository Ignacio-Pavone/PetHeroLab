<?php
namespace Controllers;

use DAO\duenioDAO as duenioDAO;
use Models\Duenio as Duenio;
use Models\Mascota as Mascota;

class DuenioController{
    private $duenioDAO;

    public function __construct()
    {
        $this->duenioDAO = new duenioDAO();
    }

    public function addPet($nombre,$raza,$tamanio,$foto,$planVacunacion,$video){
        $user = $_SESSION['loggedUser'];
        $mascota = new Mascota($nombre,$raza,$tamanio,$foto,$planVacunacion,$video);
        $this->duenioDAO->addMascota($user->getEmail(),$mascota);
    }
    
}
