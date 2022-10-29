<?php namespace Controllers;
use DAO\PaymentDAO as paymentDAO;
use DAO\OwnerDAO as ownerDAO;
use DAO\GuardianDAO as guardianDAO;
use DAO\PetDAO as petDAO;
use DAO\ReservaDAO as requestDAO;
use Utils\Tools as Tools;

class PaymentController{
    private $paymentDAO;
    private $requestDAO;
    private $ownerDAO;
    private $petDAO;

    public function __construct(){
        $this->paymentDAO = new paymentDAO();
        $this->guardianDAO = new GuardianDAO();
        $this->ownerDAO = new OwnerDAO();
        $this->petDAO = new PetDAO();
        $this->requestDAO = new RequestDAO();
    }

    public function processPayment($Method,$idPayment, $idOwner, $idRequest){
        $owner = $this->ownerDAO->findbyID($idOwner);
        $idGuardian = $this->findGuardianIdbyRequest($idRequest);
        $guardian = $this->guardianDAO->findbyID($idGuardian);
        $request = $this->requestDAO->findByRequestId($idRequest);
        $idPet = $this->findPetIdbyRequest($idRequest);
        $pet = $this->petDAO->findbyID($idPet);
        $this->paymentDAO->insertMethod($idPayment, $Method);
        $this->paymentDAO->updatePaid($idPayment);
        $this->paymentDAO->updateDate($idPayment);
        Tools::sendEmail($owner->getEmail(), 'Datos de tu reserva', $this->compraMailBody($guardian,$request,$pet,$owner));
        header ("location: ".FRONT_ROOT."Auth/showOwnerProfile");
    }

    public function findPetIdbyRequest ($idRequest){
        $requests = $this->requestDAO->getAll();
        foreach ($requests as $request) {
            if ($request->getIdRequest() == $idRequest) {
                return $request->getIdPet();
            }
        }
    }

    public function findGuardianIdbyRequest ($idRequest){
        $requests = $this->requestDAO->getAll();
        foreach ($requests as $request) {
            if ($request->getIdRequest() == $idRequest) {
                return $request->getIdGuardian();
            }
        }
    }

    public function showPaymentForm($id){
        header("location: ".FRONT_ROOT."Auth/showPaymentForm/".$id);
    }

    private function compraMailBody($guardian, $request, $pet, $owner){
        $message = "<html>
        <body style='background-color:#fff; background-image:url(https://as1.ftcdn.net/v2/jpg/04/24/35/24/1000_F_424352469_WJYlrdisV68nj5yh3MWteLh8qohN7AZU.jpg); background-size:cover' bgcolor='#fff' >
       
        <table align='center' cellpadding='0' cellspacing='0' font-family: Consolas;border-radius: 80px; background-image: ; background-size: cover' width='650'>
            <tbody>
                <tr>
                    <td style='font-family: Consolas; font-weight:400;font-size:15px;color:#fff;text-align:center;padding:20px;line-height:25px; ' class=''><center><img src='https://cdn.discordapp.com/attachments/855473848869847050/1035570001761022023/Screenshot_4.png' width='300px' height='150px' style='display: block'></center>
       
        <center><img src='".$pet->getPhotoUrl()."' style='display: block; border-radius: 200px' width='200'></center>
        <p style='color: black; font-size: 36px; font-weight: 900; text-align:center' font-family:Consolas;>Datos de tu Reserva</p></td></tr>
        </tbody>
        </table>
       ";
            $message .= "<table align='center' border='0' cellpadding='0' cellspacing='0' style='font-family: Consolas;' width='650'>
                <tbody>
                    <tr>
                        <td bgcolor='#fff' style='color:#666; text-align:left; font-size:14px;font-family:Consolas; padding:20px 0px 20px 40px; line-height:25px; border-radius:30px 0 0 30px;' valign='middle' width='50%' class=''>                                                
                        <table align='center' border='0' cellpadding='0' cellspacing='0' width='350'>
                            <tbody>
                                <h4 style= letter-spacing: 1px; font-weight: 700; font-size: 26px; text-align: center; margin: 0; line-height: normal' >Guardian: " . $guardian->getFullName() . "</h4>
                                <h4 style= letter-spacing: 1px; font-weight: 700; font-size: 26px; text-align: center; margin: 0; line-height: normal' >Fecha de inicio: " . $request->getInitDate() . "</h4>
                                <h4 style= letter-spacing: 1px; font-weight: 700; font-size: 26px; text-align: center; margin: 0; line-height: normal' >Fecha de fin: " . $request->getFinishDate() . "</h4>
                                <h4 style= letter-spacing: 1px; font-weight: 700; font-size: 26px; text-align: center; margin: 0; line-height: normal' >Costo total: $" . $request->getFinalPrice() . "</h4>
                                <h4 style= letter-spacing: 1px; font-weight: 700; font-size: 26px; text-align: center; margin: 0; line-height: normal' >Tipo de mascota: " . $pet->getType() . "</h4>
                                <h4 style= letter-spacing: 1px; font-weight: 700; font-size: 26px; text-align: center; margin: 0; line-height: normal' >Raza: " . $pet->getBreed() . "</h4>
                                <h4 style= letter-spacing: 1px; font-weight: 700; font-size: 26px; text-align: center; margin: 0; line-height: normal' >Nombre de la mascota: " . $pet->getName() . "</h4>
                                <h4 style= letter-spacing: 1px; font-weight: 700; font-size: 26px; text-align: center; margin: 0; line-height: normal' >Nombre del dueño: " . $owner->getFullName() . " </h4>
                                <h4 style= letter-spacing: 1px; font-weight: 700; font-size: 26px; text-align: center; margin: 0; line-height: normal' >Email del dueño: " . $owner->getEmail() . "</h4>
                            </tbody>
                        </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            &nbsp;";
        return $message;
    }
}
?>