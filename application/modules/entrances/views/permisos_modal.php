<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="exampleModalLabel"><?php if (!empty($infoPermiso["fk_id_tipo_funcionario"])) { ?> Permisos Funcionarios <?php } else { ?> Permisos Visitantes <?php } ?>
	</h4>
</div>
<div class="modal-body">
	<form name="form" id="form" role="form" method="post" >
		<div class="row">
			<div class="col-lg-4"></div>
			<div class="col-lg-4">
				<div class="form-group">
					<div align="center">
						<img src="<?php echo base_url($infoPermiso["qr_code_img_doc"]); ?>" class="img-rounded" width="250" height="250" alt="QR CODE" />
					</div>
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="tipoDocumento">Tipo Documento:</label>
					<input type="text" id="tipoDocumento" name="tipoDocumento" class="form-control" value="<?php echo $infoPermiso["tipo_documento"]; ?>" readOnly >
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="numeroDocumento">Número Documento:</label>
					<input type="text" id="numeroDocumento" name="numeroDocumento" class="form-control" value="<?php echo $infoPermiso["numero_documento"]; ?>" readOnly >
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="firstName">Nombres:</label>
					<input type="text" id="firstName" name="firstName" class="form-control" value="<?php echo $infoPermiso["nombres"]; ?>" readOnly >
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="lastName">Apellidos:</label>
					<input type="text" id="lastName" name="lastName" class="form-control" value="<?php echo $infoPermiso["apellidos"]; ?>" readOnly >
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="email">Correo Electrónico:</label>
					<input type="text" class="form-control" id="email" name="email" value="<?php echo $infoPermiso["correo"]; ?>" readOnly />
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="movilNumber">Número Celular:</label>
					<input type="text" id="movilNumber" name="movilNumber" class="form-control" value="<?php echo $infoPermiso["telefono"]; ?>" readOnly >
				</div>
			</div>
		</div>
		<?php if (!empty($infoPermiso["fk_id_funcionario"])) { ?>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="tipoFuncionario">Tipo Funcionario:</label>
					<input type="text" id="tipoFuncionario" name="tipoFuncionario" class="form-control" value="<?php echo $infoPermiso["tipo_funcionario"]; ?>" readOnly >
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="cargo">Cargo:</label>
					<input type="text" id="cargo" name="cargo" class="form-control" value="<?php echo $infoPermiso["cargo"]; ?>" readOnly >
				</div>
			</div>
		</div>
		<?php } if (!empty($infoPermiso["fk_id_visitante"])) { ?>
		<div class="row">
		    <div class="col-sm-6">
		        <div class="form-group text-left">
		            <label class="control-label" for="start_date">Fecha Desde:</label>
		            <input type="text" id="start_date" name="start_date" class="form-control" value="<?php echo $infoPermiso["fecha_entrada"]; ?>" readOnly />
		        </div>
		    </div>
		    <div class="col-sm-6">
		        <div class="form-group text-left">
		            <label class="control-label" for="finish_date">Fecha Hasta:</label>
		            <input type="text" id="finish_date" name="finish_date" class="form-control" value="<?php echo $infoPermiso["fecha_finaliza"]; ?>" readOnly />
		        </div>
		    </div>
		</div>
		<div class="row">
			<div class="col-sm-12">
		        <div class="form-group text-left">
		            <label class="control-label" for="motivo">Motivo:</label>
		            <textarea type="text" id="motivo" name="motivo" class="form-control" rows="5" readOnly style="resize: none;"><?php echo $infoPermiso["motivo"]; ?></textarea>
		        </div>
		    </div>
		</div>
		<?php } if (!empty($infoPermiso["fk_id_integrante"])) { ?>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="escuela">Escuela :</label>
					<input type="text" id="escuela" name="escuela" class="form-control" value="<?php echo $infoPermiso["nombre_escuela"]; ?>" readOnly >
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="funcion">Función :</label>
					<input type="text" id="funcion" name="funcion" class="form-control" value="<?php echo $infoPermiso["tipo_funcion"]; ?>" readOnly >
				</div>
			</div>
		</div>
		<?php } ?>
	</form>
</div>