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
        try {
            if (!$this->guardianDAO->emailExistBoth($email) && !$this->guardianDAO->dniExistboth($dni)) {
                $this->guardianDAO->add($user);
                Session::SetOkMessage("Guardian registrado con exito");
            } else {
                Session::SetBadMessage("El email o dni ya esta en uso");
            }
        } catch (\Exception $e) {
            Session::SetBadMessage("Error en la base de datos.");
        }
        header("location: " . FRONT_ROOT . "Auth/showLogin");
    }

    public function showdisponibilityView($guardianEmail)
    {
        try {
            $guardian = $this->guardianDAO->getByEmail($guardianEmail);
        } catch (\Exception $e) {
            Session::SetBadMessage("Hubo algun problema con la conexion a la base de datos");
        }
        header("location: " . FRONT_ROOT . "Auth/showGuardianProfile/" . $guardianEmail);
    }

    public function ModifyAvailability($guardianEmail, $initDate, $finishDate)
    {
        if ($initDate < $finishDate) {
            try {
                if ($this->guardianDAO->updateDisponibility($guardianEmail, $initDate, $finishDate)) {
                    Session::SetOkMessage("Disponibilidad actualizada con exito");
                } else {
                    Session::SetBadMessage("Hubo algun problema");
                }
            } catch (\Exception $e) {
                Session::SetBadMessage("Hubo algun problema con la conexion a la base de datos");
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
        try {
            $user = $this->guardianDAO->findbyID($userID);
        } catch (\Exception $e) {
            Session::SetBadMessage("Hubo algun problema con la conexion a la base de datos");
        }
        if ($oldPassword == $user->getPassword()) {
            if ($newPassword == $newPassword2) {
                try {
                    $this->guardianDAO->updatePassword($userID, $newPassword);
                } catch (\Exception $e) {
                    Session::SetBadMessage("Hubo algun problema con la conexion a la base de datos");
                }
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