<?php 
use Utils\Session;
use Utils\DateFormat as Format;

require_once VIEWS_PATH . 'header.php';
$user = Session::GetLoggedUser();
$type = $_SESSION['userType'];
include('nav-simple-bar.php');

?>

<section class="login-block" style="height:100vh;">
    
    <main class="py-1">
    <?php if (Session::VerifiyBadMessage()) { ?>
            <div class="alert alert-danger alert-dismissible fade show center-block" style="text-align:center" role="alert">
            <?php echo $_SESSION['bad'];
                unset($_SESSION['bad']);
            }?>
            </div>
        <section id="login-block" class="mb-5">
            
            <div class="container" id="dataUser">
                <center>
                    <h3 class="mb" id="dataUser">Modificar Contraseña</h3>
                </center>
                <hr>
                <br>
            <form action="<?php if($type=='owner') echo FRONT_ROOT."Owner/changePassword/"; else echo FRONT_ROOT."Guardian/changePassword/";  ?>">

            <div class="row">

            <input type="hidden" name="userID" value="<?php echo $user->getId(); ?>">

            <div class="col-lg-4 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon1">Antigua Contraseña</span>
                </div>
                <input type="text" class="form-control" placeholder="****" name="oldPassword"
                aria-describedby="basic-addon1" required>
            </div>

            <div class="col-lg-4 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon1">Nueva Contraseña</span>
                </div>
                <input type="password" class="form-control" placeholder="****" name="newPassword"
                aria-describedby="basic-addon1" required>
            </div>

            <div class="col-lg-4 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon1">Nueva Contraseña</span>
                </div>
                <input type="password" class="form-control" placeholder="****" name="newPassword2"
                aria-describedby="basic-addon1" required>
            </div>
            
            <div class="row" id="buttonraro" style="border: 1px solid">
                <div class="col-lg-1" style="text-align:center">
                    <button type="submit" onclick="return confirm('Are you sure?')"
                    style="text-align:center" class="btn btn-login">Modificar
                    </button>
                </div>
            </div>
            </form>
            <br>

        </section>

    </main>

