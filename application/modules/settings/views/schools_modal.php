<script type="text/javascript" src="<?php echo base_url("assets/js/validate/settings/schools.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Formulario de Escuela
		<br><small>Adicionar/Editar Escuela</small>
	</h4>
</div>
<div class="modal-body">
	<p class="text-danger text-left">Los campos con * son obligatorios.</p>
	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_escuela"]:""; ?>"/>
		<div class="row">
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="nit">Nit: *</label>
					<input type="text" id="nit" name="nit" class="form-control" value="<?php echo $information?$information[0]["nit"]:""; ?>" <?php if(!empty($information)) { ?> readOnly <?php } ?> placeholder="Nit" required >
				</div>
			</div>
			<?php if($information){ ?>
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="state">Estado: *</label>
					<select name="state" id="state" class="form-control" required>
						<option value=''>Seleccione...</option>
						<option value=1 <?php if($information[0]["estado"] == 1) { echo "selected"; }  ?>>Activo</option>
						<option value=2 <?php if($information[0]["estado"] == 2) { echo "selected"; }  ?>>Inactivo</option>
					</select>
				</div>
			</div>
			<?php } ?>
		</div>
		<div class="row">
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="nombre">Nombre: *</label>
					<input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $information?$information[0]["nombre_escuela"]:""; ?>" placeholder="Nombre" required >
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="telefono">Teléfono: *</label>
					<input type="text" id="telefono" name="telefono" class="form-control" value="<?php echo $information?$information[0]["numero_telefono"]:""; ?>" placeholder="Teléfono" required >
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="direccion">Dirección: *</label>
					<input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $information?$information[0]["direccion"]:""; ?>" placeholder="Dirección" />
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