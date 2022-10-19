
<?php

use Utils\Session;
$user = Session::GetLoggedUser();
$type = $_SESSION['userType'];
include('nav-bar.php');
$value = null;
?>
<section class="login-block"> 
<main class="py-5">
     <section id="login-block" class="mb-5">
          <div class="container">   
          <center><h3 class="mb" id = "dataUser">Datos del Usuario</h3></center>
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
                         <div class="col-lg-12" style="height:15px"></div>
                         <div class="col-lg-3">
                              <label for="">Tipo de Mascotas a Cuidar</label>
                              <input type="text" name="tipoMascota" class="form-control form-control-ml" disabled value="<?php echo $user->getTipoMascota();  ?>">
                         </div>

                         <div class="col-lg-3">
                              <label for="">Remuneracion Esperada</label>
                              <input type="text" name="remuneracionEsperada" class="form-control form-control-ml" disabled value="<?php echo $user->getRemuneracionEsperada();  ?>">
                         </div>

                         <div class="col-lg-5" >
                              <label for="">Disponibilidad</label>
                              <input type="text" name="remuneracionEsperada" class="form-control form-control-ml" disabled value="
                              <?php   
                              if (count($user->getDisponibilidad()) == 0) echo 'No hay dias elegidos.';
                              else {
                                   foreach ($user->getDisponibilidad() as $value) {
                                        for ($i=0; $i < count($value); $i++) { 
                                             if ($value[$i] != null) {
                                             echo $value[$i];
                                             if ($i != count($value)-1) echo ',';
                                        }
                                        }
                                        
                                   }
                              }                             
                              ?>">
                         </div>
                    </div> 
          </div>
     </section>
     <section id="login-block" class="mb-5">
          <div class="container">   
          <br>
          <center><h3 class="mb " id = "modificar">Modificar Disponibilidad</h3></center>
               <div class="bg-light-alpha p-4">
               <form action="<?php echo FRONT_ROOT. "Auth/setDiaDisponible"?>" method="POST">
                    <div class="row align-items-start mx-auto"  >
                         <div class="input-group col-lg-4" >
                              <label id="label" for="">Lunes</label>
                              <input type="checkbox" name="dia_lunes" class="form-control form-control-ml" value="lunes">
                         </div>

                         <div class="input-group col-lg-4">
                              <label id="label" for="">Martes</label>
                              <input type="checkbox" name="dia_martes" class="form-control form-control-ml" value="martes">
                         </div>

                         <div class="input-group col-lg-4">
                              <label id="label" for="">Miercoles</label>
                              <input type="checkbox" name="dia_miercoles" class="form-control form-control-ml" value="miercoles">
                         </div>
                         <div class="col-lg-12" style="height:15px"></div>
                         <div class="input-group col-lg-4">
                              <label id="label" for="">Jueves</label>
                              <input type="checkbox" name="dia_jueves" class="form-control form-control-ml" value="jueves">
                         </div>

                         <div class="input-group col-lg-4">
                              <label id="label" for="">Viernes</label>
                              <input type="checkbox" name="dia_viernes" class="form-control form-control-ml" value="viernes">
                         </div>

                         <div class="input-group col-lg-4">
                              <label id="label" for="">Sabado</label>
                              <input type="checkbox" name="dia_sabado" class="form-control form-control-ml" value="sabado">
                         </div>
                         <div class="col-lg-12" style="height:15px"></div>
                         <div class="input-group col-lg-12">
                              <label style="margin-left:353px" id="label" for="">Domingo</label>
                              <input style="margin-right:353px" type="checkbox" name="dia_domingo" class="form-control form-control-ml" value="domingo">
                         </div>
                         <div class="col-lg-12">
                              <button type="submit" class="btn btn-dark ml-auto d-block">Modificar</button>
                         </div>
                    </div> 
                    <div class="row">
                         
                    </form>
                    </div>
               </div>
          </div>
</section>

<div class="container" id = "css-mine">
              <br>  
            <center>
                    <h3 class="mb">Todas las mascotas con tamaño <?php echo $user->getTipoMascota()?></h3>
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

                <td>
               <a class="btn btn-dark ml-auto " href="<?php echo FRONT_ROOT.'Duenio/Cuidar/'.$mascota->getNombre(); ?>">Cuidar</a>
               </td>
              </tr>
            <?php
            } 
            ?>
          </tbody>
        </table>

        
        <br>

        
</main>


