<?php
	namespace Controllers;

	class HomeController
	{
		public function Index()
		{
			require_once(VIEWS_PATH . 'login.php');
		}
	}

?>