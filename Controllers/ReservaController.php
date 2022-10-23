<?php namespace Controllers;

        use DAO\guardianDAO as guardianDAO;
        use DAO\duenioDAO as duenioDAO;
        use Models\Reserva as Reserva;
        use Utils\Session;
        use DAO\reservaDAO as reservaDAO;
use Utils\EReserva;

        class ReservaController{
        private $guardianDAO;
        private $duenioDAO;
        private $reservaDAO;

        public function __construct(){
                $this->guardianDAO = new guardianDAO();
                $this->duenioDAO = new duenioDAO(); 
                $this->reservaDAO = new reservaDAO();
        }
        
        public function solicitarReservaDuenio ($mascota,$Duenio, $Guardian, $fechaInicio, $fechaFin, $costoTotal){
            $dias = $this->reservaDAO->contarDias($fechaInicio,$fechaFin);
            $searchPet = $this->duenioDAO->searchPetByName($mascota);
            $searchGuardian = $this->guardianDAO->getGuardianByEmail($Guardian);
            $searchDuenio = $this->duenioDAO->getDuenioByEmail($Duenio);
        
            if ($this->reservaDAO->chequeoDataReserva($searchPet,$searchGuardian,$searchDuenio) && !$this->reservaDAO->dateChecker($fechaInicio,$fechaFin)){
                if ($this->reservaDAO->checkfirstPetType($searchGuardian->getFullName(),$searchPet->getTipo(), $searchPet->getRaza())) {
                    $reserva = new Reserva($searchPet->getNombre(), $searchDuenio->getFullName(), $searchGuardian->getFullName(), $fechaInicio, $fechaFin, doubleval($costoTotal), $searchPet->getTipo(),$searchPet->getRaza(), $dias);
                    $reserva->calcularCostoTotal($costoTotal);
                    $this->reservaDAO->add($reserva);
                    Session::SetOkMessage("Guardian Solicitado con Exito");
                }else{
                    Session::SetBadMessage("El guardian esta cuidando distinto tipo de mascotas");
                }
            }else{
                Session::SetBadMessage("No se pudo realizar la reserva. Compruebe las fechas y que los datos esten correctamente cargados");
            }
           header ("location: ".FRONT_ROOT."Auth/ShowDuenioProfile");
        }

        public function aceptarReservaGuardian($nroReserva){
            if ($this->reservaDAO->aceptarReservaGuardiann($nroReserva)){
                Session::SetOkMessage("Reserva Aceptada con Exito");
            }else{
                Session::SetBadMessage("No se pudo aceptar la reserva distinto tipo de mascota");
            }
            header ("location: ".FRONT_ROOT."Auth/showGuardianProfile");
        }

        public function rechazarReservaGuardian($nroReserva){
            $this->reservaDAO->rechazarReservaGuardian($nroReserva);
            header ("location: ".FRONT_ROOT."Auth/showGuardianProfile");
        }

        public function cancelarReservaDuennio($nroReserva){
            if($this->reservaDAO->cancelarcomoDuenio($nroReserva)){
                Session::SetOkMessage("Reserva Cancelada con Exito");
            }else{
                Session::SetBadMessage("No se pudo cancelar la reserva");
            };
            header ("location: ".FRONT_ROOT."Auth/ShowDuenioProfile");
        }

        public function calificarGuardian ($guardian, $calificacion, $reserva){
            $guardianBuscado = $this->guardianDAO->searchGuardianByName($guardian);
            var_dump($guardianBuscado);
            $guardianBuscado->calcularCalificacion($calificacion);
            $this->guardianDAO->updateUser($guardianBuscado);
            $reservaBuscada = $this->reservaDAO->buscarReservaporNumero($reserva);
            if ($reservaBuscada!=null){
                $this->reservaDAO->cambiarEstado($reservaBuscada,EReserva::Calificada);
            }
            Session::SetOkMessage("Guardian Calificado con Exito");
            header ("location: ".FRONT_ROOT."Auth/ShowDuenioProfile");         
        }
        

}