<?php namespace Controllers;

        use DAO\guardianDAO as guardianDAO;
        use DAO\duenioDAO as duenioDAO;
        use Utils\Session;

        class AuthController
        {
            private $guardianDAO;
            private $duenioDAO;
            public function __construct()
            {
                $this->guardianDAO = new guardianDAO();
                $this->duenioDAO = new duenioDAO();
            }

            public function login($email, $password){
                if ($this->guardianDAO->LoginCheckGuardian($email, $password)){
                    $this->showGuardianProfile();
                }elseif ($this->duenioDAO->LoginCheckDuenio($email, $password)){
                    $this->showDuenioProfile();
                }else{
                    $this->showLogin("Usuario o contraseña incorrectos");
                }
            }   

            public function showGuardianProfile()
            {
                require_once(VIEWS_PATH . 'guardian-profile.php');
            }

            public function showDuenioProfile()
            {
                $lista = $this->duenioDAO->GetAllDuenios();
                require_once(VIEWS_PATH . 'duenio-profile.php');
            }

            public function showLogin($message = "")
            {
                Session::SetMessage($message);
                require_once(VIEWS_PATH . 'login.php');
            }

        }
    ?>