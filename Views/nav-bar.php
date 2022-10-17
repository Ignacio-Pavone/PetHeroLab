<?php
$user = $_SESSION["loggedUser"];
?>
<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
    <span class="navbar-text">
        <strong>TP FINAL Welcome - <?php echo $user->getFullName() ?></strong>
    </span>
    <ul class="navbar-nav ml-auto">
    <li class="nav-item">
            <a class="nav-link" href="#dataUser">Mis Datos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#myPets">Ver Mascotas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#addPets">Agregar Mascotas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo FRONT_ROOT ?>Home/Logout">Cerrar Sesión</a>
        </li>
    </ul>
</nav>