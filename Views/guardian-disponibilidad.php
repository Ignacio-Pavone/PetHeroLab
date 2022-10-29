<?php

use Utils\Session;

$user = Session::GetLoggedUser();
require_once VIEWS_PATH . 'header.php';
$type = $_SESSION['userType'];
include('nav-simple-bar.php');
?>

<section id="disponibilidadSection" class="login-block">
    <main class="py-5">

        <form action="<?php echo FRONT_ROOT ?>Guardian/ModifyAvailability" method="post">
            <div class="container" id="dataUser">
                <center>
                    <h3 class="mb" id="dataUser">Modificar Disponibilidad Guardian</h3>
                    <hr>
                </center>
                <table style="text-align:center;">
                    <?php if (Session::VerifiyBadMessage()) { ?>
                        <div class="alert alert-danger alert-dismissible fade show center-block"
                             style="text-align:center" role="alert">
                            <?php echo $_SESSION['bad'];
                            unset($_SESSION['bad']);
                            ?>
                        </div>
                    <?php } else {
                        if (Session::VerifiyGoodMessage()) { ?>
                            <div class="alert alert-success alert-dismissible fade show center-block"
                                 style="text-align:center" role="alert">
                                <?php echo $_SESSION['good'];
                                unset($_SESSION['good']);
                                ?>
                            </div>
                        <?php }
                    } ?>
                    <thead>
                    <tr>
                        <th style="width: 16%;">Fecha Inicio</th>
                        <th style="width: 16%;">Fecha Fin</th>
                    </tr>
                    </thead>
                    <tbody align="center">
                    <tr>
                        <input type="hidden" name="guardianEmail" class="update-dispon"
                               value=<?php echo $user->getEmail() ?>>
                        <td><input type="date" name="initDate" class="update-dispon"
                                   value="<?php echo $user->getInitDate() ?>" id="initDate"
                                   min="<?php echo date('Y-m-d') ?>" select></td>
                        <td><input type="date" name="finishDate" class="update-dispon"
                                   value="<?php echo $user->getFinishDate() ?>" id="finishDate"
                                   min="<?php echo date('Y-m-d') ?>"></td>
                    </tr>
                    </tbody>
                </table>
                <br>
                <div class="row-lg-1" style="text-align:center">
                    <button type="submit" onclick="return confirm('Are you sure?')" style="text-align:center"
                            class="btn btn-login">Modificar
                    </button>
                </div>
            </div>
        </form>

    </main>

                        
    