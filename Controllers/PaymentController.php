<?php 
namespace Controllers;
use DAO\PaymentDAO as paymentDAO;
use DAO\OwnerDAO as ownerDAO;
use DAO\GuardianDAO as guardianDAO;
use DAO\PetDAO as petDAO;
use DAO\RequestDAO as requestDAO;
use Utils\Email as Email;
use Utils\CreditCard as CreditCard;
use Utils\Session as Session;


class PaymentController
{
    private $paymentDAO;
    private $requestDAO;
    private $ownerDAO;
    private $petDAO;

    public function __construct()
    {
        $this->paymentDAO = new paymentDAO();
        $this->guardianDAO = new GuardianDAO();
        $this->ownerDAO = new OwnerDAO();
        $this->petDAO = new PetDAO();
        $this->requestDAO = new RequestDAO();
    }
    

    public function processPayment($idPayment, $idOwner, $idRequest, $name, $expiry, $number, $cvc)
    {
        $datos = CreditCard::validCreditCard($number);
        if(!$this->validatePay($name,$expiry,$number,$cvc)){
            Session::SetBadMessage("Datos de la tarjeta incorrectos intente nuevamente.");
            header("location: ".FRONT_ROOT . 'Payment/showPaymentForm/' . $idPayment);
        }else{
            $owner = $this->ownerDAO->findbyID($idOwner);
            $idGuardian = $this->findGuardianIdbyRequest($idRequest);
            $guardian = $this->guardianDAO->findbyID($idGuardian);
            $request = $this->requestDAO->findByRequestId($idRequest);
            $idPet = $this->findPetIdbyRequest($idRequest);
            $pet = $this->petDAO->findbyID($idPet);
            $finalprice = $request->getfinalPrice() / 2;
            $this->paymentDAO->insertMethod($idPayment, $datos['type']);
            $this->paymentDAO->updatePaid($idPayment);
            $this->paymentDAO->updateDate($idPayment);
            $this->paymentDAO->updateFinalPrice($idPayment, $finalprice);
            $this->requestDAO->updateFinalPrice($idRequest, $finalprice);
            Session::setOkMessage("Tu compra con tarjeta ".$datos['type']." fue procesada con éxito.");
            Email::sendEmail($owner->getEmail(), 'Datos de tu reserva', Email::buyaMailBody($guardian, $request, $pet, $owner,$datos['type'], $datos['number'],  $finalprice));
            header("location: " . FRONT_ROOT . "Auth/showOwnerProfile");
        }


    }

    public function findPetIdbyRequest($idRequest)
    {
        $requests = $this->requestDAO->getAll();
        foreach ($requests as $request) {
            if ($request->getIdRequest() == $idRequest) {
                return $request->getIdPet();
            }
        }
    }

    public function findGuardianIdbyRequest($idRequest)
    {
        $requests = $this->requestDAO->getAll();
        foreach ($requests as $request) {
            if ($request->getIdRequest() == $idRequest) {
                return $request->getIdGuardian();
            }
        }
    }

    public function showPaymentForm($id)
    {
        header("location: " . FRONT_ROOT . "Auth/showPaymentForm/" . $id);
    }

    private function validatePay($name,$mmyy,$number,$cvc)
        {
            //Validamos numeros de la tarjeta
            $validateCard = CreditCard::validCreditCard($number);
            if($validateCard['valid'] == false) return false;

            //Validamos codigo de seguridad
            $validateCvc = CreditCard::validCvc($cvc, $validateCard['type']);
            if($validateCvc == false) return false;

            //Validamos fecha de expiracion
            $date = explode("/", $mmyy);
            $validateDate = CreditCard::validDate("20".$date[1], $date[0]);
            if(!$validateDate) return false;

            return true;
        }
}
?>