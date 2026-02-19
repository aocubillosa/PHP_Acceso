<script type="text/javascript" src="<?php echo base_url("assets/js/validate/settings/schools.js"); ?>"></script>

<div id="page-wrapper">
    <br>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="list-group-item-heading">
                        <i class="fa fa-upload fa-fw"></i> CARGAR INTEGRANTES ESCUELA
                    </h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-futbol-o"></i> <?php echo $escuela; ?>
                    <div class="pull-right">
                        <div class="btn-group">
                            <a href="<?php echo base_url('settings/schools'); ?>" class="btn btn-success btn-xs">
                                Regresar <span class="fa fa-undo" aria-hidden="true"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <?php if (!empty($error)) {
                            echo '<div class="col-md-12 alert text-center alert-danger"><label>ERROR :</label> <span>' . $error . '</span></div>';
                        } 
                        if (!empty($success)) {
                            echo '<div class="col-md-12 alert text-center alert-success"><label>' . $success . '</label></div>';
                        } ?>
                    </div>
                    <form name="formCargue" id="formCargue" role="form" method="post" enctype="multipart/form-data" action="<?php echo site_url("/settings/do_upload/" . $idEscuela); ?>">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Ajuntar Archivo:</label>
                                <input type="file" name="userfile" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="button" id="btnSubir" name="btnSubir" class="btn btn-primary" >
                                    Cargar Archivo <span class="fa fa-upload" aria-hidden="true">
                                </button>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-12 alert alert-info text-center">
                                <label>Tener en cuenta :</label><br/>
                                Formato permitido : csv<br>
                                Tamaño máximo : 4096 KB<br>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    <?php if (!empty($success)): ?>
        setTimeout(function() {
            window.location.href = '<?php echo base_url('settings/members/' . $idEscuela . '/1'); ?>';
        }, 1000);
    <?php endif; ?>
</script>