<?php
use Utils\Session;
$user = Session::GetLoggedUser();
$type = $_SESSION['userType'];
require_once VIEWS_PATH . 'header.php';
require_once VIEWS_PATH . 'navbars/nav-simple-bar.php';
?>
<section class="login-block" style="height:100vh">
    <main class="py-1">
        <section id="login-block" class="mb-5">
            <div class="container" id="dataUser">
                <center>
                    <h3 class="mb" id="dataUser">Agregar Mascota</h3>
                    <hr>
                </center>
            <form action="<?php echo FRONT_ROOT ?>Pet/add" method="post">
                <input type="hidden" name="id_owner" value="<?php echo $user->getId(); ?>">
                <div class="row">
                    <div class="col-lg-4 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon1">Nombre</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Nombre" name="name"
                            aria-label="Username" aria-describedby="basic-addon1" required>
                    </div>
                    <div class="col-lg-4 input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="btn btn-md btn-dark m-0 px-3" for="inputGroupSelect01">Tipo</label>
                        </div>
                        <select class="custom-select" name="type" id="inputGroupSelect01">
                            <option value="Gato" selected>Gato</option>
                            <option value="Perro">Perro</option>
                        </select>
                    </div>
                    <div class="col-lg-4 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon1">Raza</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Raza" name="breed"
                            aria-describedby="basic-addon1" required>
                    </div>
                    <div class="col-lg-4 input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="btn btn-md btn-dark m-0 px-3" for="inputGroupSelect01">Tamaño</label>
                        </div>
                        <select class="custom-select" name="pet_size" id="inputGroupSelect01">
                            <option value="Chico">Chico</option>
                            <option value="Mediano" selected>Mediano</option>
                            <option value="Grande">Grande</option>
                        </select>
                    </div>
                    <div class="col-lg-4 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon3">URL</span>
                        </div>
                        <input type="url" name="photo_url" placeholder="Foto" class="form-control"
                            id="basic-url" aria-describedby="basic-addon3" required>
                    </div>
                    <div class="col-lg-4 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon3">URL</span>
                        </div>
                        <input type="url" name="vaccination_schedule" placeholder="Plan de Vacunacion"
                            class="form-control" id="basic-url" aria-describedby="basic-addon3" required>
                    </div>
                    <div class="col-lg-12 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon3">URL</span>
                        </div>
                        <input type="url" name="video_url" placeholder="Video" class="form-control"
                            id="basic-url" aria-describedby="basic-addon3" required>
                    </div>
                    <div class="row" id="buttonraro" style="margin-left: 460px; border: 1px solid">
                        <div class="col-lg-1" style="text-align:center">
                            <button type="submit" onclick="return confirm('Are you sure?')"
                                    style="text-align:center" class="btn btn-login">Agregar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div> 
    </main>




