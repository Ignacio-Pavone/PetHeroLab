<?php

use Utils\Session;

$user = Session::GetLoggedUser();
require_once VIEWS_PATH . 'header.php';
?>

<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
    <span class="navbar-text">
        <strong>Welcome - <?php echo $user->getFullName() ?></strong>
    </span>
    <ul class="navbar-nav ml-auto">
        <?php if (Session::getType() == "guardian") { ?>
            <button type="button" style = "margin-right:20px" class="btn btn-info text-dark position-relative">Calificacion
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?php echo bcdiv($user->getReputacion(), '1', 1)?></span>
            <span class="visually-hidden"></span>
            </span>
            </button>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo FRONT_ROOT.'Auth/showGuardianProfile/'.$user->getEmail();?>">Volver al perfil</a>
        </li>
        <?php } else { ?>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo FRONT_ROOT ?>Auth/showDuenioProfile">Volver al perfil</a>
        </li>
        <?php } ?>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo FRONT_ROOT ?>Home/Logout">Cerrar Sesión</a>
        </li>
    </ul>
</nav>