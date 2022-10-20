<form action = "<?php echo FRONT_ROOT. "Auth/login" ?>" method="POST">
<section class="login-block">
    <div class="container">
	<div class="row">
		<div class="col-md-4 login-sec">
		    <h2 class="text-center">Login Now</h2>
		    <form class="login-form">
  <div class="form-group">
    <label for="exampleInputEmail1" class="text-uppercase">Email</label>
    <input type="text" name = "email" class="form-control" placeholder="">
    
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1" class="text-uppercase">Password</label>
    <input type="password" name = "password" class="form-control" placeholder="">
  </div>
  <div>
    <button type="submit" class="btn btn-login float-right">Submit</button>
    <a href="<?php echo FRONT_ROOT. "Auth/showRegisterGuardian" ?>">Register as Guardian</a> <br>
    <a href="<?php echo FRONT_ROOT. "Auth/showRegisterDuenio" ?>">Register as Duenio</a>

    </div>
  
		</div>
		<div class="col-md-8 banner-sec">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                 <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                  </ol>
            <div class="carousel-inner" role="listbox">

    </div>
</div>
</form>
<?php if (isset($_SESSION['message'])) { ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
           <?php echo $_SESSION['message'];
                 unset($_SESSION['message']); 
            ?>
     </div>
 <?php } ?>
</section>