<?php
namespace Controllers;
use Models\Guardian as Guardian;
use DAO\duenioDAO as duenioDAO;
use DAO\guardianDAO as guardianDAO;
use Utils\Session;

class GuardianController{

    private $guardianDAO;

    public function __construct(){
        $this->guardianDAO = new guardianDAO();
    }

    public function registerGuardian($fullname, $age, $dni, $email, $password,$tipoMascota,$remuneracionEsperada){
        $user = new Guardian($email, $fullname, $dni, $age, $password,$tipoMascota,$remuneracionEsperada,$initDate=null,$finishDate=null);
        var_dump($user);
        if($this->guardianDAO->getGuardianByEmail($email) == null){
            $this->guardianDAO->addGuardian($user);
            Session::SetOkMessage("Guardian registrado con exito");
        }else{
            Session::SetBadMessage("El email ya esta en uso");
        }
        header ("location: ".FRONT_ROOT."Auth/showLogin");
    }


    public function showdisponibilityView ($guardianEmail){
        $guardian = $this->guardianDAO->getGuardianByEmail($guardianEmail);
        header ("location: ".FRONT_ROOT."Auth/showGuardianProfile/" . $guardianEmail);
    }

    public function ModifyAvailability($guardianEmail,$initDate, $finishDate){    
         if ($this->guardianDAO->updateGuardianDiponibility ($guardianEmail,$initDate, $finishDate)){
            Session::SetOkMessage("Guardian modificado con exito");
        }else{
            Session::SetBadMessage("Hubo algun problema");
        }
        header ("location: ".FRONT_ROOT."Auth/showGuardianProfile/" . $guardianEmail);
    }



}
?>