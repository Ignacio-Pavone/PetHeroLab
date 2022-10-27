<?php
use Utils\Session;
$user = Session::GetLoggedUser();
require_once VIEWS_PATH . 'header.php';
?>
<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
    <span class="navbar-text">
        <strong>Welcome  <?php 
        if (Session::IsLogged())
        echo $user->getFullName() ?></strong>
    </span>
    <ul class="navbar-nav ml-auto">
        <?php
        if (Session::IsLogged()) {
        if(Session::getType() == "owner") { ?>
        <li class="nav-item">
            <a class="nav-link" href="#dataUser">Mis Datos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#css-mine">Ver Mascotas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#addPetsDuenio">Agregar Mascotas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#css-mine1">Ver Guardianes</a>
        </li>
        <?php }else{?>
            <button type="button" style = "margin-right:20px"class="hovertext btn btn-info text-dark position-relative" data-hover="Tu Calificacion">Calificacion
            <?php if ($user->getReputation() >= 3 && $user->getReputation() < 4) { ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success"><?php echo bcdiv($user->getReputation(), '1', 1)?></span>
                <?php } elseif ($user->getReputation() > 0 && $user->getReputation() < 3) { ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?php echo bcdiv($user->getReputation(), '1', 1)?></span>
                <?php } elseif($user->getReputation()==0){ ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-light"><?php echo bcdiv($user->getReputation(), '1', 1)?></span>
                 <?php } else { ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning"><?php echo bcdiv($user->getReputation(), '1', 1)?></span>
                <?php } ?>
            <span class="visually-hidden"></span>
            </span>
            </button>
        <li class="nav-item">
            <a class="nav-link" href="#dataUser">Mis Datos</a>
        </li>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo FRONT_ROOT.'Auth/showdisponibilityView/'.$user->getFullName(); ?>">Modificar Disponibilidad</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#css-mine">Ver Notificaciones</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#css-mine">Ver Historial</a>
        <?php } ?>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo FRONT_ROOT ?>Home/Logout">Cerrar Sesión</a>
        </li>
        <?php } else {?>
            <li class="nav-item">
            <a class="nav-link" href="<?php echo FRONT_ROOT. "Home/showownerRegister" ?>">Registrarse como Dueño</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo FRONT_ROOT. "Home/showguardianRegister" ?>">Registrarse como Guardian</a>
        </li>
        <?php } ?>
    </ul>
</nav>