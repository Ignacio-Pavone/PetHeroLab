<?php
use Utils\Session;
use Utils\EReserva as EReserva;
require_once VIEWS_PATH . 'header.php';
$user = Session::GetLoggedUser();
$type = $_SESSION['userType'];
include('nav-bar.php');
?>
<section class="login-block"> 
<main class="py-1">
     <section id="login-block" class="mb-4">
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
          <div class="container">   
          <center><h3 class="mb" id = "dataUser">Datos del Usuario</h3></center>
          <hr>
               <div class="bg-light-alpha p-4" id = "dataUser">
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
                         <div class="col-lg-12" style="height:15px"></div>
                         <div class="col-lg-4">
                              <label for="">Tipo de Mascotas a Cuidar</label>
                              <input type="text" name="tipoMascota" class="form-control form-control-ml" style="text-align:center" disabled value="<?php echo $user->getTipoMascota();  ?>">
                         </div>

                         <div class="col-lg-4">
                              <label for="">Remuneracion Esperada</label>
                              <input type="text" name="remuneracionEsperada" style="text-align:center" class="form-control form-control-ml" disabled value="<?php echo $user->getRemuneracionEsperada() . " $";  ?>">
                         </div>

                         <div class="col-lg-4" >
                              <label for="">Disponibilidad</label>
                              <input type="text" name="remuneracionEsperada" class="form-control form-control-ml" disabled value="<?php   
                              if (count($user->getDisponibilidad()) == 0) echo 'No hay dias elegidos.';
                              else {
                                  $array = $user->getDisponibilidad();
                                     foreach ($array as $key => $value) {
                                          echo $value . ' ';
                                     }
                              }                             
                              ?>">
                         </div>
                         <div class="col-lg-12" style="height:15px"></div>
                         <div class="col-lg-6" >
                              <label for="">Fecha Incio</label>
                              <input type="text" name="fechainicio" style="text-align:center;" class="form-control form-control-ml" disabled value="<?php   
                                   echo $user->getInitDate();
                              ?>">
                         </div>
                         <div class="col-lg-6" >
                              <label for="">Fecha Fin</label>
                              <input type="text" name="fechafin" style="text-align:center;" class="form-control form-control-ml" disabled value="<?php echo $user->getFinishDate();
                              ?>">
                         </div>
                    </div> 
          </div>
     </section>
          <div class="container" id = "css-mine">
          <br>  
          <center>
               <h3 class="mb">Todas las mascotas con tamaño <?php echo $user->getTipoMascota()?></h3>
               <hr>
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
          foreach ($this->duenioDAO->filtrarMascotasporTamanio($user->getTipoMascota()) as $mascota) {
          ?>
          <tr>
               <td><?php echo $mascota->getNombre(); ?></td>
               <td><?php echo $mascota->getRaza(); ?></td>
               <td><?php echo $mascota->getTamanio(); ?></td>
               <td><img src="<?php echo $mascota->getFoto(); ?>" alt="" width="90px" height="70px"></td>
               <td><a href="<?php echo $mascota->getPlanVacunacion(); ?>" target="_blank">Ver Plan</a></td>
               <td><a href="<?php echo $mascota->getVideo(); ?>" target="_blank">Ver Video</a></td>
               <td><a class="btn btn-dark ml-auto" href="<?php ?>">Cuidar</a></td>
          </tr>
          <?php } ?>
          </tbody>
          </table>
          <br> 
          </div>
          
          <br> 

          <div class="container" id = "css-mine">
          <br>
          <center><h3 class="mb">Peticiones Recibidas</h3></center>
          <hr>
          <br>
          <table style="text-align:center;">
               <thead>
               <tr>
               <th style="width: 15%;">Dueño</th>
               <th style="width: 15%;">Mascota</th>
               <th style="width: 15%;">Tipo</th>
               <th style="width: 20%;">fechaInicio</th>
               <th style="width: 20%;">fechaFin</th>
               <th style="width: 20%;">Costo</th>
               <th style="width: 20%;">Aceptar</th>
               <th style="width: 20%;">Rechazar</th>
               </tr>
               </thead>
               <tbody>
               <?php foreach($this->reservaDAO->getReservasByGuardian($user->getFullName()) as $reserva){
                    if ($reserva->getEstado() == "Pendiente"){ ?>
                    <tr>
                         <td><?php echo $reserva->getDuenio(); ?></td>
                         <td><?php echo $reserva->getMascota(); ?></td>
                         <td><?php echo $reserva->getTipo(); ?></td>
                         <td><?php echo $reserva->getFechaInicio(); ?></td>
                         <td><?php echo $reserva->getFechaFin(); ?></td>
                         <td><?php echo $reserva->getCostoTotal(); ?></td>
                         <td> 
                         <a class="btn btn-dark ml-auto" onclick="return confirm('Are you sure?')" href="<?php echo FRONT_ROOT.'Reserva/aceptarReservaGuardian/'.$reserva->getNroReserva()?>">Aceptar</a>
                         </td>
                         <td>
                         <a class="btn btn-dark ml-auto" onclick="return confirm('Are you sure?')" href="<?php echo FRONT_ROOT.'Reserva/rechazarReservaGuardian/'.$reserva->getNroReserva(); ?>">Rechazar</a>
                         </td>
                         
                    </tr>

               <?php }
               } ?>
               </tbody>
          </table>
          <br> 
          </div>
          
          <br> 
          <div class="container" id = "css-mine">
               <br>
          <center><h3 class="mb">Historial Reservas</h3></center>
          <hr>
          <table style="text-align:center;">
          <br>
               <thead>
               <tr>
               <th style="width: 10%;">Dueño</th>
               <th style="width: 10%;">Mascota</th>
               <th style="width: 10%;">Fecha Inicio</th>
               <th style="width: 10%;">Fecha Fin</th>
               <th style="width: 10%;">Estado</th>
               </tr>
               </thead>
               <tbody>
               <?php foreach($this->reservaDAO->getReservasByGuardian($user->getFullName()) as $reserva){ ?>
                    <tr>
                         <td><?php echo $reserva->getDuenio(); ?></td>
                         <td><?php echo $reserva->getMascota(); ?></td>
                         <td><?php echo $reserva->getFechaInicio(); ?></td>
                         <td><?php echo $reserva->getFechaFin(); ?></td>
                         <td><?php if ($reserva->getEstado() == 'Confirmado'){
                              echo "<p style=color:green>Confirmado</p>";      
                         }elseif ($reserva->getEstado() == 'Pendiente'){
                              echo "<p style=color:orange>Pendiente</p>";
                         }elseif ($reserva->getEstado() == 'Rechazado'){
                              echo "<p style=color:red>Rechazado</p>";
                         }elseif ($reserva->getEstado() == 'Completado'){
                              echo "<p style=color:blue>Completado</p>";
                         } ?></td>
                    </tr>

               <?php 
               } ?>
               </tbody>
          </table>
          <br> 
          </div>
</main>