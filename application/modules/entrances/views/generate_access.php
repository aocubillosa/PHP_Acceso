<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/validate/entrances/generate_access.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/general/jquery.validate.js"); ?>"></script>

<div id="page-wrapper">
	<br>
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
						<i class="fa fa-qrcode"></i> <?php if ($tipo == 1) { echo "GENERAR ACCESO FUNCIONARIO"; } if ($tipo == 2) { echo "GENERAR ACCESO VISITANTE"; } if ($tipo == 3) { echo "GENERAR ACCESO INTEGRANTE"; } ?>
					</h4>
				</div>
				<br>
				<div class="panel-body">
					<form name="form" id="form" role="form" method="post" >
						<input type="hidden" id="hddTipo" name="hddTipo" value="<?php echo $tipo ?>"/>
						<?php if ($tipo == 1) { ?>
							<input type="hidden" id="hddId" name="hddId" value="<?php echo $infoEmployees[0]["id_funcionario"]; ?>"/>
							<input type="hidden" id="hddIdTipoFun" name="hddIdTipoFun" value="<?php echo $infoEmployees[0]['fk_id_tipo_funcionario']; ?>"/>
						<?php } if ($tipo == 2) { ?>
							<input type="hidden" id="hddId" name="hddId" value="<?php echo $infoVisitors[0]["id_visitante"]; ?>"/>
						<?php } if ($tipo == 3) { ?>
							<input type="hidden" id="hddId" name="hddId" value="<?php echo $infoMembers[0]["id_integrante"]; ?>"/>
						<?php } ?>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group text-left">
									<label class="control-label" for="tipoDocumento">Tipo Documento:</label>
									<input type="text" id="tipoDocumento" name="tipoDocumento" class="form-control" value="<?php if ($tipo == 1) { echo $infoEmployees[0]["tipo_documento"]; } if ($tipo == 2) { echo $infoVisitors[0]["tipo_documento"]; } if ($tipo == 3) { echo $infoMembers[0]["tipo_documento"]; } ?>" readOnly >
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group text-left">
									<label class="control-label" for="numeroDocumento">Número Documento:</label>
									<input type="text" id="numeroDocumento" name="numeroDocumento" class="form-control" value="<?php if ($tipo == 1) { echo $infoEmployees[0]["numero_documento"]; } if ($tipo == 2) { echo $infoVisitors[0]["numero_documento"]; } if ($tipo == 3) { echo $infoMembers[0]["numero_documento"]; } ?>" readOnly >
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group text-left">
									<label class="control-label" for="firstName">Nombres:</label>
									<input type="text" id="firstName" name="firstName" class="form-control" value="<?php if ($tipo == 1) { echo $infoEmployees[0]["nombres"]; } if ($tipo == 2) { echo $infoVisitors[0]["nombres"]; } if ($tipo == 3) { echo $infoMembers[0]["nombres"]; } ?>" readOnly >
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group text-left">
									<label class="control-label" for="lastName">Apellidos:</label>
									<input type="text" id="lastName" name="lastName" class="form-control" value="<?php if ($tipo == 1) { echo $infoEmployees[0]["apellidos"]; } if ($tipo == 2) { echo $infoVisitors[0]["apellidos"]; } if ($tipo == 3) { echo $infoMembers[0]["apellidos"]; } ?>" readOnly >
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group text-left">
									<label class="control-label" for="email">Correo Electrónico:</label>
									<input type="text" class="form-control" id="email" name="email" value="<?php if ($tipo == 1) { echo $infoEmployees[0]["correo"]; } if ($tipo == 2) { echo $infoVisitors[0]["correo"]; } if ($tipo == 3) { echo $infoMembers[0]["correo"]; } ?>" readOnly />
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group text-left">
									<label class="control-label" for="movilNumber">Número Celular:</label>
									<input type="text" id="movilNumber" name="movilNumber" class="form-control" value="<?php if ($tipo == 1) { echo $infoEmployees[0]["telefono"]; } if ($tipo == 2) { echo $infoVisitors[0]["telefono"]; } if ($tipo == 3) { echo $infoMembers[0]["telefono"]; } ?>" readOnly >
								</div>
							</div>
						</div>
						<?php if ($infoEmployees) { ?>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group text-left">
									<label class="control-label" for="tipoFuncionario">Tipo Funcionario:</label>
									<input type="text" id="tipoFuncionario" name="tipoFuncionario" class="form-control" value="<?php echo $infoEmployees[0]["tipo_funcionario"]; ?>" readOnly >
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group text-left">
									<label class="control-label" for="cargo">Cargo:</label>
									<input type="text" id="cargo" name="cargo" class="form-control" value="<?php echo $infoEmployees[0]["cargo"]; ?>" readOnly >
								</div>
							</div>
						</div>
						<?php } if ($infoMembers) { ?>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group text-left">
									<label class="control-label" for="escuela">Escuela:</label>
									<input type="text" id="escuela" name="escuela" class="form-control" value="<?php echo $infoMembers[0]["nombre_escuela"]; ?>" readOnly >
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group text-left">
									<label class="control-label" for="funcion">Función:</label>
									<input type="text" id="funcion" name="funcion" class="form-control" value="<?php echo $infoMembers[0]["tipo_funcion"]; ?>" readOnly >
								</div>
							</div>
						</div>
						<?php } if ($infoVisitors || $infoMembers || $infoEmployees[0]['fk_id_tipo_funcionario'] == 2) { ?>
						<div class="row">
						    <div class="col-sm-6">
						        <div class="form-group text-left">
						            <label class="control-label" for="start_date">Fecha Desde: *</label>
						            <input type="text" class="form-control" id="start_date" name="start_date" placeholder="Fecha Desde" required />
						        </div>
						    </div>
						    <div class="col-sm-6">
						        <div class="form-group text-left">
						            <label class="control-label" for="finish_date">Fecha Hasta: *</label>
						            <input type="text" class="form-control" id="finish_date" name="finish_date" placeholder="Fecha Hasta" <?php if ($infoVisitors) { ?> disabled <?php } else { ?> required <?php } ?> />
						        </div>
						    </div>
						</div>
						<?php } if ($infoVisitors) { ?>
						<div class="row">
						    <div class="col-sm-6">
						        <div class="form-group text-left">
						            <label class="control-label" for="start_time_slider">Hora Desde: *</label>
						            <input type="text" class="form-control" id="start_time" name="start_time" readonly placeholder="Hora Desde" required />
						            <div id="start_time_slider" style="margin-top: 10px;"></div>
						        </div>
						    </div>
						    <div class="col-sm-6">
						        <div class="form-group text-left">
						            <label class="control-label" for="finish_time_slider">Hora Hasta: *</label>
						            <input type="text" class="form-control" id="finish_time" name="finish_time" readonly placeholder="Hora Hasta" required />
						            <div id="finish_time_slider" style="margin-top: 10px;"></div>
						        </div>
						    </div>
						</div>
						<div class="row">
							<div class="col-sm-12">
						        <div class="form-group text-left">
						            <label class="control-label" for="motivo">Motivo: *</label>
						            <textarea type="text" class="form-control" id="motivo" name="motivo" placeholder="Motivo" rows="5" required style="resize: none;"></textarea>
						        </div>
						    </div>
						</div>
						<?php } ?>
						<div class="form-group">
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
						<div class="form-group">
							<div class="row" align="center">
								<div style="width:50%;" align="center">
									<button type="button" id="btnSubmit" name="btnSubmit" class="btn btn-primary" >
										Generar QR <span class="fa fa-qrcode" aria-hidden="true">
									</button>&nbsp;
									<a href="<?php if($tipo == 1) { echo base_url('entrances/searchEmployees'); } if($tipo == 2) { echo base_url('entrances/searchVisitors'); } if($tipo == 3) { echo base_url('settings/members/' . $infoMembers[0]["id_escuela"] . '/1'); } ?>" class="btn btn-success">
					                    Regresar <span class="fa fa-undo" aria-hidden="true"></span>
					                </a>
								</div>
							</div>
						</div>
					</form>
				</div>
				<br>
			</div>
		</div>
	</div>
</div>