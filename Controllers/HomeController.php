<?php
namespace Controllers;

class HomeController
{
    public function Index()
    {
        require_once(VIEWS_PATH . "system/login.php");
    }

    public function Logout()
    {
        require_once(VIEWS_PATH . 'system/logout.php');
    }

    public function showguardianRegister()
    {
        require_once(VIEWS_PATH . "guardian/register-guardian.php");
    }

    public function showownerRegister()
    {
        require_once(VIEWS_PATH . "owner/register-owner.php");
    }
}
?>