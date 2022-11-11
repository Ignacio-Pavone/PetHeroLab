<?php 
namespace Controllers;
use DAO\GuardianDAO as GuardianDAO;
use DAO\OwnerDAO as OwnerDAO;
use DAO\RequestDAO as RequestDAO;
use DAO\PetDAO as PetDAO;
use DAO\PaymentDAO as PaymentDAO;
use Utils\Session;
use Utils\Email;

class AuthController
{
    private $guardianDAO;
    private $ownerDAO;
    private $requestDAO;
    private $petDAO;
    private $paymentDAO;

    public function __construct()
    {
        $this->guardianDAO = new GuardianDAO();
        $this->ownerDAO = new OwnerDAO();
        $this->requestDAO = new requestDAO ();
        $this->petDAO = new PetDAO();
        $this->paymentDAO = new PaymentDAO();
    }

    public function login($email, $password)
    {

        try {
            if ($this->guardianDAO->LoginCheck($email, $password)) {
                header("location: " . FRONT_ROOT . "Auth/showGuardianProfile/" . $email);
            } elseif ($this->ownerDAO->LoginCheck($email, $password)) {
                header("location: " . FRONT_ROOT . "Auth/showOwnerProfile");
            } else {
                Session::SetBadMessage("User o contraseña incorrectos");
                header("location: " . FRONT_ROOT . "Auth/showLogin");
            }
        } catch (\Exception $e) {
            Session::SetBadMessage("Hubo algun problema con la conexion a la base de datos");
            header("location: " . FRONT_ROOT . "Auth/showLogin");
        }

    }

    public function showGuardianProfile($email)
    {

        try {
            $guardian = $this->guardianDAO->getByEmail($email);
        } catch (\Exception $e) {
            Session::SetBadMessage("Error al obtener datos propios");
        }
        Session::CreateSession($guardian);
        ($this->guardianDAO->checkProfile($guardian)) ? Session::SetBadMessage("Por favor establesca su disponibilidad laboral") : '';
        try {
            $owners = $this->ownerDAO->GetAll();
        } catch (\Exception $e) {
            Session::SetBadMessage("Error al obtener datos de los dueños");
        }
        try {
            $allpets = $this->petDAO->GetAll();
        } catch (\Exception $e) {

            Session::SetBadMessage("Error al obtener datos de las mascotas");
        }
        try {
            $payments = $this->paymentDAO->GetAll();
        } catch (\Exception $e) {
            Session::SetBadMessage("Error al obtener datos de los pagos");
        }
        try {
            $requests = $this->requestDAO->findByGuardianId($guardian->getId());
        } catch (\Exception $e) {
            Session::SetBadMessage("Error al obtener datos de las solicitudes");
        }

        require_once(VIEWS_PATH . 'guardian/guardian-profile.php');
    }

    public function showOwnerProfile()
    {
        $user = Session::GetLoggedUser();
        try {
            $sesion = $this->ownerDAO->getByEmail($user->getEmail());
            Session::CreateSession($sesion);
            $allPets = $this->petDAO->returnByOwner($sesion->getId());
            $allGuardians = $this->guardianDAO->GetAll();
            $guardians = $this->guardianDAO->GetAll();
            $requests = $this->requestDAO->findByOwnerId($user->getId());
            $payments = $this->paymentDAO->getAllByOwner($user->getId());
        }catch (\Exception $e) {
            Session::SetBadMessage("Error de conexion con la base datos");
        }
        require_once(VIEWS_PATH . 'owner/owner-profile.php');
    }

    public function showFilter($filtroInicio, $filtroFin)
    {
        $user = Session::GetLoggedUser();

        if (!$this->requestDAO ->dateChecker($filtroInicio, $filtroFin)) {
            try {
                $allPets = $this->petDAO->returnByOwner($user->getId());
                $allGuardians = $this->guardianDAO->GetAll();
                $guardians = $this->guardianDAO->getByDate($filtroInicio, $filtroFin);
                $requests = $this->requestDAO->findByOwnerId($user->getId());
                $payments = $this->paymentDAO->getAllByOwner($user->getId());
            } catch (\Exception $e) {
                Session::SetBadMessage("Error de conexion a la base datos");
            }
            require_once(VIEWS_PATH . 'owner/owner-profile.php');
        } else {
            Session::SetBadMessage("La fecha de inicio debe ser menor a la fecha de fin");
            header("location: " . FRONT_ROOT . "Auth/showOwnerProfile");
        }

    }

    public function showPaymentForm($idPayment)
    {

        try {
            $payment = $this->paymentDAO->findybyID($idPayment);
            $request = $this->requestDAO->getAll();
            $guardians = $this->guardianDAO->getAll();
            $owners = $this->ownerDAO->getAll();
            $pets = $this->petDAO->getAll();
        } catch (\Exception $e) {
            Session::SetBadMessage("Error al obtener datos");
        }
            require_once(VIEWS_PATH . "payment/payment-method.php");
    }

       



    public function showdisponibilityView()
    {
        require_once(VIEWS_PATH . 'guardian/guardian-disponibilidad.php');
    }

    public function showLogin($message = "")
    {
        require_once(VIEWS_PATH . 'system/login.php');
    }

    public function forgotPassword()
    {
        require_once(VIEWS_PATH . 'password/forgot-password.php');
    }

    public function sendPass($email, $tipo)
    {
        $user = null;

        if ($tipo == "guardian") {
            try {
                $user = $this->guardianDAO->getByEmail($email);
            } catch (\Exception $e) {
                Session::SetBadMessage("Error con la base de datos");
            }
        } elseif ($tipo == "owner") {
            try {
                $user = $this->ownerDAO->getByEmail($email);
            } catch (\Exception $e) {
                Session::SetBadMessage("Error con la base de datos");
            }
        }
        if ($user != null) {
            Email::sendPassMail($user->getEmail(), $user->getPassword());
            Session::SetOkMessage("Se ha enviado un mail con su contraseña");
        } else {
            Session::SetBadMessage("El mail ingresado no existe");
        }
        header("location: " . FRONT_ROOT . "Auth/showLogin");

    }
}
?>