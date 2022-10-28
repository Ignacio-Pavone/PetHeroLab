<?php namespace Controllers;

use DAO\GuardianDAO as GuardianDAO;
use DAO\OwnerDAO as OwnerDAO;
use DAO\PetDAO as PetDAO;
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

    public function __construct()
    {
        $this->guardianDAO = new GuardianDAO();
        $this->ownerDAO = new OwnerDAO();
        $this->reservaDAO = new ReservaDAO();
        $this->mascotaDAO = new PetDAO();
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
            $owner = $this->ownerDAO->findbyID($reserva->getIdOwner());
            $pet = $this->mascotaDAO->findByID($reserva->getIdPet());
            Tools::sendEmail('ignaciopavone@gmail.com', 'Datos de tu reserva', $this->compraMailBody($user,$reserva,$pet,$owner));
            Session::SetOkMessage("Request Aceptada con Exito");
        } else {
            Session::SetBadMessage("No se pudo aceptar la reserva distinto tipo de mascota");
        }
     header("location: " . FRONT_ROOT . "Auth/showGuardianProfile/" . $user->getEmail());
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

    private function compraMailBody($guardian, $request, $pet, $owner){
        $message = "<html>
        <body style='background-color:#fff; background-image:url(https://as1.ftcdn.net/v2/jpg/04/24/35/24/1000_F_424352469_WJYlrdisV68nj5yh3MWteLh8qohN7AZU.jpg); background-size:cover' bgcolor='#fff' >
       
        <table align='center' border='' cellpadding='0' cellspacing='0' font-family: Consolas;border-radius: 80px; background-image: ; background-size: cover' width='650'>
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
                                <h4 style= letter-spacing: 1px; font-weight: 700; font-size: 26px; text-align: center; margin: 0; line-height: normal' >Costo total: " . $request->getFinalPrice() . " . </h4>
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