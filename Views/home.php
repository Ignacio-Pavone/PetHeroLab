
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
          <center><h3 class="mb">Datos del Usuario</h3></center>
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
                         
                         <div class="col-lg-2">
                              <label for="">TipoMascota</label>
                              <input type="text" name="tipoMascota" class="form-control form-control-ml" disabled value="<?php echo $user->getTipoMascota();  ?>">
                         </div>

                         <div class="col-lg-2">
                              <label for="">RemuneracionEsperada</label>
                              <input type="text" name="remuneracionEsperada" class="form-control form-control-ml" disabled value="<?php echo $user->getRemuneracionEsperada();  ?>">
                         </div>

                         <div class="col-lg-5">
                              <label for="">Disponibilidad</label>
                              <input type="text" name="remuneracionEsperada" class="form-control form-control-ml" disabled value="
                              <?php 
                              if (count($user->getDisponibilidad()) == 0) echo 'No hay dias elegidos.';
                              else {
                              foreach($user->getDisponibilidad() as $dia){ 

                                        $value.= ' - ' . $dia;
                                   } 
                                   echo $value;
                              
                              } 
                              ?>">
                         </div>
                    </div> 
          </div>
     </section>
     <!-- Create a section with a POST form for the user to set the days of week in checkboxes with a send button. Make it modify the user -->
     <section id="login-block" class="mb-5">
          <div class="container">   
          <center><h3 class="mb">Modificar Disponibilidad</h3></center>
               <div class="bg-light-alpha p-4">
               <form action="<?php echo FRONT_ROOT. "Auth/setDiaDisponible"?>" method="POST">
                    <div class="row">
                         <div class="col-lg-3">
                              <label for="">Lunes</label>
                              <input type="checkbox" name="dia_lunes" class="form-control form-control-ml" value="lunes">
                         </div>

                         <div class="col-lg-3">
                              <label for="">Martes</label>
                              <input type="checkbox" name="dia_martes" class="form-control form-control-ml" value="martes">
                         </div>

                         <div class="col-lg-3">
                              <label for="">Miercoles</label>
                              <input type="checkbox" name="dia_miercoles" class="form-control form-control-ml" value="miercoles">
                         </div>

                         <div class="col-lg-3">
                              <label for="">Jueves</label>
                              <input type="checkbox" name="dia_jueves" class="form-control form-control-ml" value="jueves">
                         </div>

                         <div class="col-lg-3">
                              <label for="">Viernes</label>
                              <input type="checkbox" name="dia_viernes" class="form-control form-control-ml" value="viernes">
                         </div>

                         <div class="col-lg-3">
                              <label for="">Sabado</label>
                              <input type="checkbox" name="dia_sabado" class="form-control form-control-ml" value="sabado">
                         </div>

                         <div class="col-lg-3">
                              <label for="">Domingo</label>
                              <input type="checkbox" name="dia_domingo" class="form-control form-control-ml" value="domingo">
                         </div>
                    </div> 

                    

                    
                    <div class="row">
                         <div class="col-lg-12">
                              <button type="submit" class="btn btn-dark ml-auto d-block">Modificar</button>
                         </div>
                    </form>
                    </div>
               </div>
          </div>
     
     
     
     
     
     
</section>
<button type="submit" class="btn btn-login float-right">Submit</button>
</main>
