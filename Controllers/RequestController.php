<?php namespace Controllers;

use DAO\GuardianDAO as GuardianDAO;
use DAO\OwnerDAO as OwnerDAO;
use DAO\PetDAO as PetDAO;
use Models\Payment as Payment;
use DAO\PaymentDAO as PaymentDAO;
use DAO\ReservaDAO as ReservaDAO;
use Models\Request as Request;
use Utils\Session;
use Utils\Tools as Tools;

class RequestController
{
    private $guardianDAO;
    private $ownerDAO;
    private $reservaDAO;
    private $mascotaDAO;
    private $paymentDAO;

    public function __construct()
    {
        $this->guardianDAO = new GuardianDAO();
        $this->ownerDAO = new OwnerDAO();
        $this->reservaDAO = new ReservaDAO();
        $this->mascotaDAO = new PetDAO();
        $this->paymentDAO = new PaymentDAO();
    }

    public function requestGuardian($idMascota, $Duenio, $Guardian, $fechaInicio, $fechaFin, $costoTotal)
    {
        $dias = $this->reservaDAO->countDays($fechaInicio, $fechaFin);
        $searchPet = $this->mascotaDAO->findByID($idMascota);
        $searchGuardian = $this->guardianDAO->getByEmail($Guardian);
        $searchDuenio = $this->ownerDAO->getByEmail($Duenio);
        if (strcasecmp($searchGuardian->getPetSize(), $searchPet->getPetsize()) == 0) {
            if ($this->reservaDAO->checkDataNotNull($searchPet, $searchGuardian, $searchDuenio) && !$this->reservaDAO->dateChecker($fechaInicio, $fechaFin)) {
                if ($this->reservaDAO->analyzeRequest($searchGuardian->getId(), $searchPet->getType(), $searchPet->getBreed(), $fechaInicio)) {
                    $reserva = new Request($searchPet->getId(), $searchDuenio->getId(), $searchGuardian->getId(), $fechaInicio, $fechaFin, doubleval($costoTotal), $searchPet->getType(), $searchPet->getBreed(), $dias);
                    $reserva->setIdOwner($searchDuenio->getId());
                    $reserva->setFinalPrice($costoTotal);
                    if (!$this->reservaDAO->Exists($reserva)) {
                        $this->reservaDAO->add($reserva);
                        Session::SetOkMessage("Guardian Solicitado con Exito");
                    } else {
                        Session::SetBadMessage("Ya existe una reserva con esos datos");
                    }
                } else {
                    Session::SetBadMessage("El guardian esta cuidando distinto tipo de mascotas");
                }
            } else {
                Session::SetBadMessage("No se pudo realizar la reserva. Compruebe las fechas y que los datos esten correctamente cargados");
            }
        } else {
            Session::SetBadMessage("El guardian no cuida mascotas de ese tamaño");
        }
        header("location: " . FRONT_ROOT . "Auth/ShowOwnerProfile/");
    }

    public function confirmRequestasGuardian($nroReserva)
    {
        $user = Session::GetLoggedUser();
        if ($this->reservaDAO->acceptRequestAsGuardian($nroReserva, $user->getId())) {
            $reserva= $this->reservaDAO->findByRequestId($nroReserva);
            $this->addPayment($reserva->getIdOwner(),$reserva->getIdRequest(),$reserva->getFinalPrice());
            Session::SetOkMessage("Request Aceptada con Exito");
        } else {
            Session::SetBadMessage("No se pudo aceptar la reserva distinto tipo de mascota");
        }
     header("location: " . FRONT_ROOT . "Auth/showGuardianProfile/" . $user->getEmail());
    }

    public function addPayment($id_owner,$id_request,$price){
        $payment = new Payment($id_owner,$id_request,$price);
        $this->paymentDAO->add($payment);
    }

    public function rejectRequestasGuardian($nroReserva)
    {
        $user = Session::GetLoggedUser();
        $this->reservaDAO->rejectRequestGuardian($nroReserva);
        header("location: " . FRONT_ROOT . "Auth/showGuardianProfile/" . $user->getEmail());
    }

    public function cancelRequestasOwner($nroReserva)
    {
        if ($this->reservaDAO->cancelAsOwner($nroReserva)) {
            Session::SetOkMessage("Request Cancelada con Exito");
        } else {
            Session::SetBadMessage("No se pudo cancelar la reserva");
        };
        header("location: " . FRONT_ROOT . "Auth/ShowOwnerProfile");
    }

    public function qualifyGuardian($guardian, $calificacion, $reserva)
    {
        $guardianBuscado = $this->guardianDAO->findByID($guardian);
        $count = $this->reservaDAO->countReviewsById($guardian) + 1;
        $suma = $this->reservaDAO->sumReviewsById($guardian) + $calificacion;
        $guardianBuscado->checkReputation($suma, $count);
        $this->guardianDAO->update($guardianBuscado);
        if ($this->reservaDAO->changeReqStatus($reserva, "Calificado")) {
            $this->reservaDAO->setScore($reserva, $calificacion);
            Session::SetOkMessage("Guardian Calificado con Exito");
        } else {
            Session::SetBadMessage("No se pudo calificar al guardian");
        }
        header("location: " . FRONT_ROOT . "Auth/ShowOwnerProfile");
    }
}