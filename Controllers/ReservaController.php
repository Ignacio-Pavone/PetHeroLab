<?php namespace Controllers;

        use DAO\guardianDAO as guardianDAO;
        use DAO\duenioDAO as duenioDAO;
        use DAO\mascotaDAO as mascotaDAO;
        use Models\Reserva as Reserva;
        use Utils\Session;
        use DAO\reservaDAO as reservaDAO;
        use Utils\EReserva;

        class ReservaController{
        private $guardianDAO;
        private $duenioDAO;
        private $reservaDAO;
        private $mascotaDAO;

        public function __construct(){
                $this->guardianDAO = new guardianDAO();
                $this->duenioDAO = new duenioDAO(); 
                $this->reservaDAO = new reservaDAO();
                $this->mascotaDAO = new mascotaDAO();
        }
        
        public function solicitarReservaDuenio ($idMascota,$Duenio, $Guardian, $fechaInicio, $fechaFin, $costoTotal){
            $dias = $this->reservaDAO->contarDias($fechaInicio,$fechaFin);
            $searchPet = $this->mascotaDAO->findMascotaByID($idMascota);
            $searchGuardian = $this->guardianDAO->getGuardianByEmail($Guardian);
            $searchDuenio = $this->duenioDAO->getDuenioByEmail($Duenio);
            if (strcasecmp($searchGuardian->getTipoMascota(), $searchPet->getTamanio()) == 0){
            if ($this->reservaDAO->chequeoDataReserva($searchPet,$searchGuardian,$searchDuenio) && !$this->reservaDAO->dateChecker($fechaInicio,$fechaFin)){
                if ($this->reservaDAO->checkfirstPetType($searchGuardian->getIdGuardian(),$searchPet->getTipo(), $searchPet->getRaza())) {
                    $reserva = new Reserva($searchPet->getIdMascota(), $searchDuenio->getIdDuenio(), $searchGuardian->getIdGuardian(), $fechaInicio, $fechaFin, doubleval($costoTotal), $searchPet->getTipo(),$searchPet->getRaza(), $dias);
                    $reserva->calcularCostoTotal($costoTotal);
                    $this->reservaDAO->add($reserva);
                    Session::SetOkMessage("Guardian Solicitado con Exito");
                }else{
                    Session::SetBadMessage("El guardian esta cuidando distinto tipo de mascotas");
                 }
            }else{
                Session::SetBadMessage("No se pudo realizar la reserva. Compruebe las fechas y que los datos esten correctamente cargados");
            }
            }else{
                Session::SetBadMessage("El guardian no cuida mascotas de ese tamaño");
            } 
           header ("location: ".FRONT_ROOT."Auth/ShowDuenioProfile/");
        }

        public function aceptarReservaGuardian($nroReserva){
            $user = Session::GetLoggedUser();
            if ($this->reservaDAO->aceptarReservaGuardiann($nroReserva)){
                Session::SetOkMessage("Reserva Aceptada con Exito");
            }else{
                Session::SetBadMessage("No se pudo aceptar la reserva distinto tipo de mascota");
            }
            header ("location: ".FRONT_ROOT."Auth/showGuardianProfile/" . $user->getEmail() );
        }

        public function rechazarReservaGuardian($nroReserva){
            $user = Session::GetLoggedUser();
            $this->reservaDAO->rechazarReservaGuardian($nroReserva);
            header ("location: ".FRONT_ROOT."Auth/showGuardianProfile/". $user->getEmail());
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
            
            $guardianBuscado = $this->guardianDAO->findGuardianByID($guardian);
            $count = $this->reservaDAO->contarCalificacionesGuardian($guardian) + 1;
            $suma = $this->reservaDAO->sumarCalificacionesGuardian($guardian) + $calificacion;
            $guardianBuscado->calcularCalificacion($suma,$count);
            $this->guardianDAO->updateUser($guardianBuscado);

            if ($this->reservaDAO->cambiarEstado($reserva,"Calificado"))
            {
                $this->reservaDAO->setearCalificacion($reserva,$calificacion);
                Session::SetOkMessage("Guardian Calificado con Exito");
            }else{
                Session::SetBadMessage("No se pudo calificar al guardian");
            }
           header ("location: ".FRONT_ROOT."Auth/ShowDuenioProfile");         
        }
        

}