<div id="page-wrapper">
	<div class="row"><br>
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
						<i class="fa fa-file-excel-o fa-fw"></i> REPORTE ATENCIÓN AL CIUDADANO
					</h4>
				</div>
			</div>
		</div>
    </div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading"> 
					<div class="row">
                        <div class="col-lg-10">
                            <a class="btn btn-success btn-xs" href=" <?php echo base_url('reportes/attentionCitizen'); ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a> 
                            <i class="fa fa-ticket fa-fw"></i> <strong>LISTA DE ATENCIONES</strong>
                        </div>
                        <div class="col-lg-2">
                            <form  name="form_descarga" id="form_descarga" method="post" action="<?php echo base_url("reportes/generarReporteAtencionXLS"); ?>" target="_blank">
                            	<input type="hidden" class="form-control" id="bandera" name="bandera" value="2" />
                            	<input type="hidden" class="form-control" id="from" name="from" value="<?php echo $from; ?>" />
								<input type="hidden" class="form-control" id="to" name="to" value="<?php echo $to; ?>" />
                                <?php
                                if($listaAtencion){
                                ?>
                                    <div align="right">
                                        <button type="submit" class="btn btn-success btn-xs" id="btnSubmit2" name="btnSubmit2" value="1" >Descargar <span class="fa fa-file-excel-o" aria-hidden="true" /></button>
                                    </div>
                                <?php
                                }
                                ?>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <strong>Desde:</strong> <?php echo $from; ?> - <strong>Hasta:</strong> <?php echo $to; ?>
                        </div>
                    </div>
				</div>
				<div class="panel-body">
				<?php
				if(!$listaAtencion){ 
				?>
			        <div class="col-lg-12">
			            <small>
			                <p class="text-danger"><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> No hay registros en la base de datos.</p>
			            </small>
			        </div>
				<?php
				} else {
				?>
					<table width="100%" class="table table-hover" id="dataTables">
						<thead>
							<tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Indicador</th>
                                <th class="text-center">Ciudadano</th>
                                <th class="text-center">Tipo Atención</th>
                                <th class="text-center">Solución</th>
							</tr>
						</thead>
						<tbody>
						<?php
							$i = 1;
							foreach ($listaAtencion as $lista):
								if (!empty($lista['fk_id_visitante'])) {
                                    $ciudadano = $lista['nombres'] . ' ' . $lista['apellidos'];
                                } else {
                                    $ciudadano = $lista['nombre'] . ' ' . $lista['apellido'];
                                }
                                echo '<tr>';
                                echo '<td class="text-center">' . $i . '</td>';
                                echo '<td class="text-center">' . $lista['fecha'] . '</td>';
                                echo '<td class="text-center">' . $lista['indicador'] . '</td>';
                                echo '<td class="text-center">' . $ciudadano . '</td>';
                                echo '<td class="text-center">' . $lista['tipo_atencion'] . '</td>';
                                echo '<td class="text-center">' . $lista['solucion'] . '</td>';
                                echo '</tr>';
                                $i++;
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

<script>
$(document).ready(function() {
    $('#dataTables').DataTable({
        responsive: true,
		 "ordering": false,
		 paging: false,
		"searching": false,
		"info": false
    });
});
</script>