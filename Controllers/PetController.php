<?php
namespace Controllers;

use DAO\PetDAO as PetDAO;
use Models\Pet as Pet;
use Utils\Session;


class PetController {
    private $mascotaDAO;

    public function __construct(){
        $this->mascotaDAO = new PetDAO();
    }

    public function add($id_owner, $name, $type, $breed, $pet_size, $photo_url, $vaccination_schedule, $video_url){
        $string = str_replace(' ', '_', $name);
        $user = Session::GetLoggedUser();
        $mascota = new Pet($id_owner,$string,$type,$breed,$pet_size,$photo_url,$vaccination_schedule,$video_url);
        $this->mascotaDAO->add($mascota);
        header ("location: ".FRONT_ROOT."Auth/showOwnerProfile");
    }

    public function delete ($id){
        $user = Session::GetLoggedUser();
        if ($id!=null){
            $this->mascotaDAO->delete($id);
            Session::SetOkMessage("Pet eliminada con exito");
        }
        $id=null;
        header ("location: ".FRONT_ROOT."Auth/showOwnerProfile");
    }

    public function update ($id){
        $user = Session::GetLoggedUser();
        $search = $this->mascotaDAO->findByID($id);
        require_once(VIEWS_PATH."update-mascota.php");
    }

    public function modify ($id_owner, $id, $name, $type, $breed, $pet_size, $photo_url, $vaccination_schedule, $video_url){
        $user = Session::GetLoggedUser();
        $string = str_replace(' ', '_', $name);
        $nuevamascota = new Pet($id_owner,$string,$type,$breed,$pet_size,$photo_url,$vaccination_schedule,$video_url);
        $nuevamascota->setId($id);
    
        if($this->mascotaDAO->update($nuevamascota)){
            Session::SetOkMessage("Pet modificada con exito");
        }else{
            Session::SetBadMessage("No se pudo modificar la mascota");
        }
        header ("location: ".FRONT_ROOT."Auth/showOwnerProfile");
    }

}