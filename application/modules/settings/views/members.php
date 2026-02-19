<script type="text/javascript" src="<?php echo base_url("assets/js/validate/settings/members.js"); ?>"></script>

<div id="page-wrapper">
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
					<i class="fa fa-user fa-fw"></i> INTEGRANTES
					</h4>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-list"></i> <?php echo $info?"Lista de Integrantes ".$info[0]["nombre_escuela"]:"Lista de Integrantes"; ?>
					<div class="pull-right">
						<div class="btn-group">
							<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="x">
								Adicionar Integrante <span class="fa fa-plus" aria-hidden="true"></span>
							</button>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<ul class="nav nav-pills">
						<li <?php if($state == 1){ echo "class='active'";} ?>><a href="<?php echo base_url("settings/members/$idSchool/1"); ?>">Integrantes Activos</a>
						</li>
						<li <?php if($state == 2){ echo "class='active'";} ?>><a href="<?php echo base_url("settings/members/$idSchool/2"); ?>">Integrantes Inactivos</a>
						</li>
					</ul>
					<br>
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
						if(!$info){
							echo '<div class="col-lg-12">
									<p class="text-danger"><span class="fa fa-exclamation-triangle" aria-hidden="true"></span> No hay registros en el sistema.</p>
								</div>';
						} else {
					?>
					<input type="hidden" id="idSchool" name="idSchool" value="<?php echo $info[0]["id_escuela"]; ?>"/>
					<table width="100%" class="table table-striped table-bordered table-hover small" id="dataTables">
						<thead>
							<tr>
								<th class="text-center">Tipo Documento</th>
								<th class="text-center">No. Documento</th>
								<th class="text-center">Nombres</th>
								<th class="text-center">Apellidos</th>
								<th class="text-center">Función</th>
								<th class="text-center">Correo</th>
								<th class="text-center">Celular</th>
								<th class="text-center">Estado</th>
								<th class="text-center">Opciones</th>
							</tr>
						</thead>
						<tbody>
						<?php
							foreach ($info as $lista):
								echo "<tr>";
								echo "<td>" . $lista['tipo_documento'] . "</td>";
								echo "<td class='text-right'>" . $lista['numero_documento'] . "</td>";
								echo "<td>" . $lista['nombres'] . "</td>";
								echo "<td>" . $lista['apellidos'] . "</td>";
								echo "<td>" . $lista['tipo_funcion'] . "</td>";
								echo "<td>" . $lista['correo'] . "</td>";
								echo "<td class='text-right'>" . $lista["telefono"] . "</td>";
								echo "<td class='text-center'>";
								switch ($lista['state']) {
									case 1:
										$valor = 'Activo';
										$clase = "text-success";
										break;
									case 2:
										$valor = 'Inactivo';
										$clase = "text-danger";
										break;
								}
								echo '<p class="' . $clase . '"><strong>' . $valor . '</strong></p>';
								echo "</td>";
								echo "<td class='text-center'>";
								?>
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_integrante']; ?>" >
										Editar <span class="fa fa-pencil-square-o" aria-hidden="true">
									</button>
									<button type="button" class="btn btn-primary btn-xs" <?php if(!empty($lista['permiso']) || $lista['state'] == 2) { echo 'disabled'; } ?> onclick="<?php if(empty($lista['permiso'])) { echo 'window.location.href=\'' . base_url('entrances/generateAccess/' . $lista['numero_documento']) . '/3\''; } ?>">
									    Generar <span class="fa fa-qrcode" aria-hidden="true"></span>
									</button>
								<?php
								echo "</td>";
							echo "</tr>";
							endforeach;
						?>
						</tbody>
					</table>
					<div style="display: flex; justify-content: center;">
						<div class="btn-group">
							<a href="<?php echo base_url('settings/schools'); ?>" class="btn btn-success">
			                    Regresar <span class="fa fa-undo" aria-hidden="true"></span>
			                </a>
						</div>
					</div>
				<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade text-center" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" id="tablaDatos">
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	$('#dataTables').DataTable({
		responsive: true,
		"pageLength": 50
	});
});
</script>