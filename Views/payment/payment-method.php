<?php
use Utils\Session as Session;
require_once VIEWS_PATH . 'header.php';
require_once VIEWS_PATH . 'navbars/nav-simple-bar.php';
$user = Session::GetLoggedUser();
?>
<section class="login-block">

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
                    unset($_SESSION['good']);
                    ?>
                </div>
            <?php }
        } ?>
    <main class="py-1">
        <section id="login-block" class="mb-5">
            <div class="container" id="dataUser">
                <center>
                    <h3 class="mb" id="dataUser">Detalles de la Reserva</h3>
                    <hr>
                </center>
                <table style="text-align:center;">
                    <thead>
                    <tr>
                        <th style="width: 10%;">Guardian</th>
                        <th style="width: 10%;">Duenio</th>
                        <th style="width: 10%;">Mascota</th>
                        <th style="width: 10%;">Fecha Inicio</th>
                        <th style="width: 10%;">Fecha Fin</th>
                        <th style="width: 10%;">Dias</th>
                        <th style="width: 10%;">Precio Total</th>
                        <th style="width: 10%;">A Pagar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <?php foreach ($request as $reserva) { ?>
                            <?php if ($payment->getId_request() == $reserva->getIdRequest()) { ?>
                                <?php foreach ($guardians as $guardian) { ?>
                                    <?php if ($reserva->getIdGuardian() == $guardian->getId()) { ?>
                                        <td><?php echo $guardian->getFullName() ?></td>
                                    <?php }
                                } ?>
                                <?php foreach ($owners as $owner) { ?>
                                    <?php if ($reserva->getIdOwner() == $owner->getId()) { ?>
                                        <td><?php echo $owner->getFullName() ?></td>
                                    <?php }
                                } ?>
                                <?php foreach ($pets as $pet) { ?>
                                    <?php if ($reserva->getIdPet() == $pet->getId()) { ?>
                                        <td><?php echo $pet->getName() ?></td>
                                    <?php }
                                } ?>
                                <td><?php echo $reserva->getInitDate(); ?></td>
                                <td><?php echo $reserva->getFinishDate(); ?></td>
                                <td><?php echo $reserva->getDaysAmount(); ?></td>
                                <td><?php echo "$" . $reserva->getFinalPrice(); ?></td>
                                <td style ="color:red; font-weight:500"><?php echo "$" . $reserva->getFinalPrice()/2; ?></td>
                            <?php }
                        } ?>
                    </tr>
                    </tbody>
                </table>
                <br>
        </section>
        </div>
        <section id="login-block" class="mb-5">
            <div class="container" id="addPetsDuenio">
                <br>
                <center>
                    <h3 class="mb">Pago</h3>
                    <hr>
                    <br>
                </center>    
                <div class="col-8 mb-5" style="margin-left:180px;">                
                <div class="bg-light border rounded shadow-sm py-2 px-2">
                    <div class="row py-4 px-4">
                        <form id="cardform" action="<?php echo FRONT_ROOT ?>Payment/processPayment" method="POST">
                            <div class="row">
                                <div class="form-group col-7">
                                    <label for="card-holder">Nombre completo</label>
                                    <input id="card-holder" type="text" class="form-control" name="name" placeholder="Nombre Completo" aria-label="Nombre Completo" aria-describedby="basic-addon1" required>
                                </div>
                                <div class="form-group col-5">
                                    <label for="card-expiry">Fecha de expiracion</label>
                                    <input id="card-expiry" type="tel" class="form-control" name="expiry" placeholder="MM/AA" maxlength="5" aria-label="MMAA" aria-describedby="basic-addon1" required>
                                </div>
                                <div class="form-group col-8">
                                    <label for="card-number">Numero de tarjeta</label>
                                    <input id="card-number" type="tel" class="form-control" name="number" placeholder="Numero de Tarjeta" aria-label="Numero de Tarjeta" aria-describedby="basic-addon1" required>
                                </div>
                                <div class="form-group col-4">
                                    <label for="cvc">Cod.Seguridad</label>
                                    <input id="cvc" type="number" class="form-control" name="cvc" placeholder="CVC" aria-label="CVC" aria-describedby="basic-addon1" required>
                                </div>
                                <input type="hidden" name="idPayment" value="<?php echo $payment->getId_payment(); ?>">
                                <input type="hidden" name="idOwner" value="<?php echo $payment->getId_owner(); ?>">
                                <input type="hidden" name="idRequest" value="<?php echo $payment->getId_request(); ?>">
                            </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-lg-1" style="text-align:center; margin-left: 465px;">
                                    <button type="submit" onclick="return confirm('Are you sure?')"
                                    style="text-align:center" class="btn btn-login">CONFIRMAR
                                    </button>
                        </div>
                    </form>
            </div>
                        
                      

                       
                        
                    
            </div>
            <br>
            </div>
        </div>
    </main>

 