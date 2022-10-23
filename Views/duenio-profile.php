<?php
use Utils\Session;
require_once VIEWS_PATH . 'header.php';
$user = Session::getLoggedUser();
$type = $_SESSION['userType'];
include('nav-bar.php');
?>
<section class="login-block">
    <main class="py-1">
        <section id="login-block" class="mb-5">
        <?php if (Session::VerifiyBadMessage()) { ?>
            <div class="alert alert-danger alert-dismissible fade show center-block" style="text-align:center" role="alert">
                <?php echo $_SESSION['bad'];
                        unset($_SESSION['bad']); 
                    ?>
            </div>
        <?php } else {
               if (Session::VerifiyGoodMessage()) { ?>
                    <div class="alert alert-success alert-dismissible fade show center-block" style="text-align:center" role="alert">
                         <?php echo $_SESSION['good'];
                              unset($_SESSION['good']); 
                         ?>
                    </div>
               <?php }
          } ?>
        </div>
            <div class="container" id = "dataUser">
                <center> 
                    <h3 class="mb">Datos</h3>
                    <hr>
                </center>
                <div class="bg-light-alpha p-1" id = "dataUser">
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="">Nombre</label>
                            <input type="text" name="" class="form-control form-control-ml" style="text-align:center" disabled value="<?php echo $user->getFullName();  ?>">
                        </div>
                        <div class="col-lg-3">
                            <label for="">Edad</label>
                            <input type="text" name="" class="form-control form-control-ml" style="text-align:center" disabled value="<?php echo $user->getAge();  ?>">
                        </div>

                        <div class="col-lg-3">
                            <label for="">DNI</label>
                            <input type="number" name="" class="form-control form-control-ml" style="text-align:center" disabled value="<?php echo $user->getDni();  ?>">
                        </div>

                        <div class="col-lg-3">
                            <label for="">Email</label>
                            <input type="text" name="" class="form-control form-control-ml" style="text-align:center" disabled value="<?php echo $user->getEmail();  ?>">
                        </div>
                    </div>
                </div>
                <br>
            </div>
            <br>
            <div class="container" id = "css-mine">
              <br>  
            <center>
                    <h3 class="mb">Mis mascotas</h3>
                    <hr>
            </center>
            <br>
            <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 15%;">Nombre</th>
              <th style="width: 15%;">Especie</th>
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
                <td><?php echo $mascota->getTipo(); ?></td>
                <td><?php echo $mascota->getRaza(); ?></td>
                <td><?php echo $mascota->getTamanio(); ?></td>
                <td><img src="<?php echo $mascota->getFoto(); ?>" alt="" width="80px" height="60px"></td>
                <td><a href="<?php echo $mascota->getPlanVacunacion(); ?>" target="_blank">Ver Plan</a></td>
                <td><a href="<?php echo $mascota->getVideo(); ?>" target="_blank">Ver Video</a></td>

                <td>
                    <a class="btn btn-dark ml-auto" onclick="return confirm('Are you sure?')" href="<?php echo FRONT_ROOT.'Duenio/DeletePet/'.$mascota->getNombre(); ?>">Borrar</a>
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
                    <hr>
            </center>
            <br>
            <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 10%;">Nombre</th>
              <th style="width: 10%;">Edad</th>
              <th style="width: 10%;">Preferencia</th>
              <th style="width: 5%;">Reputacion</th> 
              <th style="width: 25%;">Costo por Dia</th>
              <th style="width: 5%;">Fecha inicio</th>
              <th style="width: 5%;">Fecha fin</th>
              <th style="width: 5%;">Mascotas</th>
              <th style="width: 5%;">Accion</th>
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
                    <!-- <td><?php if (count($guardian->getDisponibilidad()) == 0) {
                            echo "No tiene disponibilidad";
                        }else{
                            foreach ($guardian->getDisponibilidad() as $disponibilidad){
                                echo $disponibilidad . ' ';
                        }
                    } ?></td> -->
                    <!-- <td><?php echo $guardian->getInitDate() . " to " . $guardian->getFinishDate(); ?></td> -->
                    <td><?php echo $guardian->getRemuneracionEsperada() . ' $'; ?></td>
                    <form action="<?php echo FRONT_ROOT ?>Reserva/solicitarReservaDuenio" method="post">
                    <td><input type="date"  id="initDate"name="fechaInicio" multiple="multiple" max="<?php echo $guardian->getFinishDate() ?>" class="update-dispon" value =""  min="<?php echo date('Y-m-d') ?>" select required></td>
                    <td><input type="date" id ="endDate"name="fechaFin" multiple="multiple" max="<?php echo $guardian->getFinishDate() ?>" class="update-dispon" value =""  min="<?php echo date('Y-m-d') ?>" select required></td>
                    
                    <td><div class="col-lg-2">
                                <select name="mascota" id = "solapaDuenios">
                                    <?php foreach ($user->getMascotas() as $mascota) { ?>
                                        <option name = "mascota" value="<?php echo $mascota->getNombre(); ?>"><?php echo $mascota->getNombre(); ?></option>
                                    <?php } ?>
                                </select>
                    </div></td>
                    <td>
                        <input type="hidden" name="Duenio" value="<?php echo $user->getEmail(); ?>">
                        <input type="hidden" name="Guardian" value="<?php echo $guardian->getEmail(); ?>">
                        <input type="hidden" name="costoTotal" value="<?php echo $guardian->getRemuneracionEsperada(); ?>">
                        <button type="submit" style = "text-align:center" class="btn btn-dark">Solicitar</button>
                    </td>
                    </form>
                    <?php
            } 
            ?>
        </tbody>
        </table>
        <br>

        
            </div>
            <br> 

<div class="container" id = "css-mine">
<br>
<center><h3 class="mb">Peticiones Hechas</h3></center>
<hr>
<br>
<table style="text-align:center;">
     <thead>
     <tr>
     <th style="width: 10%;">Guardian</th>
     <th style="width: 10%;">Mascota</th>
     <th style="width: 10%;">Fecha Inicio</th>
     <th style="width: 10%;">Fecha Fin</th>
     <th style="width: 10%;">Dias</th>
     <th style="width: 10%;">Costo Total</th>
     <th style="width: 10%;">Estado</th>
     <th style="width: 10%;">Rechazar</th>
     <th style="width: 15%;">Calificar</th>
     </tr>
     </thead>
     <tbody>
     <?php foreach($this->reservaDAO->getReservasByDuenio($user->getFullName()) as $reserva){
          ?>
          <tr>
               <td><?php echo $reserva->getGuardian(); ?></td>
               <td><?php echo $reserva->getMascota(); ?></td>
               <td><?php echo $reserva->getFechaInicio(); ?></td>
               <td><?php echo $reserva->getFechaFin(); ?></td>
                <td><?php echo $reserva->getCantidadDias(); ?></td>
               <td><?php echo $reserva->getCostoTotal() . ' $' ?></td>
               <td><?php if ($reserva->getEstado() == 'Confirmado'){
                              echo "<p style=color:green>Confirmado</p>";      
                         }elseif ($reserva->getEstado() == 'Pendiente'){
                              echo "<p style=color:orange>Pendiente</p>";
                         }elseif ($reserva->getEstado() == 'Rechazado'){
                              echo "<p style=color:red>Rechazado</p>";
                         }elseif ($reserva->getEstado() == 'Completado'){
                              echo "<p style=color:blue>Completado</p>";
                         } ?></td>
               
               <td>
               <a class="btn btn-dark ml-auto" onclick="return confirm('Are you sure?')" href="<?php echo FRONT_ROOT.'Reserva/cancelarReservaDuennio/'.$reserva->getNroReserva(); ?>">Borrar</a>
               </td>
               <td>  
               <form action="<?php echo FRONT_ROOT ?>Reserva/calificarGuardian" method="post">
               <input type="hidden" name="guardian" value="<?php echo $reserva->getGuardian() ?>">
                <?php if ($reserva->getEstado() == 'Completado'){ ?>
                    <div class = "input-group">
                    <input type="number" min = "0" max ="5" name="calificacion" class="form-control col-xs-2" style="text-align:center" placeholder="5">
                    <span class="input-group-addon">-</span>
                    <button class = "btn btn-info" type="submit" onclick="return confirm('Are you sure?')" style = "text-align:center" class="btn btn-dark">Calificar</button>
                    </div>
                <?php } else { ?>
                    <div class = "input-group">
                    <input type="number" min = "0" max ="5" name="" class="form-control col-xs-2" style="text-align:center" placeholder="5" disabled>
                    <span class="input-group-addon">-</span>
                    <a class="btn btn-secondary">Calificar</a> 
                    </div>
                <?php } ?>
                </td>
                </form>
          </tr>

     <?php 
     } ?>
          
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
                    <hr>
                    <br>
                </center>
                    <form action="<?php echo FRONT_ROOT ?>Duenio/addPet" method="post">
                        <div class="row" >
                            <div class="col-lg-4">
                                <label for="">Nombre</label>
                                <input type="text" name="nombre" class="form-control form-control-ml" required>
                            </div>
                            <div class="col-lg-4">
                                <label for="" class="" id = "">Tamaño</label><br>
                                <select name="tipo" id = "tamanioSolapa">
                                    <option value="Gato" selected>Gato</option>
                                    <option value="Perro" >Perro</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="">Raza</label>
                                <input type="text" name="raza" class="form-control form-control-ml" required>
                            </div>
                            <div class="col-lg-12" style="height:15px"></div>
                            <div class="col-lg-4">
                                <label for="" class="" id = "">Tamaño</label><br>
                                <select name="tamanio" id = "tamanioSolapa">
                                    <option value="chico" selected>Chico</option>
                                    <option value="mediano" >Mediano</option>
                                    <option value="grande">Grande</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="">Foto</label>
                                <input type="url" name="foto" class="form-control form-control-ml" placeholder="Url Only" reqiured>
                            </div>
                            <div class="col-lg-4">
                                <label for="">Plan de Vacunacion</label>
                                <input type="url" name="planVacunacion" class="form-control form-control-ml" placeholder="Url Only" required>
                            </div>
                            <div class="col-lg-12" style="height:15px"></div>
                            <div class="col-lg-4">
                                <label for="">Video</label>
                                <input type="url" name="video" class="form-control form-control-ml" placeholder="Url Only" required>
                            </div>
                            <br>
                            <div class="row" id = "buttonraro" style="border: 1px solid">
                             <div class="col-lg-1" style="text-align:center">
                              <button type="submit" onclick="return confirm('Are you sure?')" style = "text-align:center" class="btn btn-dark">Agregar</button>
                    </div> 
                    </form>
                        </div>
                        <br>
                    </form>
                </div>
            </div> 
            
 </section>
