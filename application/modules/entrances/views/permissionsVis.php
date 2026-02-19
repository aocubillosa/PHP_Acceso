<script type="text/javascript" src="<?php echo base_url("assets/js/validate/entrances/permissions.js"); ?>"></script>

<div id="page-wrapper">
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
					<i class="fa fa-qrcode fa-fw"></i> VISITANTES - PERMISOS
					</h4>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-list"></i> Lista de Permisos de Visitantes
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
						if(!$infoPermisosVis){ 
							echo '<div class="col-lg-12">
									<p class="text-danger"><span class="fa fa-exclamation-triangle" aria-hidden="true"></span> No hay registros en el sistema.</p>
								</div>';
						} else {
					?>
					<input type="hidden" id="hddTipo" name="hddTipo" value="<?php echo $tipo; ?>"/>
					<table width="100%" class="table table-striped table-bordered table-hover small" id="dataTables">
						<thead>
							<tr>
								<th class="text-center">No. Documento</th>
								<th class="text-center">Tipo Documento</th>
								<th class="text-center">Nombre Visitante</th>
								<th class="text-center">Fecha Inicio</th>
								<th class="text-center">Fecha Finalización</th>
								<th class="text-center">Opciones</th>
							</tr>
						</thead>
						<tbody>
						<?php
							foreach ($infoPermisosVis as $lista):
								echo "<tr>";
								echo "<td class='text-right'>" . $lista['numero_documento'] . "</td>";
								echo "<td>" . $lista['tipo_documento'] . "</td>";
								echo "<td>" . $lista['nombres'] . ' ' . $lista['apellidos'] . "</td>";
								echo "<td>" . $lista['fecha_entrada'] . "</td>";
								echo "<td>" . $lista['fecha_finaliza'] . "</td>";
								echo "</td>";
								echo "<td class='text-center'>";
								?>
									<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_permiso']; ?>" >
										Detalle <span class="fa fa-eye" aria-hidden="true">
									</button>&nbsp;&nbsp;&nbsp;
									<button type="button" id="<?php echo $lista['id_permiso']; ?>" class='btn btn-danger btn-xs' title="Delete">
										Cancelar <i class="fa fa-ban"></i>
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