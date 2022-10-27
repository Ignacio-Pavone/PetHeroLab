<?php namespace Controllers;

        use DAO\guardianDAO as guardianDAO;
        use DAO\ownerDAO as ownerDAO;
        use DAO\reservaDAO as reservaDAO;
        use DAO\petDAO as petDAO;
        use Utils\Session;

        class AuthController{
        private $guardianDAO;
        private $ownerDAO;
        private $reservaDAO;
        private $petDAO;
            
        public function __construct(){
        $this->guardianDAO = new guardianDAO();
        $this->ownerDAO = new ownerDAO();
        $this->reservaDAO = new reservaDAO();
        $this->petDAO = new petDAO();
        }

        public function login($email, $password){
        if ($this->guardianDAO->LoginCheck($email, $password)){
            header("location: ".FRONT_ROOT."Auth/showGuardianProfile/" . $email);
        }elseif ($this->ownerDAO->LoginCheck($email, $password)){
            header("location: ".FRONT_ROOT."Auth/showOwnerProfile");
         }else{
            Session::SetBadMessage("User o contraseña incorrectos");
            header ("location: ".FRONT_ROOT."Auth/showLogin");
        }
        }   

        public function showGuardianProfile($email){
        $guardian = $this->guardianDAO->getByEmail($email);
        Session::CreateSession($guardian);
        ($this->guardianDAO->checkProfile($guardian)) ? Session::SetBadMessage("Por favor establesca su disponibilidad laboral") : '' ;
        $owners = $this->ownerDAO->GetAll();
        $allpets = $this->petDAO->GetAll();
        $reservas = $this->reservaDAO->findByGuardianId($guardian->getId());
        require_once(VIEWS_PATH . 'guardian-profile.php');
        }

        public function showOwnerProfile(){
        $user = Session::GetLoggedUser();
        $sesion = $this->ownerDAO->getByEmail($user->getEmail());
        Session::CreateSession($sesion);
        $allPets = $this->petDAO->returnByOwner($user->getId());
        $allGuardians = $this->guardianDAO->GetAll();
        $guardianes = $this->guardianDAO->GetAll();
        $reservas = $this->reservaDAO->findByOwnerId($user->getId());
        require_once(VIEWS_PATH . 'owner-profile.php');
        }

        public function showFilter($filtroInicio,$filtroFin){
        $user = Session::GetLoggedUser();
        if (!$this->reservaDAO->dateChecker($filtroInicio,$filtroFin)){
        $allPets = $this->petDAO->returnByOwner($user->getId());
        $allGuardians = $this->guardianDAO->GetAll();
        $guardianes = $this->guardianDAO->getByDate($filtroInicio, $filtroFin);
        $reservas = $this->reservaDAO->findByOwnerId($user->getId());
        require_once(VIEWS_PATH . 'owner-profile.php');
        } else{
        Session::SetBadMessage("La fecha de inicio debe ser menor a la fecha de fin");
        header ("location: ".FRONT_ROOT."Auth/showOwnerProfile");
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