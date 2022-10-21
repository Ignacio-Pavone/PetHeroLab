<?php
use Utils\Session;
$user = Session::GetLoggedUser();
require_once VIEWS_PATH . 'header.php';
?>
<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
    <span class="navbar-text">
        <strong>TP FINAL Welcome  <?php 
        if (Session::IsLogged())
        echo $user->getFullName() ?></strong>
    </span>
    <ul class="navbar-nav ml-auto">
        <?php
        if (Session::IsLogged()) {
        if(Session::getType() == "duenio") { ?>
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
        <li class="nav-item">
            <a class="nav-link" href="#dataUser">Mis Datos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#css-mine">Ver Todas las Mascotas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo FRONT_ROOT.'Guardian/showdisponibilityView/'.$user->getFullName(); ?>">Modificar Disponibilidad</a>
        </li>
        <?php } ?>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo FRONT_ROOT ?>Home/Logout">Cerrar Sesión</a>
        </li>
        <?php } else {?>
            <li class="nav-item">
            <a class="nav-link" href="<?php echo FRONT_ROOT. "Home/showduenioRegister" ?>">Registrarse como Dueño</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo FRONT_ROOT. "Home/showguardianRegister" ?>">Registrarse como Guardian</a>
        </li>
        <?php } ?>
    </ul>
</nav>