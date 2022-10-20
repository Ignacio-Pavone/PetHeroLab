<?php
use Utils\Session;
$user = Session::getLoggedUser();
$type = $_SESSION['userType'];
include('nav-bar.php');
?>

<section class="login-block">
    <main class="py-1">
        <section id="login-block" class="mb-5">
            <div class="container" id = "dataUser">
                <center> 
                    <h3 class="mb" id = "dataUser">Datos</h3>
                </center>
                <div class="bg-light-alpha p-4" id = "dataUser">
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="">Nombre</label>
                            <input type="text" name="" class="form-control form-control-ml" disabled value="<?php echo $user->getFullName();  ?>">
                        </div>

                        <div class="col-lg-3">
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
                    <h3 class="mb">Mis mascotas</h3>
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
              <th style="width: 15%;">Borrar Mascota</th>
              <th style="width: 15%;">Actualizar Mascota</th>
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
                    <a class="btn btn-dark ml-auto" href="<?php echo FRONT_ROOT.'Duenio/DeletePet/'.$mascota->getNombre(); ?>">Borrar</a>
                </td>
                <td>
                    <a class="btn btn-dark ml-auto" href="<?php echo FRONT_ROOT.'Duenio/UpdatePet/'.$mascota->getNombre() ?>">Actualizar</a>
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
            <div>
            <div class="container" id = "css-mine1">
              <br>  
            <center>
                    <h3 class="mb">Guardianes</h3>
            </center>
            <br>
            <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 10%;">Nombre</th>
              <th style="width: 10%;">Edad</th>
              <th style="width: 15%;">Preferencia</th>
              <th style="width: 5%;">Reputacion</th>
              <th style="width: 10%;">Disponibilidad</th>
              <th style="width: 30%;">Fechas</th>
              <th style="width: 5%;">Costo</th>
              <th style="width: 20%;">Accion</th>
            </tr>
          </thead>
          <tbody>
              <?php
              foreach ($this->guardianDAO->GetAllGuardians() as $guardian) {
                ?>
                    <tr>
                    <td><?php echo $guardian->getFullName(); ?></td>
                    <td><?php echo $guardian->getAge(); ?></td>
                    <td><?php echo $guardian->getTipoMascota(); ?></td>
                    <td><?php echo $guardian->getReputacion(); ?></td>                  
                    <td><?php 
                        if (count($guardian->getDisponibilidad()) == 0) {
                            echo "No tiene disponibilidad";
                        }else{
                            foreach ($guardian->getDisponibilidad() as $disponibilidad){
                                echo $disponibilidad . ' ';
                        }
                    
                    } ?></td>
                    <td><?php echo $guardian->getInitDate() . " | " . $guardian->getFinishDate(); ?></td>
                    <td><?php echo $guardian->getRemuneracionEsperada() . ' $'; ?></td>
                    <td>
                    <a class="btn btn-dark ml-auto" href="<?php echo FRONT_ROOT.'Duenio/NADA/'.$guardian->getFullName(); ?>">NADA</a>
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
            <section id="login-block" class="mb-5">
            <div class="container" id = "addPetsDuenio">
            <br>  
                <center>
                    <h3 class="mb">Agrega una nueva mascota</h3>
                    <br>
                </center>
                    <form action="<?php echo FRONT_ROOT ?>Duenio/addPet" method="post">
                        <div class="row" style="width:1000px">
                            <div class="col-lg-3">
                                <label for="">Nombre</label>
                                <input type="text" name="nombre" class="form-control form-control-ml" required>
                            </div>
                            <div class="col-lg-3">
                                <label for="">Raza</label>
                                <input type="text" name="raza" class="form-control form-control-ml" required>
                            </div>
                            <div class="col-lg-3">
                                <label for="" class="" id = "">Tamaño</label><br>
                                <select name="tamanio" id = "tamanioSolapa">
                                    <option value="chico" selected>Chico</option>
                                    <option value="mediano" >Mediano</option>
                                    <option value="grande">Grande</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="">Foto</label>
                                <input type="url" name="foto" class="form-control form-control-ml" placeholder="Url Only" reqiured>
                            </div>
                            <div class="col-lg-3">
                                <label for="">Plan de Vacunacion</label>
                                <input type="url" name="planVacunacion" class="form-control form-control-ml" placeholder="Url Only" required>
                            </div>
                            <div class="col-lg-3">
                                <label for="">Video</label>
                                <input type="url" name="video" class="form-control form-control-ml" placeholder="Url Only" required>
                            </div>
                            <br>
                            <div class="row" id = "buttonraro" style="border: 1px solid">
                             <div class="col-lg-1" style="text-align:center">
                              <button type="submit" style = "text-align:center" class="btn btn-dark">Agregar</button>
                    </div> 
                    </form>
                        </div>
                        <br>
                    </form>

                </div>
            </div> 
 </section>
