<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Colegio Colombo Hebreo</title>
	<link rel="icon" type="image/png" href="<?php echo base_url("images/icono.ico"); ?>" />
    <!-- Bootstrap Core CSS -->
	<link href="<?php echo base_url("assets/bootstrap/vendor/bootstrap/css/bootstrap.min.css"); ?>" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url("assets/bootstrap/vendor/metisMenu/metisMenu.min.css"); ?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url("assets/bootstrap/dist/css/sb-admin-2.css"); ?>" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="<?php echo base_url("assets/bootstrap/vendor/font-awesome/css/font-awesome.min.css"); ?>" rel="stylesheet" type="text/css">
    <!-- jQuery -->
    <script src="<?php echo base_url("assets/bootstrap/vendor/jquery/jquery.min.js"); ?>"></script>
	<!-- jQuery validate-->
	<script type="text/javascript" src="<?php echo base_url("assets/js/general/general.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/js/general/jquery.validate.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/js/validate/login.js"); ?>"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Autenticación<br>Usuario y Contraseña de Red</h3>
                    </div>
                    <div class="panel-body">
						<?php if(isset($msj)){?>
								<div class="alert alert-danger"><span class="fa fa-times">&nbsp;</span>
									<?php echo $msj; ?>
								</div>
						<?php } ?>
						<form  name="form" id="form" role="form" method="post" action="<?php echo base_url("login/validateUser"); ?>" >
                            <fieldset>
                                <div class="form-group">
									<input type="text" id="inputLogin" name="inputLogin" class="form-control" placeholder="Usuario" value="<?php echo get_cookie('user'); ?>" required autofocus >
                                </div>
                                <div class="form-group">
									<input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Contraseña" value="<?php echo get_cookie('password'); ?>" >
                                </div>
								<button type="submit" class="btn btn-lg btn-success btn-block" id='btnSubmit' name='btnSubmit'>Ingresar </button>
                            </fieldset>
                        </form>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>