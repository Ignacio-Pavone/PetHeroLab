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
                <h3 class="mb">Agrega una nueva mascota</h3>
                <hr>
                <br>
            </center>
            <form action="<?php echo FRONT_ROOT ?>Pet/add" method="post">
                <input type="hidden" name="id_owner" value="<?php echo $user->getId(); ?>">
                <div class="row">
                    <div class="col-lg-4 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Nombre</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Nombre" name="name"
                            aria-label="Username" aria-describedby="basic-addon1" required>
                    </div>
                    <div class="col-lg-4 input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Tipo</label>
                        </div>
                        <select class="custom-select" name="type" id="inputGroupSelect01">
                            <option value="Gato" selected>Gato</option>
                            <option value="Perro">Perro</option>
                        </select>
                    </div>
                    <div class="col-lg-4 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Raza</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Raza" name="breed"
                            aria-describedby="basic-addon1" required>
                    </div>
                    <div class="col-lg-4 input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Tamaño</label>
                        </div>
                        <select class="custom-select" name="pet_size" id="inputGroupSelect01">
                            <option value="Chico">Chico</option>
                            <option value="Mediano" selected>Mediano</option>
                            <option value="Grande">Grande</option>
                        </select>
                    </div>
                    <div class="col-lg-4 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">URL</span>
                        </div>
                        <input type="text" name="photo_url" placeholder="Foto" class="form-control"
                            id="basic-url" aria-describedby="basic-addon3" required>
                    </div>
                    <div class="col-lg-4 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">URL</span>
                        </div>
                        <input type="text" name="vaccination_schedule" placeholder="Plan de Vacunacion"
                            class="form-control" id="basic-url" aria-describedby="basic-addon3" required>
                    </div>
                    <div class="col-lg-12 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">URL</span>
                        </div>
                        <input type="text" name="video_url" placeholder="Video" class="form-control"
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
    <br>



