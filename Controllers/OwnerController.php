<?php
namespace Controllers;
use DAO\OwnerDAO as OwnerDAO;
use Models\Owner as Owner;
use Utils\Session;

class OwnerController
{
    private $ownerDAO;

    public function __construct()
    {
        $this->ownerDAO = new OwnerDAO();
    }

    public function register($fullname, $age, $dni, $email, $password)
    {
        $user = new Owner($email, $fullname, $dni, $age, $password);
        try {
            if (!$this->ownerDAO->emailExistBoth($email) && !$this->ownerDAO->dniExistboth($dni)) {
                $this->ownerDAO->add($user);
                Session::SetOkMessage("Owner registrado con exito");
            } else {
                Session::SetBadMessage("El email o dni ya esta en uso");
            }
        } catch (\Exception $e) {
            Session::SetBadMessage("Hubo algun problema con la conexion a la base de datos");
        }
        header("location: " . FRONT_ROOT . "Auth/showLogin");
    }

    public function showChangePassword()
    {
        require_once(VIEWS_PATH . "password/change-password.php");
    }

    public function changePassword($userID, $oldPassword, $newPassword, $newPassword2)
    {
        try {
            $user = $this->ownerDAO->findbyID($userID);
        } catch (\Exception $e) {
            Session::SetBadMessage("Hubo algun problema con la conexion a la base de datos");
        }

        if ($oldPassword == $user->getPassword()) {
            if ($newPassword == $newPassword2) {
                try {
                    $this->ownerDAO->updatePassword($userID, $newPassword);
                } catch (\Exception $e) {
                    Session::SetBadMessage("Hubo algun problema con la conexion a la base de datos");
                }
                Session::SetOkMessage("Contraseña actualizada con exito.");
                Session::DeleteSession();
            } else {
                Session::SetBadMessage("Contraseña nueva no concuerda.");
                $this->showChangePassword();
            }
        } else {
            Session::SetBadMessage("Verificar su antigua contraseña.");
            $this->showChangePassword();
        }
    }

    public function showAddPet(){
        require_once(VIEWS_PATH . "owner/add-pet.php");
    }
}
?>
