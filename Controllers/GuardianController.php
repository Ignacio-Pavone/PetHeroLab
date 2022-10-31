<?php
namespace Controllers;
use Models\Guardian as Guardian;
use DAO\GuardianDAO as GuardianDAO;
use Utils\Session;

class GuardianController
{
    private $guardianDAO;

    public function __construct()
    {
        $this->guardianDAO = new GuardianDAO();
    }

    public function register($fullname, $age, $dni, $email, $password, $tipoMascota, $fee)
    {
        $user = new Guardian($email, $fullname, $dni, $age, $password, $tipoMascota, $fee, $initDate = null, $finishDate = null);
        if (!$this->guardianDAO->emailExistBoth($email) && !$this->guardianDAO->dniExistboth($dni)) {
            $this->guardianDAO->add($user);
            Session::SetOkMessage("Guardian registrado con exito");
        } else {
            Session::SetBadMessage("El email o dni ya esta en uso");
        }
        header("location: " . FRONT_ROOT . "Auth/showLogin");
    }


    public function showdisponibilityView($guardianEmail)
    {
        $guardian = $this->guardianDAO->getByEmail($guardianEmail);
        header("location: " . FRONT_ROOT . "Auth/showGuardianProfile/" . $guardianEmail);
    }

    public function ModifyAvailability($guardianEmail, $initDate, $finishDate)
    {
        if ($initDate < $finishDate) {
            if ($this->guardianDAO->updateDisponibility($guardianEmail, $initDate, $finishDate)) {
                Session::SetOkMessage("Guardian modificado con exito");
            } else {
                Session::SetBadMessage("Hubo algun problema");
            }
        } else {
            Session::SetBadMessage("La fecha de inicio debe ser menor a la fecha de fin");
        }
        header("location: " . FRONT_ROOT . "Auth/showGuardianProfile/" . $guardianEmail);

    }

    public function showChangePassword()
    {
        require_once(VIEWS_PATH . "password/change-password.php");
    }

    public function changePassword($userID, $oldPassword, $newPassword, $newPassword2)
    {
        $user = $this->guardianDAO->findbyID($userID);

        if ($oldPassword == $user->getPassword()) {
            if ($newPassword == $newPassword2) {
                $this->guardianDAO->updatePassword($userID, $newPassword);
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
}
?>