<?php 
namespace Controllers;
use DAO\PaymentDAO as paymentDAO;
use DAO\OwnerDAO as ownerDAO;
use DAO\GuardianDAO as guardianDAO;
use DAO\PetDAO as petDAO;
use DAO\ReservaDAO as requestDAO;
use Utils\Email as Email;


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

    public function processPayment($Method, $idPayment, $idOwner, $idRequest)
    {
        $owner = $this->ownerDAO->findbyID($idOwner);
        $idGuardian = $this->findGuardianIdbyRequest($idRequest);
        $guardian = $this->guardianDAO->findbyID($idGuardian);
        $request = $this->requestDAO->findByRequestId($idRequest);
        $idPet = $this->findPetIdbyRequest($idRequest);
        $pet = $this->petDAO->findbyID($idPet);
        $this->paymentDAO->insertMethod($idPayment, $Method);
        $this->paymentDAO->updatePaid($idPayment);
        $this->paymentDAO->updateDate($idPayment);
        Email::sendEmail($owner->getEmail(), 'Datos de tu reserva', Email::buyaMailBody($guardian, $request, $pet, $owner, $Method));
        header("location: " . FRONT_ROOT . "Auth/showOwnerProfile");
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


}

?>