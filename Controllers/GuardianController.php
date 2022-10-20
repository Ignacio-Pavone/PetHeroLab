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
    private $authController;

    public function __construct()
    {
        $this->duenioDAO = new duenioDAO();
        $this->guardianDAO = new guardianDAO();
        $this->authController = new AuthController();
    }

    public function registerGuardian($fullname, $age, $dni, $email, $password,$tipoMascota,$remuneracionEsperada)
    {
        $user = new Guardian($email, $fullname, $dni, $age, $password,$tipoMascota,$remuneracionEsperada,$diponibilidad=array());
        if($this->guardianDAO->getGuardianByEmail($email) == null)
        {
            $this->guardianDAO->addGuardian($user);
            $this->authController->showLogin("Guardian registrado con exito");
        }else{
            $this->authController->showLogin("El email ya esta en uso");
        }
    }
}
?>