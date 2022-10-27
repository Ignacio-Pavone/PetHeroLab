<?php
include('nav-simple-bar.php');
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
                            <td><?php echo $search->getNombre(); ?></td>
                            <td><?php echo $search->getTipo(); ?></td>
                            <td><?php echo $search->getRaza(); ?></td>
                            <td><?php echo $search->getTamanio(); ?></td>
                            <td><img src="<?php echo $search->getFoto(); ?>" alt="" width="80px" height="60px"></td>
                            <td><a href="<?php echo $search->getPlanVacunacion(); ?>" target="_blank">Ver Plan</a></td>
                            <td><a href="<?php echo $search->getVideo(); ?>" target="_blank">Ver Video</a></td>
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
                    <h3 class="mb">Modifique los datos de la mascota</h3>
                    <hr>
                    <br>
                </center>
                <form action="<?php echo FRONT_ROOT ?>Mascota/ModifyPet" method="post">
                    
                <div class="row">     
                        <input type="hidden" name="idDuenio" class="form-control form-control-ml"
                        value=<?php echo $search->getidDuenio() ?>>
                        <input type="hidden" name="idMascota" class="form-control form-control-ml"
                        value=<?php echo $search->getIdMascota() ?>>    
                        <input type="hidden" name="tipo" class="form-control form-control-ml"
                        value=<?php echo $search->getTipo() ?>>

                        <div class="col-lg-4 input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Nombre</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Nombre" name="nombre" value=<?php echo $search->getNombre() ?> 
                            required aria-label="Username" aria-describedby="basic-addon1">
                        </div>

                        <div class="col-lg-4 input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Raza</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Raza" name="raza" aria-describedby="basic-addon1" value=<?php echo $search->getRaza() ?>
                            required>
                        </div>

                        <div class="col-lg-4 input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Tamaño</label>
                            </div>
                            <select class="custom-select" name="tamanio" id="inputGroupSelect01">
                                <option value="Chico" <?php echo ($search->getTamanio() == 'Chico' ? 'selected' : '') ?>>Chico</option>
                                <option value="Mediano" <?php echo ($search->getTamanio() == 'Mediano' ? 'selected' : '') ?>>Mediano</option>
                                <option value="Grande" <?php echo ($search->getTamanio() == 'Grande' ? 'selected' : '') ?>>Grande</option>
                            </select>
                        </div>
                    

                        <div class="col-lg-4 input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3">Foto</span>
                            </div>
                            <input type="text" name="foto" placeholder="Foto" class="form-control" id="basic-url" aria-describedby="basic-addon3"
                            value=<?php echo $search->getFoto() ?> required>
                        </div>

                        <div class="col-lg-4 input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">Video</span>
                                </div>
                                <input type="text" name="planVacunacion" placeholder="Video" class="form-control" id="basic-url" aria-describedby="basic-addon3"
                                value=<?php echo $search->getPlanVacunacion() ?> required>
                            </div>
                        
                            <div class="col-lg-4 input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">Plan Vacunacion</span>
                                </div>
                                <input type="text" name="video" placeholder="Plan Vacunacion" class="form-control" id="basic-url" aria-describedby="basic-addon3"
                                value=<?php echo $search->getVideo() ?> required>
                            </div>

                        
                        <div class="row" id="buttonraro" style="border: 1px solid">
                            <div class="col-lg-1" style="text-align:center">
                                <button type="submit" onclick="return confirm('Are you sure?')"
                                    style="text-align:center" class="btn btn-dark">Modificar</button>
                            </div>
                </form>
            </div>
            <br>
            </div>
            </div>

    </main>

    <!-- ################################################################################################ -->