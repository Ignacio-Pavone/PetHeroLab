<?php
namespace Controllers;
use Models\Guardian as Guardian;
use DAO\duenioDAO as duenioDAO;
use DAO\guardianDAO as guardianDAO;
use Models\Duenio as Duenio;
use Models\Mascota as Mascota;
use Utils\Session;

class GuardianController{

    private $duenioDAO;
    private $guardianDAO;

    public function __construct()
    {
        $this->duenioDAO = new duenioDAO();
        $this->guardianDAO = new guardianDAO();
    }

    public function registerGuardian($fullname, $age, $dni, $email, $password,$tipoMascota,$remuneracionEsperada)
    {
        $user = new Guardian($email, $fullname, $dni, $age, $password,$tipoMascota,$remuneracionEsperada);
        if($this->guardianDAO->getGuardianByEmail($email) == null)
        {
            $this->guardianDAO->addGuardian($user);
            require_once(VIEWS_PATH."login.php");
        }
    }
}
?>