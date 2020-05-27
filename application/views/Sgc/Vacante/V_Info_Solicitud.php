<style>
    .invoice-info{
        font-size: 12px;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1 id="title">
            <i class="fa fa-edit"></i> Solictud Vacante N° <?= $id ?>
            <small id="status"></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Gestion Calidad</a></li>
            <li><a href="<?= base_url() ?>GetTableFormat/<?= $tipo ?>">Listar</a></li>
            <li class="active">Editar</li>
        </ol>
    </section>
    <section class="content">
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                        <i class="fa fa-user"></i> <?= $row->usuario ?>.
                        <small class="pull-right">Fecha Creación: <?= $row->fecha ?></small>
                    </h2>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <h4 >ESPECIFICACIONES DE LA VACANTE</h4> 
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    <address>
                        <strong>Nombre de la vacante:</strong><br>
                        <?= ucwords($row->nombre_vacante) ?><br>
                    </address>
                </div>
                <?php if($row->id_usuario == $this->session->IdUser || in_array($this->session->IdRol, array(4,14,1))) :?>
                    <div class="col-sm-4 invoice-col">
                        <address>
                            <strong>Ingreso mensual:</strong><br>
                            <?= number_format($row->ingresos, 0, ',', '.') ?><br>
                        </address>
                    </div>
                <?php endif; ?>
                <div class="col-sm-4 invoice-col">
                    <address>
                        <strong>Fecha prevista de ingreso:</strong><br>
                        <?= $row->fecha_ingreso ?><br>
                    </address>
                </div>
                <div class="col-sm-4 invoice-col">
                    <address>
                        <strong>Motivo de la vacante:</strong><br>
                        <?= ($row->motivo_vacante == 'OTRO')?$row->ingreso_otro:ucwords($row->motivo_vacante) ?><br>
                    </address>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label style="display: block;">Delegado Olimpica</label>
                        <input type="checkbox"  class="flat-red-edit" <?= ($row->delegado == 1) ? 'checked' : '' ?> id="delegado"  >
                    </div>
                </div>
                <div class="col-sm-12 invoice-col">
                    <address>
                        <strong>Funciones y responsabilidades:</strong><br>
                        <?= ucwords($row->funciones) ?><br>
                    </address>
                </div>
            </div>
            <?php if($row->id_usuario == $this->session->IdUser || in_array($this->session->IdRol, array(4,14,1))) :?>
            <h4 >REQUISITOS DEL ASPIRANTE </h4>
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    <address>
                        <strong>Formación academica:</strong><br>
                        <?= ucwords($row->formacion) ?><br>
                    </address>
                </div>
                <div class="col-sm-4 invoice-col">
                    <address>
                        <strong>Experiencia minima:</strong><br>
                        <?= ucwords($row->experiencia) ?> AÑOS<br>
                    </address>
                </div>
                <div class="col-sm-12 invoice-col">
                    <address>
                        <strong>Conocimientos especificos:</strong><br>
                        <?= ucwords($row->conocimientos) ?><br>
                    </address>
                </div>
                <div class="col-sm-12 invoice-col">
                    <address>
                        <strong>Manejo de herramientas:</strong><br>
                        <?= ucwords($row->herramientas) ?><br>
                    </address>
                </div>
            </div>
            <?php endif; ?>
            <?php if($row->id_usuario == $this->session->IdUser || in_array($this->session->IdRol, array(15,14,1))) :?>
            <h4 > ACCESO A LOS SISTEMAS</h4> 
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label><input type="checkbox" id="pc" class="flat-red-edit" <?= ($row->pc == 1) ? 'checked' : '' ?> > Equipo de computo </label>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label><input type="checkbox" id="email" class="flat-red-edit" <?= ($row->email == 1) ? 'checked' : '' ?> > Correo electronico </label>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label><input type="checkbox" id="puesto_trabajo" class="flat-red-edit" <?= ($row->puesto_trabajo == 1) ? 'checked' : '' ?>> Puesto Trabajo </label>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label><input type="checkbox" id="carpetas_red" class="flat-red-edit" <?= ($row->carpetas_red == 1) ? 'checked' : '' ?> > Carpetas compartidas</label>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label><input type="checkbox" id="erp" class="flat-red-edit" <?= ($row->erp == 1) ? 'checked' : '' ?> > Sistema ERP</label>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label><input type="checkbox" id="sap" class="flat-red-edit" <?= ($row->sap == 1) ? 'checked' : '' ?> > Sap </label>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label><input type="checkbox" id="adobe" class="flat-red-edit" <?= ($row->adobe == 1) ? 'checked' : '' ?> > Adobe </label>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label> <input type="checkbox" id="vpn" class="flat-red-edit" <?= ($row->vpn == 1) ? 'checked' : '' ?> > Vpn </label>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label><input type="checkbox" id="ftp" class="flat-red-edit" <?= ($row->ftp == 1) ? 'checked' : '' ?> > Ftp </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-sm-3">
                    <div class="form-group">
                        <label >
                            <input type="radio" name="r3" class="flat-rad-edit" <?= ($row->tipo_pc == 'Desktop Mac') ? 'checked' : '' ?> value="Desktop Mac" >
                            Desktop Mac
                        </label>
                    </div>
                </div>
                <div class="col-md-2 col-sm-3">
                    <div class="form-group">
                        <label >
                            <input type="radio" name="r3" class="flat-rad-edit" <?= ($row->tipo_pc == 'Laptop Mac') ? 'checked' : '' ?> value="Laptop Mac" >
                            Laptop Mac
                        </label>
                    </div>
                </div>
                <div class="col-md-2 col-sm-3">
                    <div class="form-group">
                        <label >
                            <input type="radio" name="r3" class="flat-rad-edit" <?= ($row->tipo_pc == 'Desktop Win') ? 'checked' : '' ?> value="Desktop Win" >
                            Desktop Win
                        </label>
                    </div>
                </div>
                <div class="col-md-2 col-sm-3">
                    <div class="form-group">
                        <label >
                            <input type="radio" name="r3" class="flat-rad-edit" <?= ($row->tipo_pc == 'Laptop Win') ? 'checked' : '' ?> value="Laptop Win" >
                            Laptop Win
                        </label>
                    </div>
                </div>
                <div class="col-sm-12 invoice-col">
                    <address>
                        <strong>En caso de ser un nuevo ingreso especifique los modulos del sistema ERP y/o SAP a los que tendra acceso:</strong><br>
                        <?= ucwords($row->modulos) ?><br>
                    </address>
                </div>
                <div class="col-sm-12 invoice-col">
                    <address>
                        <strong>Observaciones:</strong><br>
                        <?= ucwords($row->observaciones) ?><br>
                    </address>
                </div>
            </div>
            <?php endif; ?>
            <?php if (!empty($row->observacion)): ?>
                <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                    <?= ucwords($row->observacion) ?>.
                </div>
            <?php endif; ?>
   
            <div class="row no-print">
                <div class="col-xs-12">
                    
                    <?php if (isset($BtnAproveReqFormat)): ?>
                        <button type="button" class="btn btn-warning pull-right" id="btn-noaprov" style="margin-right: 5px;" onclick="Aprove(12,'NO APROBADO')"> <i class="fa fa-thumbs-down"></i> No Aprobar </button>
                        <button type="button" class="btn btn-success pull-right" id="btn-aprov" style="margin-right: 5px;" onclick="Aprove(21,'aprobación')"> <i class="fa fa-thumbs-up"></i> Aprobar </button>
                    <?php endif; ?>
                    <?php if (isset($BtnAproveSist)): ?>
                        <button type="button" class="btn btn-success pull-right" id="btn-aprov-sist" style="margin-right: 5px;" onclick="aproveSystem()"><i class="fa fa-check-circle"></i> Confirmar Acceso/Equipo</button>
                    <?php endif; ?>
                    <?php if (isset($BtnEditReqFormat) || ($row->id_usuario == $this->session->IdUser)): ?>
                        <button type="button" class="btn btn-primary pull-right" id="btn-edit" style="margin-right: 5px;" onclick="Edit()"><i class="fa fa-edit"></i> Editar</button>
                    <?php endif; ?>
                    <?php if (isset($BtnAnuleReqFormat) || ($row->id_usuario == $this->session->IdUser)): ?>
                        <button type="button" class="btn " id="btn-anule" onclick="Aprove(4,'anulación')"><i class="fa fa-trash"></i> Anular</button>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    
    <div class="row">
        <div class="col-md-12" id="all-cooment">
            <?= $comment ?>
        </div>
    </div>
    </section>
</div>
<div class="modal fade" id="modal-aprove">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="anule-title">No Aprobar</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Motivo</label>
                    <textarea class="form-control" id="motivoAprove" rows="3" placeholder="Enter ..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn  pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn  btn-primary pull-right" onclick="ChangeStatus(12,'No Aprobada')" >Aceptar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('input[type="checkbox"].flat-red-edit, input[type="radio"].flat-rad-edit').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });
        paintStatus(<?=$row->id_estado?>);
       
    });
    
    
    function paintStatus(id_estado){
        if(id_estado == 1){
            $('#status').html('<small class="label label-info"><i class="fa fa-clock-o"></i> ACTIVO</small>');
        }else if(id_estado == '21'){//aprobado
            $('#status').html('<small class="label label-success"><i class="fa fa-clock-o"></i> APROVADO</small>');
        }else if(id_estado == '12'){//no parobado
            $('#status').html('<small class="label label-danger"><i class="fa fa-clock-o"></i> NO APROVADO</small>');
        }else if(id_estado == '4'){//anulado
            $('#status').html('<small class="label label-warning"><i class="fa fa-clock-o"></i> ANULADO</small>');
        }
        
    }
    
    function Lock(estado) {
        $('#btn-edit , #btn-noaprov , #btn-aprov , #btn-anule ').hide();
        if(estado == '1'){
            $('#btn-edit , #btn-noaprov , #btn-aprov , #btn-anule ').show();
        }else if(estado == '21'){//aprobado
            $('#btn-anule ').show();
        }else if(estado == '12'){//no parobado
            $('#btn-edit , #btn-aprov , #btn-anule ').show();
        }else if(estado == '4'){//anulado
            
        }
    }
    
    function ChangeStatus(id_estado,desc){
        if(id_estado == 12 && !ValidateInput('motivoAprove')){
            return false;
        }
        
        if(id_estado == 12){
            var txt = 'La solicitud paso a estado No Aprobado <br />Motivo : '+$('#motivoAprove').val();
        }else if(id_estado == 21){
            var txt = 'La solicitud paso a estado Aprobado';
        }else if(id_estado == 4){
            var txt = 'La solicitud paso a estado Anulado';
        }
        
        $.post("<?= base_url() ?>Sgc/C_Sgc/ChangeStatus", {id_solicitud:<?= $id ?>,id_estado:id_estado,motivo:$('#motivoAprove').val(),tipo:<?= $tipo ?>}, function (data) {
            if(data.res == 'OK'){
                paintStatus(id_estado);
                //Lock(id_estado);
                pasteComment(txt);
                swal({title: 'OK!', text: '', type: 'success'});
                $("#modal-aprove").modal("hide");
            }else{
                swal({title: 'Error!', text: data.res, type: 'error'});
            }
        },'json');
    }
    
    function Aprove(id_estado,desc){
        if(id_estado == 12){
            $("#modal-aprove").modal("show");
        }else{
            
            if(id_estado == 4){
                txt = 'ANULADO';
            }else if(id_estado == 21){
                txt = 'APROBADO';
            }
            
            swal({
                title: 'Confirmar '+desc+' dela solicitud?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3c8dbc',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!'
            }).then((result) => {
                if (result) {
                    ChangeStatus(id_estado,txt);
                }
            }).catch(swal.noop)
        }
    }
    
    function aproveSystem(){
        swal({
            title: 'Confirmar Accesos y equipos para la vacante?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3c8dbc',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar!'
        }).then((result) => {
            if (result) {
                $.post("<?= base_url() ?>Sgc/C_Sgc/aproveOther", {id_solicitud:<?= $id ?>,tipo:<?= $tipo ?>}, function (data) {
                    swal({title: 'OK!', text: '', type: 'success'});
                    pasteComment('Confirmó los accesos y equipos solicitados para esta vacante.');
                },'json');
            }
        }).catch(swal.noop)
    }
    
    function Edit() {
        location.href = "<?= base_url() ?>Sgc/FormEdit/<?= $id ?>/<?= $tipo ?>";
    }
    
    function pasteComment(texto){
        var comment = '<li class="time-label">';
        comment += '<span class="bg-red">'+ShowDateJS()+'</span>';
        comment += '</li>';
        comment += '<li>';
        comment += '<i class="fa fa-comments bg-blue"></i>';
        comment += '<div class="timeline-item">';
        comment += '<span class="time"><i class="fa fa-clock-o"></i> Ahora </span>';

        comment += '<h3 class="timeline-header"><a href="#" class="img-header"><?=$this->session->NameUser?>...<img class="img-circle img-sm" src="<?= base_url() ?>/dist/img/<?=$this->session->Avatar?>" alt="User Image"></a></h3>';

        comment += '<div class="timeline-body">';
        comment += texto;
        comment += '</div>';
        comment += '</div>';

        comment += '</li>';

        $(".timeline").prepend(comment);
    }
</script>