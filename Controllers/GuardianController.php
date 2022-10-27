<?php
namespace Controllers;
use Models\Guardian as Guardian;
use DAO\guardianDAO as guardianDAO;
use Utils\Session;

class GuardianController{

    private $guardianDAO;

    public function __construct(){
        $this->guardianDAO = new guardianDAO();
    }

    public function register($fullname, $age, $dni, $email, $password, $tipoMascota, $fee){
        $user = new Guardian($email, $fullname, $dni, $age, $password,$tipoMascota,$fee,$initDate=null,$finishDate=null);
        if($this->guardianDAO->getByEmail($email) == null){
            $this->guardianDAO->add($user);
            Session::SetOkMessage("Guardian registrado con exito");
        }else{
            Session::SetBadMessage("El email ya esta en uso");
        }
        header ("location: ".FRONT_ROOT."Auth/showLogin");
    }


    public function showdisponibilityView ($guardianEmail){
        $guardian = $this->guardianDAO->getByEmail($guardianEmail);
        header ("location: ".FRONT_ROOT."Auth/showGuardianProfile/" . $guardianEmail);
    }

    public function ModifyAvailability($guardianEmail,$initDate, $finishDate){
         if ($this->guardianDAO->updateDisponibility ($guardianEmail,$initDate, $finishDate)){
            Session::SetOkMessage("Guardian modificado con exito");
        }else{
            Session::SetBadMessage("Hubo algun problema");
        }
        header ("location: ".FRONT_ROOT."Auth/showGuardianProfile/" . $guardianEmail);
    }



}
?>