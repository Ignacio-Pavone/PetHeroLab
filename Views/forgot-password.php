<?php 
require_once VIEWS_PATH . 'header.php';
include('back-bar.php');
?>

<section class="login-block" style="height:100vh;">
    
    <main class="py-1">

        <section id="login-block" class="mb-5">
            
            <div class="container" id="dataUser">
                <center>
                    <h3 class="mb" id="dataUser">Recuperar Contraseña</h3>
                </center>
                <hr>
                <br>
            <form action="<?php echo FRONT_ROOT . "Auth/sendPass"?>">
            <div class="row">
            <div class="col-lg-3 input-group mb-3" style="margin-left: 260px">
                <div class="input-group-prepend">
                    <span class="btn btn-md btn-dark m-0 px-3"  id="basic-addon1">Email</span>
                </div>
                <input type="text" class="form-control" placeholder="jhondoe@gmail.com" name="email"
                aria-describedby="basic-addon1" required>
            </div>

                 <div class="col-lg-3 input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="btn btn-md btn-dark m-0 px-3 for="inputGroupSelect01">Tipo Usuario</label>
                            </div>
                            <select class="custom-select" name="tipo">
                                <option value="guardian">
                                    Guardian
                                </option>
                                <option value="owner">
                                     Duenio
                                </option>

                            </select>
                        </div>
                     </select>
            
            <div class="row" id="buttonraro" style="border: 1px solid">
                <div class="col-lg-1" style="text-align:center">
                    <button type="submit" onclick="return confirm('Are you sure?')"
                    style="text-align:center" class="btn btn-login">Enviar
                    </button>
                </div>
            </div>
            </form>
            <br>

        </section>

    </main>

