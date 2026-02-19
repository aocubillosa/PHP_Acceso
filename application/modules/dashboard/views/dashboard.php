<style>
    .panel-green:hover {
        cursor: pointer;
        background-color: #d4edda;
        border-color: #c3e6cb;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    .panel-primary:hover {
        cursor: pointer;
        background-color: #cce7ff;
        border-color: #b3d9ff;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
</style>

<div id="page-wrapper">
    <div class="row">
        <br>
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
                        <i class="fa fa-dashboard fa-fw"></i>
						INICIO
					</h4>
				</div>
			</div>
		</div>
    </div>
    <br>
    <?php
    $retornoExito = $this->session->flashdata('retornoExito');
    if ($retornoExito) {
    ?>
    	<div class="row">
    		<div class="col-lg-12">	
    			<div class="alert alert-success ">
    				<span class="fa fa-check" aria-hidden="true"></span>
    				<strong><?php echo $this->session->userdata("firstname"); ?></strong> <?php echo $retornoExito ?>
    			</div>
    		</div>
    	</div>
    <?php
    }
    $retornoError = $this->session->flashdata('retornoError');
    if ($retornoError) {
    ?>
    	<div class="row">
    		<div class="col-lg-12">	
    			<div class="alert alert-danger ">
    				<span class="fa fa-exclamation-triangle" aria-hidden="true"></span>
    				<?php echo $retornoError ?>
    			</div>
    		</div>
    	</div>
    <?php
    }
    ?>
    <div class="row" style="display: flex; justify-content: center;">
        <div class="col-lg-2 col-md-4">
            <div class="panel panel-green" id="panel-funcionarios">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-user-secret fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $funcionarios; ?></div>
                            <div>FUNCIONARIOS</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4">
            <div class="panel panel-yellow" id="panel-visitantes">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-user fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $visitantes; ?></div>
                            <div>VISITANTES</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4">
            <div class="panel panel-primary" id="panel-integrantes">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-futbol-o fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $integrantes; ?></div>
                            <div>INTEGRANTES</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>

<script>
    $('#panel-funcionarios').click(function() {
        var url = base_url + "entrances/permissionsFuncionarios";
        $(location).attr("href", url);
    });
    $('#panel-visitantes').click(function() {
        var url = base_url + "entrances/permissionsVisitantes";
        $(location).attr("href", url);
    });
    $('#panel-integrantes').click(function() {
        var url = base_url + "entrances/permissionsIntegrantes";
        $(location).attr("href", url);
    });
</script>