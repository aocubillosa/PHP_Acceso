<script type="text/javascript" src="<?php echo base_url("assets/js/validate/access/links.js"); ?>"></script>

<div id="page-wrapper">
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
					<i class="fa fa-cogs fa-fw"></i> ADMINISTRAR ACCESO AL SISTEMA
					</h4>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-link"></i> ENLACES SUBMENÚ
					<div class="pull-right">
						<div class="btn-group">
							<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="x">
								Adicionar Submenú <span class="fa fa-plus" aria-hidden="true"></span>
							</button>
						</div>
					</div>
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
					if($info){
				?>
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class="text-center">Nombre Menú</th>
								<th class="text-center">Nombre Submenú</th>
								<th class="text-center">URL Enlace</th>
								<th class="text-center">Icono Enlace</th>
								<th class="text-center">Orden</th>
								<th class="text-center">Estado</th>
								<th class="text-center">Opciones</th>
							</tr>
						</thead>
						<tbody>
						<?php
							foreach ($info as $lista):
								echo "<tr>";
								echo "<td>" . $lista['menu_name'] . "</td>";
								echo "<td>" . $lista['link_name'] . "</td>";
								echo "<td>" . $lista['link_url'] . "</td>";
								echo "<td class='text-center'>";
								echo '<button type="button" class="btn btn-info btn-circle"><i class="fa ' . $lista['link_icon'] . '"></i>';
								echo "</td>";
								echo "<td class='text-center'>" . $lista['order'] . "</td>";
								echo "<td class='text-center'>";
								switch ($lista['link_state']) {
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
								<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_link']; ?>" >
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
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>

<script>
$(document).ready( function() {
	
	$('#dataTables').DataTable({
		responsive: true,
		"pageLength": 50,
		"order": [[ 0, "asc" ],[ 4, "asc" ]]
	});
});
</script>