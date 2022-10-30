<?php
include_once 'back-bar.php';
require_once VIEWS_PATH . 'header.php';
?>
<section class="login-block" style="height:100vh;">
    <div class="container">
        <div class="row">
            <div class="col-md-4 login-sec">
                <h2 class="text-center">Pet Hero</h2>
                <div class="col-lg-12" style="height:10px;"></div>
                <hr>

                <form class="register-guardian-form" action="<?php echo FRONT_ROOT . "Guardian/register" ?>"
                      method="POST">
                    <div class="col-lg-12 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon1">Mail</span>
                        </div>
                        <input type="email" class="form-control" placeholder="example@mail.com" name="email"
                               aria-label="Username"
                               aria-describedby="basic-addon1" required>
                    </div>

                    <div class="col-lg-12 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon1">Password</span>
                        </div>
                        <input type="password" class="form-control" placeholder="******" name="password"
                               aria-label="Username"
                               aria-describedby="basic-addon1" required>
                    </div>

                    <div class="col-lg-12 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon1">Edad</span>
                        </div>
                        <input type="number" min="18" max="100" class="form-control" placeholder=">18" name="age"
                               aria-describedby="basic-addon1" required>
                    </div>

                    <div class="col-lg-12 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon1">Nombre Completo</span>
                        </div>
                        <input type="text" class="form-control" placeholder="John Doe" name="fullname"
                               aria-describedby="basic-addon1" required>
                    </div>

                    <div class="col-lg-12 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon1">DNI</span>
                        </div>
                        <input type="text" class="form-control" placeholder="DNI" name="dni"
                               aria-describedby="basic-addon1" required>
                    </div>

                    <div class="col-lg-12 input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="btn btn-md btn-dark m-0 px-3" for="inputGroupSelect01">Tamaño</label>
                        </div>
                        <select class="custom-select" name="tipoMascota" id="inputGroupSelect01">
                            <option value="Chico">Chico</option>
                            <option value="Mediano" selected>Mediano</option>
                            <option value="Grande">Grande</option>
                        </select>
                    </div>

                    <div class="col-lg-12 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon1">Remuneracion</span>
                        </div>
                        <input type="number" class="form-control" placeholder="Remuneracion Esperada" name="fee"
                               aria-describedby="basic-addon1" min="1" required>
                    </div>

                    <hr>
                    <br>

                    <div class="form-check">
                        <button type="submit" class="btn btn-login float-right" id="submitGuardianButton"
                                onclick="">Registrarse como Guardian
                        </button>
                    </div>


                </form>
            </div>
            <div class="col-md-8 banner-sec">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>