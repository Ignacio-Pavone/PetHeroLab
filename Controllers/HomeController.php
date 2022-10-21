<?php
	namespace Controllers;

use Utils\Session;

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

		public function showduenioRegister(){
			require_once(VIEWS_PATH."register-owner.php");
		}
	}

?>