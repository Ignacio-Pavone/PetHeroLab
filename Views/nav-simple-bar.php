<?php
use Utils\Session;
$user = Session::GetLoggedUser();
?>

<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
    <span class="navbar-text">
        <strong>TP FINAL Welcome - <?php echo $user->getFullName() ?></strong>
    </span>
    <ul class="navbar-nav ml-auto">
    <?php if (Session::getType() == "guardian") { ?>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo FRONT_ROOT ?>Auth/showGuardianProfile">Volver al perfil</a>
        </li>
        <?php }else{?>
            <li class="nav-item">
            <a class="nav-link" href="<?php echo FRONT_ROOT ?>Auth/showDuenioProfile">Volver al perfil</a>
        </li>
        <?php } ?>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo FRONT_ROOT ?>Home/Logout">Cerrar Sesión</a>
        </li>
    </ul>
</nav>