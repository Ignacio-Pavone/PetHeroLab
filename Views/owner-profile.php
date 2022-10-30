<?php
use Utils\Session;
use Utils\DateFormat as Format;
require_once VIEWS_PATH . 'header.php';
$user = Session::GetLoggedUser();
$type = $_SESSION['userType'];
include('nav-bar.php');
?>
<section class="login-block">
    <main class="py-1">
        <section id="login-block" class="mb-5">
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
            </div>
            <div class="container" id="dataUser">
                <center>
                    <h3 class="mb">Datos</h3>
                    <hr>
                </center>
                <div class="bg-light-alpha p-1" id="dataUser">
                    <div class="row">

                        <div class="col-lg-12" style="height:10px;"></div>

                        <div class="col-lg-3 input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon1">Nombre</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Nombre" name="nombre"
                                   aria-label="Username" aria-describedby="basic-addon1"
                                   disabled value="<?php echo $user->getFullName(); ?>">
                        </div>


                        <div class="col-lg-2 input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon1">Edad</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Nombre" name="nombre"
                                   aria-label="Username" aria-describedby="basic-addon1"
                                   disabled value="<?php echo $user->getAge(); ?>">
                        </div>

                        <div class="col-lg-3 input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon1">DNI</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Nombre" name="nombre"
                                   aria-label="Username" aria-describedby="basic-addon1"
                                   disabled value="<?php echo $user->getDni(); ?>">
                        </div>

                        <div class="col-lg-4 input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon1">Email</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Nombre" name="nombre"
                                   aria-label="Username" aria-describedby="basic-addon1"
                                   disabled value="<?php echo $user->getEmail(); ?>">
                        </div>

                    </div>
                </div>

            </div>
            <br>
            <div class="container" id="css-mine" style="overflow-y:scroll; height: 450px;">
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
                        <th style="width: 10%;">Especie</th>
                        <th style="width: 15%;">Raza</th>
                        <th style="width: 15%;">Tamaño</th>
                        <th style="width: 15%;">Foto</th>
                        <th style="width: 15%;">Vacunas</th>
                        <th style="width: 15%;">Video</th>
                        <th style="width: 10%;">Actualizar</th>
                        <th style="width: 5%;">Borrar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($allPets != null) {
                        foreach ($allPets as $mascota) {
                            ?>
                            <tr>
                                <td><?php echo $mascota->getName(); ?></td>
                                <td><?php echo $mascota->getType(); ?></td>
                                <td><?php echo $mascota->getBreed(); ?></td>
                                <td><?php echo $mascota->getPetsize(); ?></td>
                                <td><img src="<?php echo $mascota->getPhotoUrl(); ?>" style= "border-radius:10px"alt="" width="80px" height="60px">
                                </td>
                                <td><a href="<?php echo $mascota->getVaccinationschedule(); ?>" target="_blank">Ver
                                        Plan</a>
                                </td>
                                <td><a href="<?php echo $mascota->getVideoUrl(); ?>" target="_blank">Ver Video</a></td>
                                <td>
                                    <a class="btn btn-dark ml-auto"
                                       href="<?php echo FRONT_ROOT . 'Pet/update/' . $mascota->getId() ?>">Actualizar</a>
                                </td>
                                <td>
                                    <a class="btn btn-danger ml-auto" style= "border-radius:17px" onclick="return confirm('Are you sure?')"
                                       href="<?php echo FRONT_ROOT . 'Pet/delete/' . $mascota->getId(); ?>">X</a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>

                    </tbody>
                </table>
                <br>
            </div>
            <br>
            <div>
                <div class="container" id="css-mine1" style="overflow-y:scroll; height: 500px;">
                    <br>
                    <center>
                        <h3 class="mb">Guardianes</h3>
                        <hr>
                    </center>
                    <div class="col-lg-12" style="height:15px"></div>
                    <div id="divFiltroFecha">
                        <form id="" action="<?php echo FRONT_ROOT . 'Auth/showFilter' ?>">
                            <label style="margin-left:30px;font-style: italic;" for="filtroInicio"><b>Fecha de
                                    Inicio</b></label> <input style="margin-left:20px;" type="date"
                                                              class="update-dispon inputFiltro" id="initDate"
                                                              name="filtroInicio" min="<?php echo date('Y-m-d') ?>"
                                                              value="<?php echo date('Y-m-d') ?>" select required>
                            <label style="margin-left:30px;font-style: italic;" for="filtroFinal"><b>Fecha de
                                    Fin</b></label> <input style="margin-left:20px;" type="date"
                                                           class="update-dispon inputFiltro" id="finishDate"
                                                           name="filtroFinal" min="<?php echo date('Y-m-d') ?>" value=""
                                                           select required>
                            <button type="submit" style="margin-left: 100px; text-align:center" class="btn btn-dark">
                                Filtrar
                            </button>
                        </form>
                        <form action="<?php echo FRONT_ROOT . 'Auth/showOwnerProfile' ?>">
                            <button style="margin-right: 55px;" type="submit" style="text-align:center"
                                    class="btn btn-dark">Limpiar Filtros
                            </button>
                        </form>
                    </div>

                    <br>
                    <table style="text-align:center;">
                        <thead>
                        <tr>
                            <th style="width: 15%;">Nombre</th>
                            <th style="width: 1%;">Edad</th>
                            <th style="width: 5%;">Preferencia</th>
                            <th style="width: 5%;">Score</th>
                            <th style="width: 10%;">Costo</th>
                            <th style="width: 5%;">Fecha inicio</th>
                            <th style="width: 5%;">Fecha fin</th>
                            <th style="width: 3%;">Mascotas</th>
                            <th style="width: 1%">Accion</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        foreach ($guardians as $guardian) {
                        if ($guardian->getInitDate() != null){
                        ?>
                        <tr>
                            <td><?php echo $guardian->getFullName(); ?></td>
                            <td><?php echo $guardian->getAge(); ?></td>
                            <td><?php echo $guardian->getPetSize(); ?></td>
                            <?php if ($guardian->getReputation() >= 3 && $guardian->getReputation() < 4) { ?>
                                <td style=color:green><?php echo bcdiv($guardian->getReputation(), '1', 1) ?> </td>
                            <?php } elseif ($guardian->getReputation() > 0 && $guardian->getReputation() < 3) { ?>
                                <td style=color:red><?php echo bcdiv($guardian->getReputation(), '1', 1) ?> </td>
                            <?php } elseif ($guardian->getReputation() >= 4) { ?>
                                <td style=color:orange><?php echo bcdiv($guardian->getReputation(), '1', 1) ?> </td>
                            <?php } elseif ($guardian->getReputation() == 0.0) { ?>
                                <td style=color:black><?php echo '-' ?> </td>
                            <?php } ?>
                            <td><?php echo $guardian->getFee() . ' $'; ?></td>
                            <form action="<?php echo FRONT_ROOT ?>Request/requestGuardian" method="post">
                                <td><input type="date" id="initDate" name="fechaInicio"
                                           max="<?php echo $guardian->getFinishDate() ?>" class="update-dispon"
                                           value="" min="<?php if ($guardian->getInitDate() < date('Y-m-d')) {
                                        echo date('Y-m-d');
                                    } else {
                                        echo $guardian->getInitDate();
                                    } ?>" required></td>

                                <td><input type="date" id="endDate" name="fechaFin"
                                           max="<?php echo $guardian->getFinishDate() ?>" class="update-dispon"
                                           value="" min="<?php if ($guardian->getInitDate() < date('Y-m-d')) {
                                        echo date('Y-m-d');
                                    } else {
                                        echo $guardian->getInitDate();
                                    } ?>" required></td>
                                <td>
                                    <div class="col-lg-2">
                                        <select name="idMascota" id="solapaDuenios" style="width: 80px;">
                                            <?php if ($allPets){
                                                foreach ($allPets as $mascota) { ?>
                                                    <option name="idMascota"
                                                            value="<?php echo $mascota->getId(); ?>">
                                                        <?php echo $mascota->getName(); ?></option>
                                                <?php }
                                            } else{ ?>
                                                <option name="idMascota" value="" selected disabled>No hay</option>
                                            <?php
                                            }?>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <input type="hidden" name="Duenio" value="<?php echo $user->getEmail(); ?>">
                                    <input type="hidden" name="Guardian"
                                           value="<?php echo $guardian->getEmail(); ?>">
                                    <input type="hidden" name="costoTotal"
                                           value="<?php echo $guardian->getFee(); ?>">
                                    <?php if ($allPets) {?>
                                    <button type="submit" style="text-align:center"
                                            class="btn btn-dark">Solicitar
                                    </button>
                                    <?php }else{ ?>
                                        <button type="submit" style="text-align:center"
                                                class="btn btn-dark" disabled>Solicitar
                                        </button>
                                    <?php } ?>
                                </td>
                                <?php } ?>
                            </form>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <br>
                    <div class="divEstado">
                        <p class="circulo" style="background:orange;"></p><label
                                style="padding-left:5px;padding-right:15px;" for="">Sobresaliente</label>
                        <p class="circulo" style="background:green;"></p><label
                                style="padding-left:5px;padding-right:15px;" for="">Muy bueno</label>
                        <p class="circulo" style="background:red;"></p><label
                                style="padding-left:5px; padding-right:15px;" for="">Negativo</label>
                        <p class="circulo" style="background:black;"></p><label
                                style="padding-left:5px; padding-right:15px;" for="">Sin calificaciones</label>
                    </div>
                </div>
                <br>
                <div class="container" id="css-mine" style="overflow-y:scroll; height: 400px;">
                    <br>
                    <center>
                        <h3 class="mb">Peticiones Hechas</h3>
                    </center>
                    <hr>
                    <br>
                    <table style="text-align:center;">
                        <thead>
                        <tr>
                            <th style="width: 15%;">Guardian</th>
                            <th style="width: 1%;">Mascota</th>
                            <th style="width: 14%;">Fecha Inicio</th>
                            <th style="width: 14%;">Fecha Fin</th>
                            <th style="width: 1%;">Dias</th>
                            <th style="width: 8%;">Costo Total</th>
                            <th style="width: 1%;">Estado</th>
                            <th style="width: 10%;">Pagar</th>
                            <th style="width: 15%;">Calificar</th>
                            <th style="width: 4%;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($requests as $request) {
                            ?>
                            <tr>
                                <?php foreach ($allGuardians as $guardian) {
                                    if ($request->getIdGuardian() == $guardian->getId()) {
                                        ?>
                                        <td><?php echo $guardian->getFullName(); ?></td>
                                    <?php }
                                } ?>
                                <?php foreach ($allPets as $mascota) {
                                    if ($request->getIdPet() == $mascota->getId()) {
                                        ?>
                                        <td><?php echo $mascota->getName();
                                            break; ?></td>
                                    <?php }
                                } ?>
                                <td><?php echo Format::formatDate($request->getInitDate()); ?></td>
                                <td><?php echo Format::formatDate($request->getFinishDate());  ?></td>
                                <td><?php echo $request->getDaysAmount(); ?></td>
                                <td><?php echo $request->getFinalPrice() . ' $' ?></td>
                                <td class=""><?php if ($request->getReqStatus() == 'Confirmado') {
                                    ?> <label class="circulo" style="background:green;"> <?php
                                        } elseif ($request->getReqStatus() == 'Pendiente') {
                                        ?> <label class="circulo" style="background:orange;"> <?php
                                            } elseif ($request->getReqStatus() == 'Rechazado') {
                                            ?> <label class="circulo" style="background:red;"> <?php
                                                } elseif ($request->getReqStatus() == 'Completo') {
                                                ?> <label class="circulo" style="background:blue;"> <?php
                                                    } elseif ($request->getReqStatus() == 'Calificado') {
                                                    ?> <label class="circulo" style="background:purple;"> <?php
                                                        } elseif ($request->getReqStatus() == 'En Curso') {
                                                        ?> <label class="circulo" style="background:pink;"></td>
                            <?php } ?>

                                
                            <td> <?php foreach ($payments as $payment) {
                                    if ($payment->getId_request() == $request->getIdRequest()) {?>
                                    <?php if ($payment->getPaid() == 0 && $request->getReqStatus() != 'Rechazado') { ?>
                                            <a class="btn btn-info ml-auto" href="<?php echo FRONT_ROOT . 'Payment/showPaymentForm/' . $payment->getId_payment(); ?>">PAGAR</a>
                                    <?php }else{ ?>
                                            <button type="button" class="btn btn-info" disabled>PAGAR</button>
                                    <?php } ?>
                                    <?php }
                                } ?>
                                <td>
                                    <form action="<?php echo FRONT_ROOT ?>Request/qualifyGuardian" method="post">
                                        <input type="hidden" name="guardian"
                                               value="<?php echo $request->getIdGuardian() ?>">
                                        <input type="hidden" name="reserva"
                                               value="<?php echo $request->getIdRequest() ?>">
                                        <?php if ($request->getReqStatus() == 'Completo' && $request->getReqStatus() != 'Calificado') { ?>
                                            <div class="input-group">
                                                <input type="number" min="1" max="5" name="calificacion"
                                                       class="form-control col-xs-2" style="text-align:center"
                                                       placeholder="5" required>
                                                <span class="input-group-addon">-</span>
                                                <button class="btn btn-info" type="submit"
                                                        onclick="return confirm('Are you sure?')"
                                                        style="text-align:center"
                                                        class="btn btn-dark">Calificar
                                                </button>
                                            </div>
                                        <?php } else { ?>
                                            <div class="input-group">
                                                <input type="number" min="0" max="5" name=""
                                                       class="form-control col-xs-2"
                                                       style="text-align:center" placeholder="5" disabled>
                                                <span class="input-group-addon">-</span>
                                                <button type="button" class="btn btn-dark" disabled>Calificar</button>
                                            </div>
                                        <?php } ?>
                                        <td>
                                    <?php if ($request->getReqStatus() == 'Calificado' || $request->getReqStatus() == 'En Curso' || $request->getReqStatus() == 'Rechazado') { ?>
                                        <button type="button" class="btn btn-dark" style="border-radius: 17px" disabled>X</button>
                                    <?php } else { ?>  
                                    <?php foreach ($payments as $payment){ ?>
                                    <?php if ($payment->getId_request() == $request->getIdRequest()) { ?>
                                       <?php if ($payment->getPaid() == 0){ ?>
                                            <a class="btn btn-danger ml-auto" style="border-radius: 17px;" onclick="return confirm('Are you sure?')"
                                            href="<?php echo FRONT_ROOT . 'Request/cancelRequestasOwner/' . $request->getIdRequest(); ?>">X</a>
                                    <?php } else { ?>
                                        <button type="button" class="btn btn-dark" style="border-radius: 17px" disabled>X</button>
                                        </td>        
                                <?php } ?>               
                                <?php } ?>
                                <?php } ?>
                                <?php } ?>
                                </td>
                                </form>
                            </tr>
                            <?php
                        } ?>
                        </tbody>
                    </table>
                    <br>
                    <div class="divEstado">

                        <p class="circulo" style="background:orange;"></p><label
                                style="padding-left:5px;padding-right:15px;" for="">Pendiente</label>
                        <p class="circulo" style="background:green;"></p><label
                                style="padding-left:5px; padding-right:15px;" for="">Confirmado</label>
                        <p class="circulo" style="background:pink;"></p><label
                                style="padding-left:5px;padding-right:15px;" for="">En Curso</label>
                        <p class="circulo" style="background:blue;"></p><label
                                style="padding-left:5px;padding-right:15px;" for="">Completo</label>
                        <p class="circulo" style="background:purple;"></p><label
                                style="padding-left:5px;padding-right:15px;" for="">Calificado</label>
                        <p class="circulo" style="background:red;"></p><label
                                style="padding-left:5px;padding-right:15px;" for="">Rechazado</label>
                    </div>
                    <br>
                </div>
                <br>
                <section id="login-block" class="mb-5">
                    <div class="container" id="addPetsDuenio">
                        <br>
                        <center>
                            <h3 class="mb">Agrega una nueva mascota</h3>
                            <hr>
                            <br>
                        </center>
                        <form action="<?php echo FRONT_ROOT ?>Pet/add" method="post">
                            <input type="hidden" name="id_owner" value="<?php echo $user->getId(); ?>">

                            <div class="row">

                                <div class="col-lg-4 input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Nombre</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Nombre" name="name"
                                           aria-label="Username" aria-describedby="basic-addon1" required>
                                </div>

                                <div class="col-lg-4 input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">Tipo</label>
                                    </div>
                                    <select class="custom-select" name="type" id="inputGroupSelect01">
                                        <option value="Gato" selected>Gato</option>
                                        <option value="Perro">Perro</option>
                                    </select>
                                </div>

                                <div class="col-lg-4 input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Raza</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Raza" name="breed"
                                           aria-describedby="basic-addon1" required>
                                </div>

                                <div class="col-lg-4 input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">Tamaño</label>
                                    </div>
                                    <select class="custom-select" name="pet_size" id="inputGroupSelect01">
                                        <option value="Chico">Chico</option>
                                        <option value="Mediano" selected>Mediano</option>
                                        <option value="Grande">Grande</option>
                                    </select>
                                </div>

                                <div class="col-lg-4 input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon3">URL</span>
                                    </div>
                                    <input type="text" name="photo_url" placeholder="Foto" class="form-control"
                                           id="basic-url" aria-describedby="basic-addon3" required>
                                </div>

                                <div class="col-lg-4 input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon3">URL</span>
                                    </div>
                                    <input type="text" name="vaccination_schedule" placeholder="Plan de Vacunacion"
                                           class="form-control" id="basic-url" aria-describedby="basic-addon3" required>
                                </div>

                                <div class="col-lg-12 input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon3">URL</span>
                                    </div>
                                    <input type="text" name="video_url" placeholder="Video" class="form-control"
                                           id="basic-url" aria-describedby="basic-addon3" required>
                                </div>

                                <div class="row" id="buttonraro" style="margin-left: 460px; border: 1px solid">
                                    <div class="col-lg-1" style="text-align:center">
                                        <button type="submit" onclick="return confirm('Are you sure?')"
                                                style="text-align:center" class="btn btn-login">Agregar
                                        </button>
                                    </div>
                                </div>

                        </form>
                    </div>
                    <br>
                    </form>
            </div>
            </div>
        </section>