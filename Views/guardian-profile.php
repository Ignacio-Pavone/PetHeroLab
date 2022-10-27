<?php
use Utils\Session;
require_once VIEWS_PATH . 'header.php';
$user = Session::GetLoggedUser();
$type = $_SESSION['userType'];
include('nav-bar.php');
?>
<section class="login-block">
    <main class="py-1">
        <section id="login-block" class="mb-4">
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
                              unset($_SESSION['good']); ?>
            </div>
            <?php }
               } ?>
            </div>
            <div class="container" id="dataUser">
                <center>
                    <h3 class="mb">Datos del Usuario</h3>
                </center>
                <hr>
                <div class="bg-light-alpha p-4">
                    <div class="row">

                        <div class="col-lg-3 input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon1">Nombre</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Nombre" name="nombre" aria-label="Username" aria-describedby="basic-addon1"
                            disabled value="<?php echo $user->getFullName();?>">
                        </div>
                        <div class="col-lg-2 input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon1">Edad</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Nombre" name="nombre" aria-label="Username" aria-describedby="basic-addon1"
                            disabled value="<?php echo $user->getAge();?>">
                        </div>
                        <div class="col-lg-3 input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="btn btn-md btn-dark m-0 px-3"  id="basic-addon1">DNI</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Nombre" name="nombre" aria-label="Username" aria-describedby="basic-addon1"
                            disabled value="<?php echo $user->getDni();  ?>">
                        </div>
                        <div class="col-lg-4 input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon1">Email</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Nombre" name="nombre" aria-label="Username" aria-describedby="basic-addon1"
                            disabled value="<?php echo $user->getEmail();  ?>">
                        </div>

                        <div class="col-lg-6 input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon1">Tipo de Mascotas a Cuidar</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Tamaño" name="tipoMascota" style="text-align:center" aria-describedby="basic-addon1"
                            disabled value="<?php echo $user->getTipoMascota();  ?>">
                        </div>

                        <div class="col-lg-6 input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon1">Remuneracion Esperada</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Nombre" name="remuneracionEsperada" style="text-align:center" aria-label="Username" aria-describedby="basic-addon1"
                            disabled value="<?php echo $user->getRemuneracionEsperada() . " $"; ?>">
                        </div>

                        <div class="col-lg-6 input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon1">Fecha Inicio</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Inicio" name="fechainicio" style="text-align:center" aria-describedby="basic-addon1"
                            disabled value="<?php echo $user->getInitDate() ?>">
                        </div>

                        <div class="col-lg-6 input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon1">Fecha Fin</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Fin" name="fechafin" style="text-align:center" aria-describedby="basic-addon1"
                            disabled value="<?php echo $user->getFinishDate() ?>">
                        </div>
                        
                    </div>
                </div>
            <div class="divEstado">
            <p class="circulo" style="background:orange;"> </p><label style="padding-left:5px;padding-right:15px;" for="">Entre 4 y 5</label>
            <p class="circulo" style="background:green;"> </p><label style="padding-left:5px;padding-right:15px;" for="">Entre 3 y 4</label>
            <p class="circulo" style="background:red;"> </p><label style="padding-left:5px; padding-right:15px;" for="">Entre 0 y 3</label>  
            <p class="circulo" style="background:black;"></p><label style="padding-left:5px; padding-right:15px;" for="">Sin calificaciones</label> 
             </div>
        </section>
        <div class="container" id="css-mine"  style="overflow-y:scroll; height: 350px;">
            <br>
            <center>
                <h3 class="mb">Peticiones Recibidas</h3>
            </center>
            <hr>
            <br>
            <table style="text-align:center;">
                <thead>
                    <tr>
                        <th style="width: 15%;">Dueño</th>
                        <th style="width: 15%;">Mascota</th>
                        <th style="width: 15%;">Tipo</th>
                        <th style="width: 20%;">Fecha Inicio</th>
                        <th style="width: 20%;">Fecha Fin</th>
                        <th style="width: 20%;">Ganancia</th>
                        <th style="width: 20%;">Aceptar</th>
                        <th style="width: 20%;">Rechazar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservas as $reserva) {
                              if ($reserva->getEstado() == "Pendiente") { ?>
                    <tr>
                        <?php foreach ($duenios as $duenio){
                            if ($duenio->getIdDuenio() == $reserva->getDuenio()) { ?>
                        <td><?php echo $duenio->getFullName(); ?></td>
                        <?php } } ?>
                        <?php foreach ($todaslasmascotas as $mascota){
                            if ($mascota->getIdMascota() == $reserva->getMascota()) { ?>
                        <td><?php echo $mascota->getNombre(); break; ?></td>
                        <?php } } ?>
                        <td><?php echo $reserva->getTipo(); ?></td>
                        <td><?php echo $reserva->getFechaInicio(); ?></td>
                        <td><?php echo $reserva->getFechaFin(); ?></td>
                        <td><?php echo $reserva->getCostoTotal() . ' $'; ?></td>
                        <td>
                            <a class="btn btn-dark ml-auto" onclick="return confirm('Are you sure?')"
                                href="<?php echo FRONT_ROOT . 'Reserva/aceptarReservaGuardian/' . $reserva->getNroReserva() ?>">Aceptar</a>
                        </td>
                        <td>
                            <a class="btn btn-dark ml-auto" onclick="return confirm('Are you sure?')"
                                href="<?php echo FRONT_ROOT . 'Reserva/rechazarReservaGuardian/' . $reserva->getNroReserva(); ?>">Rechazar</a>
                        </td>
                    </tr>
                    <?php }
                         } ?>
                </tbody>
            </table>
            <br>
        </div>
        <br>
        <div class="container" id="css-mine" style="overflow-y:scroll; height: 400px;">
            <br>
            <center>
                <h3 class="mb">Historial Reservas</h3>
            </center>
            <hr>
            <table style="text-align:center;">
                <br>
                <thead>
                    <tr>
                        <th style="width: 10%;">Dueño</th>
                        <th style="width: 10%;">Mascota</th>
                        <th style="width: 10%;">Fecha Inicio</th>
                        <th style="width: 10%;">Fecha Fin</th>
                        <th style="width: 10%;">Calificacion</th>
                        <th style="width: 10%;">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php foreach ($reservas as $reserva) {?>
                    <tr>
                    <?php
                    if ($reserva->getEstado() != 'Pendiente'){
                    foreach ($duenios as $duenio){
                            if ($duenio->getIdDuenio() == $reserva->getDuenio()) { ?>
                        <td><?php echo $duenio->getFullName(); ?></td>
                        <?php } } ?>
                        <?php foreach ($todaslasmascotas as $mascota){
                            if ($mascota->getIdMascota() == $reserva->getMascota()) { ?>
                        <td><?php echo $mascota->getNombre(); ?></td>
                        <?php } } ?>
                        <td><?php echo $reserva->getFechaInicio(); ?></td>
                        <td><?php echo $reserva->getFechaFin(); ?></td>
                        <td><?php echo $reserva->getCalificacion(); ?></td>
                        <td class=""><?php if ($reserva->getEstado() == 'Confirmado') {
                                             ?> <label class="circulo" style="background:green;"> <?php
                                        } elseif ($reserva->getEstado() == 'Pendiente') {
                                        ?> <label class="circulo" style="background:orange;"> <?php
                                        } elseif ($reserva->getEstado() == 'Rechazado') {
                                             ?> <label class="circulo" style="background:red;"> <?php
                                        } elseif ($reserva->getEstado() == 'Completo') {
                                             ?> <label class="circulo" style="background:blue;"> <?php
                                        } elseif ($reserva->getEstado() == 'Calificado') {
                                             ?> <label class="circulo" style="background:purple;"> <?php
                                        }  elseif ($reserva->getEstado() == 'En Curso') {
                                             ?> <label class="circulo" style="background:pink;"> </td>
                                         <?php } ?> 
                                        </td>
                    </tr>
                    <?php
                         } } ?>
                </tbody>
          </table>
          <br>
          <br>
            <div class="divEstado">
               <p class="circulo" style="background:orange;"> </p><label style="padding-left:5px;padding-right:15px;" for="">Pendiente</label>
               <p class="circulo" style="background:green;"> </p><label style="padding-left:5px; padding-right:15px;" for="">Confirmado</label> 
               <p class="circulo" style="background:pink;"> </p><label style="padding-left:5px;padding-right:15px;" for="">En Curso</label>
               <p class="circulo" style="background:blue;"> </p><label style="padding-left:5px;padding-right:15px;" for="">Completo</label>               
               <p class="circulo" style="background:purple;"> </p><label style="padding-left:5px;padding-right:15px;" for="">Calificado</label> 
               <p class="circulo" style="background:red;"> </p><label style="padding-left:5px;padding-right:15px;" for="">Rechazado</label>
            </div>
            <br>
        </div>
    </main>