<?php
use Utils\Session;
$user = Session::GetLoggedUser();
$type = $_SESSION['userType'];
include ('nav-simple-bar.php');
?>
<section class="login-block">

    <main class="py-5">
        <section id="login-block" class="mb-5">
        <form action="<?php echo FRONT_ROOT ?>Guardian/ModifyAvailability" method="post">
            <div class="container" id = "dataUser">
                <center> 
                    <h3 class="mb" id = "dataUser">Modificar Disponibilidad Guardian</h3>
                </center>
        <table style="text-align:center;">
        <?php if (Session::VerifiyMessage()) { ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
           <?php echo $_SESSION['message'];
                 unset($_SESSION['message']); 
            ?>
     </div>
    <?php } ?>
        <thead>
            <tr>
                <th style="width: 16%;">Fecha Inicio</th>
                <th style="width: 16%;">Fecha Fin</th>
                <th style="width: 16%;">Dias</th>
            </tr>
        </thead>
        <tbody align="center">
            <tr>
            <input type="hidden" name="guardianname"  class="form-control form-control-ml" value = <?php echo $user->getEmail()?>>
                <td><input type="date" name="initDate" value ="<?php echo $user->getInitDate() ?>" id="initDate" min="<?php echo date('Y-m-d') ?>" select></td>
                <td><input type="date" name="finishDate" value ="<?php echo $user->getFinishDate() ?>" id="finishDate" min="<?php echo date('Y-m-d') ?>"></td>
                <td><select name="daysToWork[]" id="daysToWork" multiple="multiple" required>Choose the days you want to work
                <option value="lunes">Lunes</option>
                <option value="martes">Martes</option>
                <option value="miercoles">Miercoles</option>
                <option value="jueves">Jueves</option>
                <option value="viernes">Viernes</option>
                <option value="sabado">Sabado</option>
                <option value="domingo">Domingo</option>

            </tr>
             </tbody>
         </table>
         <br>
            <div class="row-lg-1" style="text-align:center">
             <button type="submit" style = "text-align:center" class="btn btn-dark">Modificar</button>
             </div> 
            </section>
            </div>
        </form>

<br>
</div>
</div>   