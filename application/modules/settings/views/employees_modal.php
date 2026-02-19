<script type="text/javascript" src="<?php echo base_url("assets/js/validate/settings/employees.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Formulario de Funcionario
		<br><small>Adicionar/Editar Funcionario</small>
	</h4>
</div>
<div class="modal-body">
	<p class="text-danger text-left">Los campos con * son obligatorios.</p>
	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_funcionario"]:""; ?>"/>
		<div class="row">
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="tipoDocumento">Tipo Documento: *</label>
					<select name="tipoDocumento" id="tipoDocumento" class="form-control" required >
						<option value="">Seleccione...</option>
						<?php for ($i = 0; $i < count($tipo_documento); $i++) { ?>
							<option value="<?php echo $tipo_documento[$i]["id_tipo_documento"]; ?>" <?php if($information && $information[0]["fk_id_tipo_documento"] == $tipo_documento[$i]["id_tipo_documento"]) { echo "selected"; } ?>><?php echo $tipo_documento[$i]["tipo_documento"]; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="numeroDocumento">Número Documento: *</label>
					<input type="text" id="numeroDocumento" name="numeroDocumento" class="form-control" value="<?php echo $information?$information[0]["numero_documento"]:""; ?>" <?php if(!empty($information)) { ?> readOnly <?php } ?> placeholder="Número Documento" required >
				</div>
			</div>
			<?php if($information){ ?>
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="state">Estado: *</label>
					<select name="state" id="state" class="form-control" required>
						<option value=''>Seleccione...</option>
						<option value=1 <?php if($information[0]["state"] == 1) { echo "selected"; }  ?>>Activo</option>
						<option value=2 <?php if($information[0]["state"] == 2) { echo "selected"; }  ?>>Inactivo</option>
					</select>
				</div>
			</div>
			<?php } ?>
		</div>
		<div class="row">
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="firstName">Nombres: *</label>
					<input type="text" id="firstName" name="firstName" class="form-control" value="<?php echo $information?$information[0]["nombres"]:""; ?>" placeholder="Nombres" required >
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="lastName">Apellidos: *</label>
					<input type="text" id="lastName" name="lastName" class="form-control" value="<?php echo $information?$information[0]["apellidos"]:""; ?>" placeholder="Apellidos" required >
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="tipoFuncionario">Tipo Funcionario: *</label>
					<select name="tipoFuncionario" id="tipoFuncionario" class="form-control" required >
						<option value="">Seleccione...</option>
						<?php for ($i = 0; $i < count($tipo_funcionario); $i++) { ?>
							<option value="<?php echo $tipo_funcionario[$i]["id_tipo_funcionario"]; ?>" <?php if($information && $information[0]["fk_id_tipo_funcionario"] == $tipo_funcionario[$i]["id_tipo_funcionario"]) { echo "selected"; }  ?>><?php echo $tipo_funcionario[$i]["tipo_funcionario"]; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="cargo">Cargo: *</label>
					<select name="cargo" id="cargo" class="form-control" required >
						<option value="">Seleccione...</option>
						<?php for ($i = 0; $i < count($cargo); $i++) { ?>
							<option value="<?php echo $cargo[$i]["id_cargo"]; ?>" <?php if($information && $information[0]["fk_id_cargo"] == $cargo[$i]["id_cargo"]) { echo "selected"; }  ?>><?php echo $cargo[$i]["cargo"]; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="email">Correo Electrónico: *</label>
					<input type="text" class="form-control" id="email" name="email" value="<?php echo $information?$information[0]["correo"]:""; ?>" placeholder="Correo Electrónico" />
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="movilNumber">Número Celular: *</label>
					<input type="text" id="movilNumber" name="movilNumber" class="form-control" value="<?php echo $information?$information[0]["telefono"]:""; ?>" placeholder="Número Celular" required >
				</div>
			</div>
		</div>
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
						Guardar <span class="fa fa-floppy-o" aria-hidden="true">
					</button> 
				</div>
			</div>
		</div>
	</form>
</div>