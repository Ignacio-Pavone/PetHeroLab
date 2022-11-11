<?php
use Utils\Session;
use Utils\DateFormat as Format;
$user = Session::GetLoggedUser();
$type = $_SESSION['userType'];
require_once VIEWS_PATH . 'header.php';
require_once VIEWS_PATH . 'navbars/nav-simple-bar.php';
?>
<section style="height:100vh;" class="login-block">
    <main class="py-1">
        <div class="bg-light-alpha p-1 container" id="addPetsDuenio" >
            <br>
            <center>
                <h3 class="mb">Chat con Guardian: </h3>
                <hr> 
                <br>
            </center>
            
        </div> 
    </main>
    <br>



