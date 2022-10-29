<?php
use Utils\Session;
require_once VIEWS_PATH . 'header.php';
include_once 'nav-bar.php';
?>
<section id="disponibilidadSection" class="login-block">
    <main class="py-5">
        <form action="<?php echo FRONT_ROOT . "Auth/login" ?>" method="POST">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 login-sec">
                        <h2 class="text-center">Pet Hero</h2>
                        <div class="col-lg-12" style="height:10px"></div>
                        <hr>
                        <div class="col-lg-12 input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="btn btn-dark" id="basic-addon1">Email</span>
                            </div>
                            <input type="text" class="form-control" name="email" aria-describedby="basic-addon1"
                                   placeholder="pethero@gmail.com" required>
                        </div>

                        <div class="col-lg-12 input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="btn btn-dark" id="basic-addon1">Password</span>
                            </div>
                            <input type="password" class="form-control" name="password" aria-describedby="basic-addon1"
                                   placeholder="*******" required>
                        </div>
                        <hr>
                        <br>
                        <div>
                        <p class="forgotpass" ><a href="<?php echo FRONT_ROOT . "Auth/forgotPassword" ?>">Olvidé mi
                                contraseña</a></p>
                            <button type="submit" class="btn btn-login float-right">Ingresar</button>
                        </div>

                    </div>
                    <div class="col-md-8 banner-sec">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            </ol>
                        </div>

                    </div>

        </form>
        <?php if (Session::VerifiyBadMessage()) { ?>
            <div class="alert alert-danger alert-dismissible fade show center-block" style="text-align:center"
                 role="alert">
                <?php echo $_SESSION['bad'];
                unset($_SESSION['bad']);
                ?>
            </div>
        <?php } else {
            if (Session::VerifiyGoodMessage()) { ?>
                <div class="alert alert-success alert-dismissible fade show center-block" style="text-align:center"
                     role="alert">
                    <?php echo $_SESSION['good'];
                    unset($_SESSION['good']);
                    ?>
                </div>
            <?php }
        } ?>

    </main>
