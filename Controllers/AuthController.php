<?php namespace Controllers;

        use DAO\guardianDAO as guardianDAO;
        use DAO\duenioDAO as duenioDAO;
        use Models\Guardian as Guardian;
        use Models\Duenio as Duenio;
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
                    $this->showHome();
                }elseif ($this->duenioDAO->LoginCheckDuenio($email, $password)){
                    $this->showDuenioProfile();
                }else{
                    Session::SetError("Usuario o contraseña incorrectos");
                    $this->showLogin();
                }
            }   

            public function showHome()
            {
                require_once(VIEWS_PATH . 'guardian-profile.php');
            }

            public function showDuenioProfile()
            {
                $guardianes = $this->guardianDAO->GetAllGuardians();
                require_once(VIEWS_PATH . 'duenio-profile.php');
            }

            public function Index ($message = "")
            {
                require_once(VIEWS_PATH . 'login.php');
            }


            public function showLogin($message = "")
            {
                require_once(VIEWS_PATH . 'login.php');
            }

            public function showRegisterGuardian($message ="")
            {
                require_once(VIEWS_PATH . 'register-guardian.php');
                if ($message!="")
                {
                    echo "<script> alert('$message'); </script>";
                }
            }

            public function showRegisterDuenio($message ="")
            {
                require_once(VIEWS_PATH . 'register-owner.php');
                if ($message!="")
                {
                    echo "<script> alert('$message'); </script>";
                }
            }

            public function setDiaDisponible ($dia_lunes = null, $dia_martes = null, $dia_miercoles = null, $dia_jueves = null, $dia_viernes = null, $dia_sabado = null, $dia_domingo = null){
                $user = Session::GetLoggedUser();

                $disp = array();
                $user->reiniciarDisponibilidad();
                if ($dia_lunes != null)
                    $user->setDisponibilidad($dia_lunes);
                if ($dia_martes != null)
                    $user->setDisponibilidad($dia_martes);
                if ($dia_miercoles != null)
                    $user->setDisponibilidad($dia_miercoles);
                if ($dia_jueves != null)
                    $user->setDisponibilidad($dia_jueves);
                if ($dia_viernes != null)
                    $user->setDisponibilidad($dia_viernes);
                if ($dia_sabado != null)
                    $user->setDisponibilidad($dia_sabado);
                if ($dia_domingo != null)
                    $user->setDisponibilidad($dia_domingo);
            
                $this->guardianDAO->modifyUser($user->getEmail(), $user->getFullName(), $user->getDni(), $user->getAge(), $user->getPassword(), $user->getTipoMascota(), $user->getRemuneracionEsperada(), $user->getReputacion());
                $this->showHome();
            }
        }
    ?>