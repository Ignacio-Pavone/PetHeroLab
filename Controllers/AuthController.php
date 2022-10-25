<?php namespace Controllers;

        use DAO\guardianDAO as guardianDAO;
        use DAO\duenioDAO as duenioDAO;
        use DAO\reservaDAO as reservaDAO;
        use DAO\mascotaDAO as mascotaDAO;
        use Utils\Session;

        class AuthController{
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

            public function login($email, $password){
                if ($this->guardianDAO->LoginCheckGuardian($email, $password)){
                    header("location: ".FRONT_ROOT."Auth/showGuardianProfile/" . $email);
                }elseif ($this->duenioDAO->LoginCheckDuenio($email, $password)){
                    header("location: ".FRONT_ROOT."Auth/showDuenioProfile");
                }else{
                    Session::SetBadMessage("Usuario o contraseña incorrectos");
                    header ("location: ".FRONT_ROOT."Auth/showLogin");
                }
            }   

            public function showGuardianProfile($email){
                $guardian = $this->guardianDAO->getGuardianByEmail($email);
                ($this->guardianDAO->checkPerfil($guardian)) ? Session::SetBadMessage("Por favor establesca su disponibilidad laboral") : '' ;
                $duenios = $this->duenioDAO->GetAllDuenios();
                $todaslasmascotas = $this->mascotaDAO->GetAllMascotas();
                $mascotas = $this->mascotaDAO->filtrarMascotasporTamanio($guardian->getTipoMascota());
                $reservas = $this->reservaDAO->getReservasByGuardianID($guardian->getIdGuardian());
                require_once(VIEWS_PATH . 'guardian-profile.php');
            }

            public function showDuenioProfile(){
                $user = Session::GetLoggedUser();
                $mascotas = $this->mascotaDAO->devolverMascotasporDuenio($user->getidDuenio());
                $todoslosguardianes = $this->guardianDAO->GetAllGuardians();
                $guardianes = $this->guardianDAO->GetAllGuardians();
                $reservas = $this->reservaDAO->getReservasByDuenioID($user->getidDuenio()); 
                require_once(VIEWS_PATH . 'duenio-profile.php');
            }

            public function showFilter($filtroInicio,$filtroFin){
                $user = Session::GetLoggedUser();
                if (!$this->reservaDAO->dateChecker($filtroInicio,$filtroFin)){
                $mascotas = $this->mascotaDAO->devolverMascotasporDuenio($user->getidDuenio());
                $todoslosguardianes = $this->guardianDAO->GetAllGuardians();
                $guardianes = $this->guardianDAO->getGuardiansByDate($filtroInicio, $filtroFin);
                $reservas = $this->reservaDAO->getReservasByDuenioID($user->getidDuenio()); 
                require_once(VIEWS_PATH . 'duenio-profile.php');
                } else{
                    Session::SetBadMessage("La fecha de inicio debe ser menor a la fecha de fin");
                    header ("location: ".FRONT_ROOT."Auth/showDuenioProfile");
                }
            }

            public function showdisponibilityView(){
                require_once(VIEWS_PATH . 'guardian-disponibilidad.php');
            }

            public function showLogin($message = ""){
                require_once(VIEWS_PATH . 'login.php');
            }

        }
    ?>