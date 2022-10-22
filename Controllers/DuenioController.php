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

    public function __construct(){
        $this->duenioDAO = new duenioDAO();
        $this->guardianDAO = new guardianDAO();
        $this->authController = new AuthController();
    }

    public function addPet($nombre,$tipo,$raza,$tamanio,$foto,$planVacunacion,$video){
        $string = str_replace(' ', '_', $nombre);
        $user = Session::GetLoggedUser();
        $mascota = new Mascota($string,$tipo,$raza,$tamanio,$foto,$planVacunacion,$video);
        $this->duenioDAO->addMascota($user->getEmail(),$mascota);
        header ("location: ".FRONT_ROOT."Auth/ShowDuenioProfile");
    }

    public function deletePet ($petName){
        $user = Session::GetLoggedUser();
        if ($petName!=null){
            $this->duenioDAO->deleteMascota($user,$petName);
            Session::SetOkMessage("Mascota eliminada con exito");
        }
        $petName=null;
        header ("location: ".FRONT_ROOT."Auth/ShowDuenioProfile");
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

    public function UpdatePet ($nombre){
        $user = Session::GetLoggedUser();
        $search = $this->duenioDAO->searchPetByName($nombre);
        require_once(VIEWS_PATH."update-mascota.php");
    }

    public function ModifyPet ($nombreviejo,$nombre,$tipo,$raza,$tamanio,$foto,$planVacunacion,$video){
        $user = Session::GetLoggedUser();
        $viejamascota = $this->duenioDAO->searchPetByName($nombreviejo);
        $string = str_replace(' ', '_', $nombre);
        $nuevamascota = new Mascota($string,$tipo,$raza,$tamanio,$foto,$planVacunacion,$video);
        if($this->duenioDAO->updateMascota($user,$viejamascota,$nuevamascota)){
            Session::SetOkMessage("Mascota modificada con exito");
        }else{
            Session::SetBadMessage("No se pudo modificar la mascota");
        }
        header ("location: ".FRONT_ROOT."Auth/ShowDuenioProfile");
    }

}
