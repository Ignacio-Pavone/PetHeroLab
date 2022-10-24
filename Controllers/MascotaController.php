<?php
namespace Controllers;

use DAO\duenioDAO as duenioDAO;
use DAO\guardianDAO as guardianDAO;
use DAO\mascotaDAO as mascotaDAO;
use Models\Mascota as Mascota;
use Models\Duenio as Duenio;

use Utils\Session;


class MascotaController {
    private $mascotaDAO;

    public function __construct(){
        $this->mascotaDAO = new mascotaDAO();
    }

    public function addPet($idDuenio,$nombre,$tipo,$raza,$tamanio,$foto,$planVacunacion,$video){
        $string = str_replace(' ', '_', $nombre);
        $user = Session::GetLoggedUser();
        $mascota = new Mascota($idDuenio,$string,$tipo,$raza,$tamanio,$foto,$planVacunacion,$video);
        $this->mascotaDAO->addMascota($mascota);
        header ("location: ".FRONT_ROOT."Auth/ShowDuenioProfile");
    }

    public function deletePet ($id){
        $user = Session::GetLoggedUser();
        if ($id!=null){
            $this->mascotaDAO->deleteMascota($id);
            Session::SetOkMessage("Mascota eliminada con exito");
        }
        $id=null;
        header ("location: ".FRONT_ROOT."Auth/ShowDuenioProfile");
    }

    public function UpdatePet ($id){
        $user = Session::GetLoggedUser();
        $search = $this->mascotaDAO->findMascotaByID($id);
        require_once(VIEWS_PATH."update-mascota.php");
    }

    public function ModifyPet ($idDuenio,$idMascota,$nombre,$tipo,$raza,$tamanio,$foto,$planVacunacion,$video){
        $user = Session::GetLoggedUser();
        $string = str_replace(' ', '_', $nombre);
        $nuevamascota = new Mascota($idDuenio,$string,$tipo,$raza,$tamanio,$foto,$planVacunacion,$video);
        $nuevamascota->setIdMascota($idMascota);
        
        if($this->mascotaDAO->updateMascota($nuevamascota)){
            Session::SetOkMessage("Mascota modificada con exito");
        }else{
            Session::SetBadMessage("No se pudo modificar la mascota");
        }
        header ("location: ".FRONT_ROOT."Auth/ShowDuenioProfile");
    }

}