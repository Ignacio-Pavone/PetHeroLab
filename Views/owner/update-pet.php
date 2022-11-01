<?php
require_once VIEWS_PATH . "navbars/nav-simple-bar.php";
require_once VIEWS_PATH . 'header.php';
?>
<section class="login-block">
    <main class="py-1">
        <section id="login-block" class="mb-5">
            <div class="container" id="dataUser">
                <center>
                    <h3 class="mb" id="dataUser">Modificar Mascota</h3>
                    <hr>
                </center>
                <table style="text-align:center;">
                    <thead>
                    <tr>
                        <th style="width: 10%;">Nombre</th>
                        <th style="width: 10%;">Especie</th>
                        <th style="width: 10%;">Raza</th>
                        <th style="width: 10%;">Tamaño</th>
                        <th style="width: 10%;">Foto</th>
                        <th style="width: 10%;">Plan Vacunacion</th>
                        <th style="width: 10%;">Video</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?php echo $search->getName(); ?></td>
                        <td><?php echo $search->getType(); ?></td>
                        <td><?php echo $search->getBreed(); ?></td>
                        <td><?php echo $search->getPetsize(); ?></td>
                        <td><img src="<?php echo $search->getPhotoUrl(); ?>" alt="" width="80px" height="60px"></td>
                        <td><a href="<?php echo $search->getVaccinationschedule(); ?>" target="_blank">Ver Plan</a></td>
                        <td><a href="<?php echo $search->getVideoUrl(); ?>" target="_blank">Ver Video</a></td>
                    </tr>
                    </tbody>
                </table>
                <br>
        </section>
        </div>
        <section id="login-block" class="mb-5">
            <div class="container" id="dataUser">
                <center>
                    <h3 class="mb" id="dataUser">Modifique los datos de la mascota</h3>
                    <hr>
                </center>
                <form action="<?php echo FRONT_ROOT ?>Pet/modify" method="post">
                    <div class="row">
                        <input type="hidden" name="id_owner" class="form-control form-control-ml"
                               value=<?php echo $search->getidOwner() ?>>
                        <input type="hidden" name="id" class="form-control form-control-ml"
                               value=<?php echo $search->getId() ?>>
                        <input type="hidden" name="type" class="form-control form-control-ml"
                               value=<?php echo $search->getType() ?>>
                        <div class="col-lg-4 input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon1">Nombre</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Nombre" name="name"
                                   value=<?php echo $search->getName() ?>
                                   required aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="col-lg-4 input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon1">Raza</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Raza" name="breed"
                                   aria-describedby="basic-addon1" value=<?php echo $search->getBreed() ?>
                                   required>
                        </div>
                        <div class="col-lg-4 input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="btn btn-md btn-dark m-0 px-3" for="inputGroupSelect01">Tamaño</label>
                            </div>
                            <select class="custom-select" name="pet_size" id="inputGroupSelect01">
                                <option value="Chico" <?php echo($search->getPetsize() == 'Chico' ? 'selected' : '') ?>>
                                    Chico
                                </option>
                                <option value="Mediano" <?php echo($search->getPetsize() == 'Mediano' ? 'selected' : '') ?>>
                                    Mediano
                                </option>
                                <option value="Grande" <?php echo($search->getPetsize() == 'Grande' ? 'selected' : '') ?>>
                                    Grande
                                </option>
                            </select>
                        </div>
                        <div class="col-lg-4 input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon3">Foto</span>
                            </div>
                            <input type="text" name="photo_url" placeholder="Foto" class="form-control" id="basic-url"
                                   aria-describedby="basic-addon3"
                                   value=<?php echo $search->getPhotoUrl() ?> required>
                        </div>
                        <div class="col-lg-4 input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon3">Video</span>
                            </div>
                            <input type="text" name="vaccination_schedule" placeholder="Video" class="form-control"
                                   id="basic-url" aria-describedby="basic-addon3"
                                   value=<?php echo $search->getVaccinationschedule() ?> required>
                        </div>
                        <div class="col-lg-4 input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="btn btn-md btn-dark m-0 px-3" id="basic-addon3">Plan Vacunacion</span>
                            </div>
                            <input type="text" name="video_url" placeholder="Plan Vacunacion" class="form-control"
                                   id="basic-url" aria-describedby="basic-addon3"
                                   value=<?php echo $search->getVideoUrl() ?> required>
                        </div>
                        <div class="row" id="buttonraro" style="border: 1px solid">
                            <div class="col-lg-1" style="text-align:center">
                                <button type="submit" onclick="return confirm('Are you sure?')"
                                        style="text-align:center" class="btn btn-login">Actualizar
                                </button>
                         </div>
                    </form>
                 </div>
                <br>
            </div>
        </div>
    </main>

