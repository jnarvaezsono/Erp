<style>
    .invoice-info{
        font-size: 12px;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1 id="title">
            <i class="fa fa-edit"></i> Solictud Vacaciones N° <?= $id ?>
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
            
            <div class="row invoice-info">
                <div class="col-sm-3 invoice-col">
                    <address>
                        <strong>Inicio de vacaciones:</strong><br>
                        <?= $row->fecha_inicio ?><br>
                    </address>
                </div>
                <div class="col-sm-3 invoice-col">
                    <address>
                        <strong>Fin de vacaciones:</strong><br>
                        <?= $row->fecha_fin ?><br>
                    </address>
                </div>
                <div class="col-sm-3 invoice-col">
                    <address>
                        <strong>Total Días tomados:</strong><br>
                        <?= $row->total_dias ?><br>
                    </address>
                </div>
                <div class="col-sm-3 invoice-col">
                    <address>
                        <strong>Solicitado a:</strong><br>
                        <?php  if($row->solicitado_a == '70'){
                            echo 'Gerencia Administrativa<br>';
                        }else if($row->solicitado_a == '41,42'){
                            echo 'Gerencia Creativa<br>';
                        }else if($row->solicitado_a == '46'){
                            echo 'Gerencia Cuentas<br>';
                        }else if($row->solicitado_a == '63,62'){
                            echo 'Gerencia Medios<br>';
                        }
                        ?>
                    </address>
                </div>
                <div class="col-sm-12 invoice-col">
                    <address>
                        <strong>Observaciones:</strong><br>
                        <?= ucwords($row->observaciones) ?><br>
                    </address>
                </div>
                <div class="col-sm-12 invoice-col">
                    <div class="form-group">
                        <label><input type="checkbox" id="ok_jefe" class="flat-red-edit" <?= (!empty($row->ok_jefe)) ? 'checked' : '' ?>  disabled> Aprobación Jefe Inmediato </label>
                    </div>
                </div>
                <div class="col-sm-12 invoice-col">
                    <div class="form-group">
                        <label><input type="checkbox" id="ok_gerente" class="flat-red-edit" <?= (!empty($row->ok_gerente)) ? 'checked' : '' ?> disabled> Aprobación Gerente Administrativo </label>
                    </div>
                </div>
                <div class="col-sm-12 invoice-col">
                    <div class="form-group">
                        <label><input type="checkbox" id="ok_nomina" class="flat-red-edit" <?= (!empty($row->ok_nomina)) ? 'checked' : '' ?> disabled> Aprobación  Prof. Nomina </label>
                    </div>
                </div>
            </div>
            
   
            <div class="row no-print">
                <div class="col-xs-12">
                    
                    <?php if (isset($BtnAproveReqFormat)): ?>
                        <button type="button" class="btn btn-warning pull-right" id="btn-noaprov" style="margin-right: 5px;" onclick="Aprove(12,'NO APROBADO')"> <i class="fa fa-thumbs-down"></i> No Aprobar </button>
                        <button type="button" class="btn btn-success pull-right" id="btn-aprov" style="margin-right: 5px;" onclick="Aprove(21,'aprobación')"> <i class="fa fa-thumbs-up"></i> Aprobar </button>
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
        Lock('<?=$row->id_estado?>');
    });
    
    function Lock(estado) {
        if(estado == 8 || estado == 4){
            $('#btn-edit , #btn-noaprov , #btn-aprov').hide();
            <?php if($this->session->IdRol != 4 && $this->session->IdRol != 1): ?>
                $('#btn-anule ').hide();
            <?php endif; ?>
        }
    }
    
    function paintStatus(id_estado){
        if(id_estado == 1){
            $('#status').html('<small class="label label-info"><i class="fa fa-clock-o"></i> ACTIVO</small>');
        }else if(id_estado == '21'){//aprobado
            $('#status').html('<small class="label label-success"><i class="fa fa-clock-o"></i> APROVADO</small>');
        }else if(id_estado == '12'){//no parobado
            $('#status').html('<small class="label label-danger"><i class="fa fa-clock-o"></i> NO APROVADO</small>');
        }else if(id_estado == '4'){//anulado
            $('#status').html('<small class="label label-warning"><i class="fa fa-clock-o"></i> ANULADO</small>');
        }else if(id_estado == '8'){//anulado
            $('#status').html('<small class="label label-warning"><i class="fa fa-clock-o"></i> FINALIZADO</small>');
        }
        
    }
    
    function ChangeStatus(id_estado,desc){
        if(id_estado == 12 && !ValidateInput('motivoAprove')){
            return false;
        }
        
        if(id_estado == 12){
            var txt = 'No Aprobó la solicitud <br />Motivo : '+$('#motivoAprove').val();
        }else if(id_estado == 21){
            var txt = 'Aprobó la solicitud';
            if(<?=$this->session->IdRol?> == 4){
                id_estado = 8;
            }
        }else if(id_estado == 4){
            var txt = 'Anuló la solicitud';
        }
        
        $.post("<?= base_url() ?>Sgc/C_Sgc/ChangeStatus", {id_solicitud:<?= $id ?>,id_estado:id_estado,motivo:$('#motivoAprove').val(),tipo:<?= $tipo ?>}, function (data) {
            if(data.res == 'OK'){
                paintStatus(id_estado);
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
                txt = 'AAPROBADO';
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