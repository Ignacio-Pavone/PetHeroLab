<?php namespace Utils;

    use Models\Usuario as User;

    class Session {
        public static function CreateSession(User $user) {
            $_SESSION["loggedUser"] = $user;
        }

        public static function VerifySession() {
            if(!isset($_SESSION["loggedUser"])) {
                header("location: ".FRONT_ROOT."Home/Index");
            }
        }

        public static function VerifiyMessage () {
            if(isset($_SESSION["message"])) {
                return true;
            }
            return false;
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
            session_start();
            session_destroy();
        }
    }
?>