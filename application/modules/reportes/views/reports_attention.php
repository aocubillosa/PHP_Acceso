<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(function(){
        $(".btn-primary").click(function () {
            var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
                url: base_url + 'reportes/modalAtencionFecha',
                data: {'idLink': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatos').html(data);
                }
            });
        });
    });
</script>
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
        <div class="col-lg-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-10">
                            <i class="fa fa-ticket fa-fw"></i> <strong>LISTA DE ATENCIONES</strong>
                        </div>
                        <div class="col-lg-2">
                            <form  name="form_descarga" id="form_descarga" method="post" action="<?php echo base_url("reportes/generarReporteAtencionXLS"); ?>" target="_blank">
                                <input type="hidden" class="form-control" id="bandera" name="bandera" value="1" />
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
                            <strong>Fecha:</strong> <?php echo date('Y-m-d'); ?>
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
        <div class="col-lg-3">
            <div class="panel panel-violeta">
                <div class="panel-heading">
                    <i class="fa fa-ticket fa-fw"></i> ATENCIONES
                </div>
                <div class="panel-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item" disabled>
                            <p class="text-info"><i class="fa fa-tag fa-fw"></i><strong> No. Atenciones Hoy</strong>
                                <span class="pull-right text-muted small"><em><?php echo $noAtencionHOY; ?></em>
                                </span>
                            </p>
                        </a>
                        <a href="#" class="list-group-item" disabled>
                            <p class="text-success"><i class="fa fa-tag  fa-fw"></i><strong> No. Atenciones esta Semana</strong>
                                <span class="pull-right text-muted small"><em><?php echo $noAtencionSEMANA; ?></em>
                                </span>
                            </p>
                        </a>
                        <a href="#" class="list-group-item" disabled>
                            <p class="text-danger"><i class="fa fa-tag  fa-fw"></i><strong> No. Atenciones este Mes</strong>
                                <span class="pull-right text-muted small"><em><?php echo $noAtencionMES; ?></em>
                                </span>
                            </p>
                        </a>
                    </div>
                    <div class="list-group">
                        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal" id="x">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Buscar Atenciones x Fecha
                        </button>
                    </div>
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