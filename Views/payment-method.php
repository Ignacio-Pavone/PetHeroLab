<?php
use Utils\Session as Session;
include('nav-simple-bar.php');
require_once VIEWS_PATH . 'header.php';
$user = Session::GetLoggedUser();
?>
<section class="login-block">
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
                        <th style="width: 10%;">Precio</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <?php foreach ($request as $reserva) { ?>
                                <?php if ($payment->getId_request() == $reserva->getIdRequest()) { ?>
                                    <?php foreach ($guardians as $guardian) { ?>
                                        <?php if ($reserva->getIdGuardian() == $guardian->getId()) { ?>
                                            <td><?php echo $guardian->getFullName() ?></td>
                                        <?php } } ?>
                                    <?php foreach ($owners as $owner) { ?>
                                        <?php if ($reserva->getIdOwner() == $owner->getId()) { ?>
                                            <td><?php echo $owner->getFullName() ?></td>
                                        <?php } } ?>
                                    <?php foreach ($pets as $pet) { ?>
                                        <?php if ($reserva->getIdPet() == $pet->getId()) { ?>
                                            <td><?php echo $pet->getName() ?></td>
                                        <?php } } ?>
                                    <td><?php echo $reserva->getInitDate(); ?></td>
                                    <td><?php echo $reserva->getFinishDate(); ?></td>
                                    <td><?php echo $reserva->getDaysAmount(); ?></td>
                                    <td><?php echo "$".$reserva->getFinalPrice(); ?></td>

                        <?php } }?>
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
                <form action="<?php echo FRONT_ROOT ?>Payment/processPayment" method="post">

                    
                    <div class="row">
                    <div class="col-lg-4 input-group mb-3" style="margin-left: 350px;">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Forma de Pago</label>
                            </div>
                            <select class="custom-select" name="Method">
                                <option value="credito" <?php  ?>>
                                    Credito
                                </option>
                                <option value="debito" <?php ?>>
                                     Debito
                                </option>
                                <option value="efectivo" <?php ?>>
                                    Efectivo
                                </option>
                            </select>
                        </div>
                     </select>
                     <input type="hidden" name="idPayment" value="<?php echo $payment->getId_payment(); ?>">
                     <input type="hidden" name="idOwner" value="<?php echo $payment->getId_owner(); ?>">
                     <input type="hidden" name="idRequest" value="<?php echo $payment->getId_request(); ?>">
                     <div class="row" id="buttonraro" style="margin-left: 445px; border: 1px solid">
                                    <div class="col-lg-1" style="text-align:center">
                                        <button type="submit" onclick="return confirm('Are you sure?')"
                                                style="text-align:center" class="btn btn-dark">CONFIRMAR
                                        </button>
                                    </div>
                                </div>
                    </div>
                </form>
            </div>
            <br>
            </div>
            </div>

    </main>
