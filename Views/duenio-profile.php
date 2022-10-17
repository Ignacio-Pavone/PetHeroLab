<?php
$user = $_SESSION['loggedUser'];
$type = $_SESSION['userType'];

?>

<section class="login-block">
    <main class="py-5">
        <section id="login-block" class="mb-5">
            <div class="container">
                <center>
                    <h3 class="mb">Bienvenido, <?php echo $user->getFullName(); ?>!</h3>
                </center>
                <center>
                    <h4 class="mb">Aca estan tus datos</h4>
                </center>
                <div class="bg-light-alpha p-4">
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="">Nombre</label>
                            <input type="text" name="" class="form-control form-control-ml" disabled value="<?php echo $user->getFullName();  ?>">
                        </div>

                        <div class="col-lg-2">
                            <label for="">Edad</label>
                            <input type="text" name="" class="form-control form-control-ml" disabled value="<?php echo $user->getAge();  ?>">
                        </div>

                        <div class="col-lg-3">
                            <label for="">DNI</label>
                            <input type="number" name="" class="form-control form-control-ml" disabled value="<?php echo $user->getDni();  ?>">
                        </div>

                        <div class="col-lg-3">
                            <label for="">Email</label>
                            <input type="text" name="" class="form-control form-control-ml" disabled value="<?php echo $user->getEmail();  ?>">
                        </div>

                    </div>
                </div>
            </div>
            <br>
            <div class="container">
                <center>
                    <h4 class="mb">Agrega una nueva mascota</h4>
                </center>
                <div class="bg-light-alpha p-4">
                    <form action="<?php echo FRONT_ROOT ?>Duenio/addPet" method="post">
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="">Nombre</label>
                                <input type="text" name="nombre" class="form-control form-control-ml" required>
                            </div>
                            <div class="col-lg-3">
                                <label for="">Raza</label>
                                <input type="text" name="raza" class="form-control form-control-ml" required>
                            </div>
                            <div class="col-lg-3">
                                <label for="" class="">Tamaño</label>
                                <select name="tamanio">
                                    <option value="chico">Chico</option>
                                    <option value="mediano" selected>Mediano</option>
                                    <option value="grande">Grande</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="">Foto</label>
                                <input type="file" name="foto" class="form-control form-control-ml" reqiured>
                            </div>
                            <div class="col-lg-3">
                                <label for="">Plan de Vacunacion</label>
                                <input type="file" name="planVacunacion" class="form-control form-control-ml" required>
                            </div>
                            <div class="col-lg-3">
                                <label for="">Video</label>
                                <input type="file" name="video" class="form-control form-control-ml" required>
                            </div>
                            <div class="col-lg-3">
                                <button type="submit" class="btn btn-primary ml-auto d-block">Agregar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>