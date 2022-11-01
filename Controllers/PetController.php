<?php
namespace Controllers;
use DAO\PetDAO as PetDAO;
use DAO\RequestDAO as RequestDAO;
use Models\Pet as Pet;
use Utils\Session;
class PetController
{
    private $mascotaDAO;

    public function __construct()
    {
        $this->mascotaDAO = new PetDAO();
        $this->requestDAO = new RequestDAO();
    }

    public function add($id_owner, $name, $type, $breed, $pet_size, $photo_url, $vaccination_schedule, $video_url)
    {
        $string = str_replace(' ', '_', $name);
        $user = Session::GetLoggedUser();
        $mascota = new Pet($id_owner, $string, $type, $breed, $pet_size, $photo_url, $vaccination_schedule, $video_url);
        $this->mascotaDAO->add($mascota);
        header("location: " . FRONT_ROOT . "Auth/showOwnerProfile");
    }

    public function delete($id)
    {
        $user = Session::GetLoggedUser();
        if ($id != null){
        if (!($this->requestDAO->checkRequestsPet($id))){
            $this->mascotaDAO->delete($id);
            Session::SetOkMessage("Mascota eliminada con exito");
        }else{
            Session::SetBadMessage("Mascota posee reservas realizadas, cancelarlas antes de eliminarla.");
        }
        $id = null;
        header("location: " . FRONT_ROOT . "Auth/showOwnerProfile"); 
        }
    }

    public function update($id)
    {
        $user = Session::GetLoggedUser();
        $search = $this->mascotaDAO->findByID($id);
        require_once(VIEWS_PATH . "owner/update-pet.php");
    }

    public function modify($id_owner, $id, $name, $type, $breed, $pet_size, $photo_url, $vaccination_schedule, $video_url)
    {
        $user = Session::GetLoggedUser();
        $string = str_replace(' ', '_', $name);
        $nuevamascota = new Pet($id_owner, $string, $type, $breed, $pet_size, $photo_url, $vaccination_schedule, $video_url);
        $nuevamascota->setId($id);

        if ($this->mascotaDAO->update($nuevamascota)) {
            Session::SetOkMessage("Mascota modificada con exito");
        } else {
            Session::SetBadMessage("No se pudo modificar la mascota");
        }
        header("location: " . FRONT_ROOT . "Auth/showOwnerProfile");
    }
}
?>