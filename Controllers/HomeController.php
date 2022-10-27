<?php
	namespace Controllers;

	class HomeController
	{
		public function Index(){
			require_once(VIEWS_PATH."login.php");
		}

		public function Logout(){
			require_once (VIEWS_PATH . 'logout.php');
		}

		public function showguardianRegister (){
			require_once(VIEWS_PATH."register-guardian.php");
		}

		public function showownerRegister(){
			require_once(VIEWS_PATH."register-owner.php");
		}
	}

?>