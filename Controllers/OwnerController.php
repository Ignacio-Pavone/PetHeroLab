<?php
namespace Controllers;

use DAO\OwnerDAO as OwnerDAO;
use Models\Owner as Owner;
use Utils\Session;

class OwnerController{
    private $ownerDAO;


    public function __construct(){
        $this->ownerDAO = new OwnerDAO();
    }
 
    public function register($fullname, $age, $dni, $email, $password){
        $user = new Owner($email, $fullname, $dni, $age, $password);
        if($this->ownerDAO->getByEmail($email) == null){
            $this->ownerDAO->add($user);
            Session::SetOkMessage("Owner registrado con exito");
        }else{
            Session::SetBadMessage("El email ya esta en uso");
        }
       header ("location: ".FRONT_ROOT."Auth/showLogin");
    }

    public function showChangePassword(){
       require_once(VIEWS_PATH."change-password.php");
    }

    public function changePassword($userID,$oldPassword,$newPassword,$newPassword2){
        $user = $this->ownerDAO->findbyID($userID);
       
        if($oldPassword == $user->getPassword()){ 
            if($newPassword==$newPassword2){
                $this->ownerDAO->updatePassword($userID,$newPassword);
                Session::SetOkMessage("Contraseña actualizada con exito.");
                Session::DeleteSession();
            }else{     
                Session::SetBadMessage("Contraseña nueva no concuerda.");
                $this->showChangePassword(); 
            }
        }else{
            Session::SetBadMessage("Verificar su antigua contraseña.");
            $this->showChangePassword(); 
        }       
    }

}
