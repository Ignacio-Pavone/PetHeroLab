<?php
	namespace Controllers;

use Utils\Session;

	class HomeController
	{
		public function Index()
		{
			require_once(VIEWS_PATH . 'login.php');
		}

		public function Logout()
		{
			Session::DeleteSession();
			require_once (VIEWS_PATH . 'logout.php');
		}
	}

?>