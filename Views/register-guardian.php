<section class="login-block">
<div class="container">
    <div class="row">
        <div class="col-md-4 login-sec">
            <h2 class="text-center">Pet Hero</h2>
            <form class="register-guardian-form" action="<?php echo FRONT_ROOT. "Auth/registerGuardian" ?>" method="POST">
                <div class=" form-group">
                    <label for="email" class="text-uppercase">Mail</label>
                    <input type="email" name="email" class="form-control" placeholder="example@mail.com" required>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="text-uppercase">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="******" required>
                </div>
                <div class="form-group">
                    <label for="inputEdad" class="text-uppercase">Age</label>
                    <input type="number" min="18" name="age" class="form-control" placeholder=">18" required>
                </div>
                <form class="login-form">
                    <div class="form-group">
                        <label for="inputFullname" class="text-uppercase">Full mame</label>
                        <input type="text" name="fullname" class="form-control" placeholder="John Doe" required>
                    </div>
                    <div class="form-group">
                        <label for="inputDni" class="text-uppercase">DNI</label>
                        <input type="text" name="dni" class="form-control" placeholder="DNI" required>
                    </div>

                    <div class="form-group">
                        <label for="tipoMascota" class="text-uppercase">Tamaño a Cuidar</label>
                        <select name="tipoMascota">
                            <option value="chico">Chico</option>
                            <option value="mediano" selected>Mediano</option>
                            <option value="grande">Grande</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="remuneracionEsperada" class="text-uppercase">Remuneracion</label>
                        <input type="number" name="remuneracionEsperada" class="form-control" placeholder="Remuneracion" required>
                    </div>
                    <div class="form-check">
                        <button type="submit" class="btn btn-login float-right" id="submitGuardianButton"
                            onclick="">Register as Guardian</button>
                    </div>
                    

                </form>
        </div>
        <div class="col-md-8 banner-sec">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <img class="d-block img-fluid"
                            src="https://d3mvlb3hz2g78.cloudfront.net/wp-content/uploads/2020/07/thumb_720_450_dreamstime_m_156181857.jpg"
                            alt="First slide">
                        <div class="carousel-caption d-none d-md-block">
                            <div class="banner-text">
                                <h2></h2>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</section>