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

        public static function SetTypeUser($type) {
            $_SESSION["userType"] = $type;
        }

        public static function SetError ($error) {
            $_SESSION["error"] = $error;
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