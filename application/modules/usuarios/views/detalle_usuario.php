<div id="page-wrapper">
	<br>
	<div class="row">
		<div class="col-lg-1"></div>
		<div class="col-lg-5">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<i class="fa fa-image"></i> <strong>FOTO USUARIO</strong>
				</div>
				<div class="panel-body">
					<?php 
						if($UserInfo[0]["photo"]) {
							$URLimagen = base_url($UserInfo[0]["photo"]);
						} else { 
							$URLimagen = base_url('images/avatar.png');
						}
					?>
					<div class="form-group">
						<div class="row" align="center">
							<img src="<?php echo $URLimagen; ?>" class="img-rounded" alt="Foto usuario" width="200" height="200" />
						</div>
					</div>
					<form  name="form" id="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url("usuarios/do_upload"); ?>">
						<div class="form-group">
							<div class="col-sm-5">
								 <input type="file" name="userfile" />
							</div>
						</div>
						<div class="form-group">
							<div class="row" align="center">
								<div style="width:50%;" align="center">
									<button type="submit" id="btnFoto" name="btnFoto" class="btn btn-primary" >
										Guardar <span class="fa fa-floppy-o" aria-hidden="true">
									</button> 
								</div>
							</div>
						</div>
						<?php if($error){ ?>
						<div class="alert alert-danger">
							<?php 
								echo "<strong>Error :</strong>";
								pr($error); 
							?>
						</div>
						<?php } ?>
						<div class="alert alert-warning">
								<strong>Nota :</strong><br>
								Formato permitido: gif - jpg - png - jpeg<br>
								Tamaño máximo: 3000 KB<br>
								Ancho máximo: 2024 pixels<br>
								Altura máxima: 2024 pixels<br>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-lg-5">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<i class="fa fa-user"></i> <strong>PERFIL USUARIO</strong>
				</div>
				<div class="panel-body">
					<?php
					$retornoExito = $this->session->flashdata('retornoExito');
					if ($retornoExito) {
					?>
						<div class="alert alert-success ">
							<span class="fa fa-check" aria-hidden="true"></span>
							<?php echo $retornoExito ?>
						</div>
					<?php
					}
					$retornoError = $this->session->flashdata('retornoError');
					if ($retornoError) {
					?>
						<div class="alert alert-danger ">
							<span class="fa fa-exclamation-triangle" aria-hidden="true"></span>
							<?php echo $retornoError ?>
						</div>
					<?php
					}
					?>
					<form  name="form" id="form" class="form-horizontal" method="post">
						<div class="form-group">
							<div class="col-sm-6">
								<label for="from">Nombres: </label>
								<input type="text" id="nombre_equipo" name="nombre_equipo" class="form-control" value="<?php echo $UserInfo?$UserInfo[0]["first_name"]:""; ?>" placeholder="Nombre Equipo" readOnly >
							</div>
							<div class="col-sm-6">
								<label for="from">Apellidos: </label>
								<input type="text" id="numero_unidad" name="numero_unidad" class="form-control" value="<?php echo $UserInfo?$UserInfo[0]["last_name"]:""; ?>" placeholder="Número Unidad" readOnly >
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-6">
								<label for="from">Usuario: </label>
								<input type="text" id="fabricante" name="fabricante" class="form-control" value="<?php echo $UserInfo?$UserInfo[0]["log_user"]:""; ?>" placeholder="Fabricante" readOnly >
							</div>
							<div class="col-sm-6">
								<label for="modelo">Correo: </label>
								<input type="text" id="modelo" name="modelo" class="form-control" value="<?php echo $UserInfo?$UserInfo[0]["email"]:""; ?>" placeholder="Modelo" readOnly >
							</div>	
						</div>
						<div class="form-group">
							<div class="row" align="center">
								<div style="width:80%;" align="center">
									<div id="div_load" style="display:none">
										<div class="progress progress-striped active">
											<div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
												<span class="sr-only">45% completado</span>
											</div>
										</div>
									</div>
									<div id="div_error" style="display:none">
										<div class="alert alert-danger"><span class="fa fa-times" id="span_msj">&nbsp;</span></div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>