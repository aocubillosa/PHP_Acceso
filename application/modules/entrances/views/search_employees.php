<script type="text/javascript" src="<?php echo base_url("assets/js/validate/entrances/search_employees.js"); ?>"></script>

<div id="page-wrapper">
	<br>
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
						<i class="fa fa-search"></i> BUSCAR DOCUMENTO FUNCIONARIO
					</h4>
				</div>
				<br>
				<div class="panel-body">
					<form name="form" id="form" role="form" method="post" >
						<div class="row">
							<div class="col-md-4"></div>
							<div class="col-md-4 text-center">
								<label class="control-label" for="documento">Número de Documento: *</label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4"></div>
							<div class="col-md-4">
								<div>
									<input type="text" id="documento" name="documento" class="form-control" placeholder="Número de Documento" required >
								</div>
							</div>
						</div>
						<br><br>
						<div class="row">
							<div class="col-md-5"></div>
							<div class="col-md-2 text-center">
								<button type="button" id="btnSubmit" name="btnSubmit" class="btn btn-primary btn-md" >
									Buscar <span class="fa fa-search" aria-hidden="true">
								</button>
							</div>
						</div>
					</form>
				</div>
				<br>
			</div>
		</div>
	</div>
</div>