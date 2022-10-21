<?php namespace Controllers;

        use DAO\guardianDAO as guardianDAO;
        use DAO\duenioDAO as duenioDAO;
        use Models\Reserva as Reserva;
        use Utils\Session;
        use DAO\reservaDAO as reservaDAO;

        class ReservaController{
        private $guardianDAO;
        private $duenioDAO;
        private $authController;
        private $reservaDAO;

        public function __construct(){
                $this->guardianDAO = new guardianDAO();
                $this->duenioDAO = new duenioDAO();
                $this->authController = new AuthController();   
                $this->reservaDAO = new reservaDAO();
        }
        
        public function solicitarReservaDuenio ($mascota,$Duenio, $Guardian, $fechaInicio, $fechaFin, $costoTotal){
            $searchPet = $this->duenioDAO->searchPetByName($mascota);
            $searchGuardian = $this->guardianDAO->getGuardianByEmail($Guardian);
            $searchDuenio = $this->duenioDAO->getDuenioByEmail($Duenio);
            if ($searchPet!=null && $searchGuardian!=null && $searchDuenio!=null){
                $reserva = new Reserva($searchPet->getNombre(), $searchDuenio->getFullName(), $searchGuardian->getFullName(), $fechaInicio, $fechaFin, doubleval($costoTotal));
                $this->reservaDAO->add($reserva);
                Session::SetMessage("Guardian Solicitado con Exito");
            }else{
                Session::SetMessage("No se pudo realizar la reserva");
            }
            $this->authController->ShowDuenioProfile();
            
        }

}