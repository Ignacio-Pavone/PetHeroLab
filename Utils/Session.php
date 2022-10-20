<?php namespace Utils;

    use Models\Usuario as User;

    class Session {
        public static function CreateSession(User $user) {
            $_SESSION["loggedUser"] = $user;
        }

        public static function VerifySession() {
            if(!isset($_SESSION["loggedUser"])) {
                include_once(VIEWS_PATH."login.php");
            }
        }

        public static function VerifiyMessage () {
            if(isset($_SESSION["message"])) {
                return true;
            }
            return false;
        }

        public static function getType () {
            return $_SESSION["userType"];
        }

        public static function SetTypeUser($type) {
            $_SESSION["userType"] = $type;
        }

        public static function SetMessage ($message) {
            $_SESSION["message"] = $message;
        }

        public static function IsLogged() {
            return isset($_SESSION["loggedUser"]);
        }

        public static function GetLoggedUser() {
            return  Session::IsLogged() ? $_SESSION["loggedUser"] : null;
        }

        public static function DeleteSession() {
            unset($_SESSION['loggedUser']);
            session_destroy();
            include_once(VIEWS_PATH."login.php");
        }
    }
?>