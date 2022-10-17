<?php

use Utils\Session;

$user = Session::getLoggedUser();
$type = $_SESSION['userType'];
include('nav-bar.php');

?>

<section class="login-block">
    <main class="py-5">
        <section id="login-block" class="mb-5">
            <div class="container">
                <center>
                <br>  
                    <h4 class="mb" id = "dataUser">Datos</h4>
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
            <div class="container" id = "css-mine">
              <br>  
            <center>
                    <h4 class="mb">Mis mascotas</h4>
            </center>
            <br>
            <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 15%;">Nombre</th>
              <th style="width: 15%;">Raza</th>
              <th style="width: 15%;">Tamaño</th>
              <th style="width: 20%;">Foto</th>
              <th style="width: 10%;">Plan Vacunacion</th>
              <th style="width: 10%;">Video</th>
              <th style="width: 15%;">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($user->getMascotas() as $mascota) {
            ?>
              <tr>
                <td><?php echo $mascota->getNombre(); ?></td>
                <td><?php echo $mascota->getRaza(); ?></td>
                <td><?php echo $mascota->getTamanio(); ?></td>
                <td><img src="<?php echo $mascota->getFoto(); ?>" alt="" width="90px" height="70px"></td>
                <td><a href="<?php echo $mascota->getPlanVacunacion(); ?>" target="_blank">Ver Plan</a></td>
                <td><a href="<?php echo $mascota->getVideo(); ?>" target="_blank">Ver Video</a></td>

                <td>
                      <a style="background-color:blue; color:white; padding:2px;" href="<?php echo FRONT_ROOT.'Duenio/DeletePet/'.$mascota->getNombre(); ?>">Borrar</a>
                    
                    </td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
        <br>
            </div>
            <br>
            <div class="container" id = "addPets">
            <br>  
                <center>
                    <h4 class="mb">Agrega una nueva mascota</h4>
                </center>
                <div class="bg-light-alpha p-4 align-items-center" style = "text-align:center; display:inline-block">
                    <form  action="<?php echo FRONT_ROOT ?>Duenio/addPet" method="post">
                        <div class="column" style="width:1000px">
                            <div class="col-lg-3">
                                <label for="">Nombre</label>
                                <input type="text" name="nombre" class="form-control form-control-ml" required>
                            </div>
                            <div class="col-lg-3">
                                <label for="">Raza</label>
                                <input type="text" name="raza" class="form-control form-control-ml" required>
                            </div>
                            <div class="col-lg-3">
                                <label for="" class="">Tamaño</label><br>
                                <select name="tamanio">
                                    <option value="chico">Chico</option>
                                    <option value="mediano" selected>Mediano</option>
                                    <option value="grande">Grande</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="">Foto</label>
                                <input type="url" name="foto" class="form-control form-control-ml" reqiured>
                            </div>
                            <div class="col-lg-3">
                                <label for="">Plan de Vacunacion</label>
                                <input type="url" name="planVacunacion" class="form-control form-control-ml" required>
                            </div>
                            <div class="col-lg-3">
                                <label for="">Video</label>
                                <input type="url" name="video" class="form-control form-control-ml" required>
                            </div>
                            <br>
                            <div class="col-lg-3">
                                <button id = "addPet"type="submit" class="btn btn-primary ml-auto d-block " >Agregar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>