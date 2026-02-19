<script type="text/javascript" src="<?php echo base_url("assets/js/validate/settings/users.js"); ?>"></script>

<div id="page-wrapper">
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
					<i class="fa fa-gear fa-fw"></i> CONFIGURACIÓN - USUARIOS
					</h4>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-users"></i> LISTA DE USUARIOS DEL SISTEMA
					<div class="pull-right">
						<div class="btn-group">
							<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="x">
								Adicionar Usuario <span class="fa fa-plus" aria-hidden="true"></span>
							</button>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<ul class="nav nav-pills">
						<li <?php if($state == 1){ echo "class='active'";} ?>><a href="<?php echo base_url("settings/users/1"); ?>">Usuarios Activos</a>
						</li>
						<li <?php if($state == 2){ echo "class='active'";} ?>><a href="<?php echo base_url("settings/users/2"); ?>">Usuarios Inactivos</a>
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
					<table width="100%" class="table table-striped table-bordered table-hover small" id="dataTables">
						<thead>
							<tr>
								<th class="text-center">Tipo Documento</th>
								<th class="text-center">No. Documento</th>
								<th class="text-center">Nombres</th>
								<th class="text-center">Apellidos</th>
								<th class="text-center">Usuario</th>
								<th class="text-center">Correo</th>
								<th class="text-center">Celular</th>
								<th class="text-center">Rol</th>
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
								echo "<td>" . $lista['first_name'] . "</td>";
								echo "<td>" . $lista['last_name'] . "</td>";
								echo "<td>" . $lista['log_user'] . "</td>";
								echo "<td>" . $lista['email'] . "</td>";
								echo "<td class='text-right'>" . $lista["movil"] . "</td>";
								echo "<td class='text-center'>";
								echo '<p class="' . $lista['style'] . '"><strong>' . $lista['role_name'] . '</strong></p>';
								echo "</td>";
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
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_user']; ?>" >
										Editar <span class="fa fa-pencil-square-o" aria-hidden="true">
									</button>
								<?php
								echo "</td>";
							echo "</tr>";
							endforeach;
						?>
						</tbody>
					</table>
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