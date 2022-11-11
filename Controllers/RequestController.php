<?php 
namespace Controllers;
use DAO\GuardianDAO as GuardianDAO;
use DAO\OwnerDAO as OwnerDAO;
use DAO\PetDAO as PetDAO;
use Models\Payment as Payment;
use DAO\PaymentDAO as PaymentDAO;
use DAO\RequestDAO as RequestDAO;
use Models\Request as Request;
use Utils\Session;

class RequestController
{
    private $guardianDAO;
    private $ownerDAO;
    private $requestDAO;
    private $mascotaDAO;
    private $paymentDAO;

    public function __construct()
    {
        $this->guardianDAO = new GuardianDAO();
        $this->ownerDAO = new OwnerDAO();
        $this->requestDAO = new requestDAO();
        $this->mascotaDAO = new PetDAO();
        $this->paymentDAO = new PaymentDAO();
    }

    public function requestGuardian($idMascota, $Duenio, $Guardian, $fechaInicio, $fechaFin, $costoTotal)
    {
        $dias = $this->requestDAO->countDays($fechaInicio, $fechaFin);
        try {
            $searchPet = $this->mascotaDAO->findByID($idMascota);
        } catch (\Exception $e) {
            Session::SetBadMessage("Error al obtener datos de la mascota");
        }
        try {
            $searchGuardian = $this->guardianDAO->getByEmail($Guardian);
        } catch (\Exception $e) {
            Session::SetBadMessage("Error al obtener datos del guardian");
        }
        try {
            $searchDuenio = $this->ownerDAO->getByEmail($Duenio);
        } catch (\Exception $e) {
            Session::SetBadMessage("Error al obtener datos del dueño");
        }
        if (strcasecmp($searchGuardian->getPetSize(), $searchPet->getPetsize()) == 0) {
            if ($this->requestDAO->checkDataNotNull($searchPet, $searchGuardian, $searchDuenio) && !$this->requestDAO->dateChecker($fechaInicio, $fechaFin)) {
                try {
                    if ($this->requestDAO->analyzeRequest($searchGuardian->getId(), $searchPet->getType(), $searchPet->getBreed(), $fechaInicio)) {
                        $reserva = new Request($searchPet->getId(), $searchDuenio->getId(), $searchGuardian->getId(), $fechaInicio, $fechaFin, doubleval($costoTotal), $searchPet->getType(), $searchPet->getBreed(), $dias);
                        $reserva->setIdOwner($searchDuenio->getId());
                        $reserva->setFinalPrice($costoTotal);
                        if (!$this->requestDAO->Exists($reserva)) {
                            $this->requestDAO->add($reserva);
                            Session::SetOkMessage("Guardian Solicitado con Exito");
                        } else {
                            Session::SetBadMessage("Ya existe una reserva con esos datos");
                        }
                    } else {
                        Session::SetBadMessage("El guardian esta cuidando distinto tipo de mascotas");
                    }
                } catch (\Exception $e) {
                    Session::SetBadMessage("Error en la base de datos");
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
        try {
            if ($this->requestDAO->acceptRequestAsGuardian($nroReserva, $user->getId())) {
                $reserva = $this->requestDAO->findByRequestId($nroReserva);
                $this->addPayment($reserva->getIdOwner(), $reserva->getIdRequest(), $reserva->getFinalPrice());
                Session::SetOkMessage("Reserva Aceptada con Exito");
            } else {
                Session::SetBadMessage("No se pudo aceptar la reserva distinto tipo de mascota");
            }
        } catch (\Exception $e) {
            Session::SetBadMessage("Error en la base de datos");
        }
        header("location: " . FRONT_ROOT . "Auth/showGuardianProfile/" . $user->getEmail());
    }

    public function addPayment($id_owner, $id_request, $price)
    {
        $payment = new Payment($id_owner, $id_request, $price);
        try {
            $this->paymentDAO->add($payment);
        } catch (\Exception $e) {
            Session::SetBadMessage("Error en la base de datos");
        }
    }

    public function rejectRequestasGuardian($nroReserva)
    {
        $user = Session::GetLoggedUser();
        try {
            $this->requestDAO->rejectRequestGuardian($nroReserva);
        } catch (\Exception $e) {
            Session::SetBadMessage("Error en la base de datos");
        }
        header("location: " . FRONT_ROOT . "Auth/showGuardianProfile/" . $user->getEmail());
    }

    public function cancelRequestasOwner($nroReserva)
    {
        try {
            if ($this->requestDAO->cancelAsOwner($nroReserva)) {
                Session::SetOkMessage("Reserva Cancelada con Exito");
            } else {
                Session::SetBadMessage("No se pudo cancelar la reserva");
            }
        } catch (\Exception $e) {
            Session::SetBadMessage("Error en la base de datos");
        };
        header("location: " . FRONT_ROOT . "Auth/ShowOwnerProfile");
    }

    public function qualifyGuardian($guardian, $calificacion, $reserva)
    {
        try {
            $guardianBuscado = $this->guardianDAO->findByID($guardian);
            $count = $this->requestDAO->countReviewsById($guardian) + 1;
            $suma = $this->requestDAO->sumReviewsById($guardian) + $calificacion;
            $guardianBuscado->checkReputation($suma, $count);
            $this->guardianDAO->update($guardianBuscado);
            $this->requestDAO->changeReqStatus($reserva, "Calificado");
            $this->requestDAO->setScore($reserva, $calificacion);
            Session::SetOkMessage("Guardian Calificado con Exito");
        } catch (\Exception $e) {
            Session::SetBadMessage("Error en la base de datos");
        }

        header("location: " . FRONT_ROOT . "Auth/ShowOwnerProfile");
    }
}
?>