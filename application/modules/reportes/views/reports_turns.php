<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(function(){
        $(".btn-primary").click(function () {
            var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
                url: base_url + 'reportes/modalTurnosFecha',
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
						<i class="fa fa-file-excel-o fa-fw"></i> REPORTE GESTIÓN DE TURNOS
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
                            <i class="fa fa-ticket fa-fw"></i> <strong>LISTA DE TURNOS</strong>
                        </div>
                        <div class="col-lg-2">
                            <form  name="form_descarga" id="form_descarga" method="post" action="<?php echo base_url("reportes/generarReporteTurnosXLS"); ?>" target="_blank">
                                <input type="hidden" class="form-control" id="bandera" name="bandera" value="1" />
                                <?php
                                if($listaTurnos){ 
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
                if(!$listaTurnos){ 
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
                                <th class="text-center">Visitante</th>
                                <th class="text-center">Categoria</th>
                                <th class="text-center">Turno</th>
                                <th class="text-center">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $i = 1;
                            foreach ($listaTurnos as $lista):
                                echo '<tr>';
                                echo '<td class="text-center">' . $i . '</td>';
                                echo '<td class="text-center">' . $lista['fecha'] . '</td>';
                                echo '<td class="text-center">' . $lista['nombres'] . ' ' . $lista['apellidos'] . '</td>';
                                echo '<td class="text-center">' . $lista['categoria'] . '</td>';
                                echo '<td class="text-center">' . $lista['turno'] . '</td>';
                                echo '<td class="text-center">' . $lista['estado_turno'] . '</td>';
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
                    <i class="fa fa-ticket fa-fw"></i> TURNOS
                </div>
                <div class="panel-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item" disabled>
                            <p class="text-info"><i class="fa fa-tag fa-fw"></i><strong> No. Turnos Hoy</strong>
                                <span class="pull-right text-muted small"><em><?php echo $noTurnosHOY; ?></em>
                                </span>
                            </p>
                        </a>
                        <a href="#" class="list-group-item" disabled>
                            <p class="text-success"><i class="fa fa-tag  fa-fw"></i><strong> No. Turnos esta Semana</strong>
                                <span class="pull-right text-muted small"><em><?php echo $noTurnosSEMANA; ?></em>
                                </span>
                            </p>
                        </a>
                        <a href="#" class="list-group-item" disabled>
                            <p class="text-danger"><i class="fa fa-tag  fa-fw"></i><strong> No. Turnos este Mes</strong>
                                <span class="pull-right text-muted small"><em><?php echo $noTurnosMES; ?></em>
                                </span>
                            </p>
                        </a>
                    </div>
                    <div class="list-group">
                        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal" id="x">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Buscar Turnos x Fecha
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