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
    private $authController;

    public function __construct()
    {
        $this->duenioDAO = new duenioDAO();
        $this->guardianDAO = new guardianDAO();
        $this->authController = new AuthController();
    }

    public function addPet($nombre,$raza,$tamanio,$foto,$planVacunacion,$video){
        $string = str_replace(' ', '_', $nombre);
        $user = Session::GetLoggedUser();
        $mascota = new Mascota($string,$raza,$tamanio,$foto,$planVacunacion,$video);
        $this->duenioDAO->addMascota($user->getEmail(),$mascota);
        require_once(VIEWS_PATH."duenio-profile.php");
    }

    public function deletePet ($petName){
        $user = Session::GetLoggedUser();
        $this->duenioDAO->deleteMascota($user,$petName);
        require_once(VIEWS_PATH."duenio-profile.php");
    }

    public function registerDuenio($fullname, $age, $dni, $email, $password){
        $user = new Duenio($email, $fullname, $dni, $age, $password);
        if($this->duenioDAO->getDuenioByEmail($email) == null)
        {
            $this->duenioDAO->addDuenio($user);
            $this->authController->showLogin("Duenio registrado con exito");
        }else{
            $this->authController->showLogin("El email ya esta en uso");
        }
    }

    public function UpdatePet ($nombre){
        $user = Session::GetLoggedUser();
        $search = $this->duenioDAO->searchPetByName($nombre);
        require_once(VIEWS_PATH."update-mascota.php");
    }

    public function ModifyPet ($nombreviejo,$nombre,$raza,$tamanio,$foto,$planVacunacion,$video){
        $user = Session::GetLoggedUser();
        $viejamascota = $this->duenioDAO->searchPetByName($nombreviejo);
        $string = str_replace(' ', '_', $nombre);
        $nuevamascota = new Mascota($string,$raza,$tamanio,$foto,$planVacunacion,$video);
        $this->duenioDAO->updateMascota($user,$viejamascota,$nuevamascota);
        require_once(VIEWS_PATH."duenio-profile.php");
    }

}
