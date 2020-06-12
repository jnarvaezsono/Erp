<style>
    .comment-text{font-size: 10px;}
    .back-to-top {
        cursor: pointer;
        position: fixed;
        bottom: 20px;
        right: 20px;
        display:none;
    }
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <div class="user-block">
                    <span class="username" style="margin-left: 15px;"><a href="#"><?= $infoOP->pvcl_nombre ?>.</a></span>
                    <span class="description" style="margin-left: 15px;">OP <?= strtoupper($infoOP->descripcion_op) ?> - <?= $infoOP->camp_nombre ?> - <?= $infoOP->pdcl_nombre ?> - <div class="box-title title-box">Tarea N&deg;<?= $id ?> - <?= " OP N&deg; " . $info->id_op ?><?= (!empty($info->presupuesto)) ? " - Presupuesto N&deg; " . $info->presupuesto : "" ?></div><div class="pull-right" id="div-status"></div><div class="pull-right" id="div-back" onclick="history.back()"><i  class="fa fa-fw fa-backward"></i> </div></span>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12" style="text-align:center">
                        <?= (!empty($BtnEdit)) ? '<button type="button" class="btn btn-info btn-opt btn-sm btn-edit-task " onclick="OpenV_Task()" style="display:none;"><i class="fa fa-edit"></i> Editar</button>' : "" ?>
                        <button type="button" class="btn btn-default btn-opt btn-sm attached " style="display:none;"><i class="fa fa-paperclip"></i> Adjunto</button>
                        <button type="button" class="btn btn-default btn-opt btn-sm " id="btn-comment" style="display:none;"><i class="fa fa-comments"></i> Comentar</button>
                        <?= (!empty($BtnCotizacion)) ? '<button type="button" class="btn btn-default btn-opt btn-sm attachedCot " style="display:none;"><i class="fa fa-paperclip"></i> Adjuntar Cotización</button>' : "" ?>
                        <?= (!empty($BtnNewPhoto) && isCreative($this->session->IdRol)) ? '<button type="button" id="NewTaskPhoto" class="btn btn-default btn-opt btn-sm " style="display:none;"><i class="fa fa-image"></i> Solicitar Boceto</button>' : "" ?>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm">Acción</button>
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <?= (!empty($BtnActiveTask)) ? '<li style="display:none" class=" btn-opt   active-task" onclick="ChangeStatus(1,\'Activada\')"><a href="#">Activar Tarea</a></li>' : "" ?>
                                <?= (!empty($BtnAprobeTask)) ? '<li style="display:none" class=" btn-opt   aprobe-task" onclick="ChangeStatus(21,\'Aprobada\')"><a href="#">Aprobar Tarea</a></li>' : "" ?>
                                <?= (!empty($BtnCloseTask)) ? '<li style="display:none" class="btn-opt  close-task"><a href="#">Cerrar Tarea</a></li>' : "" ?>
                                <?= (!empty($BtnActiveTask)) ? '<li style="display:none" class=" btn-opt   send-to-task" onclick="ChangeStatus(11,\'Enviada al cliente\')"><a href="#">Enviar al Cliente</a></li>' : "" ?>
                                <?= (!empty($BtnSolAprob)) ? '<li style="display:none" class=" btn-opt   sol-aprob" onclick="ChangeStatus(20,\'Por Aprobar\')"><a href="#">Solicitar Aprobación</a></li>' : "" ?>
                                <?= (!empty($BtnNewCot)) ? '<li style="display:none" class=" btn-opt   sol-new-cot" onclick="ChangeStatus(16,\'POR COTIZAR\')"><a href="#">Solicitar Cotización</a></li>' : "" ?>
                                <?= (!empty($BtnNewPpto)) ? '<li style="display:none" class=" btn-opt   generate-ppto" onclick="OpenPpto(' . $id . ')"><a href="#">Generar Ppto</a></li>' : "" ?>

                                <li class="divider"></li>
                                
                                <?= (!empty($BtnDeleteTask)) ? '<li style="display:none" class=" btn-opt  delete-task"><a style="color: red;" href="#">Anular Tarea</a></li>' : "" ?>
                                <?= (!empty($BtnCancelTask)) ? '<li style="display:none" class=" btn-opt   cancel-task"><a style="color: #ffa456;" href="#">Cancelar Tarea</a></li>' : "" ?>
                                <?= (!empty($BtnAjust)) ? '<li style="display:none" class=" btn-opt  btn-ajust" onclick="Ajust()"><a href="#">Pedir Ajuste</a></li>' : "" ?>
                                <?= (!empty($BtnStand)) ? '<li style="display:none" class=" btn-opt  btn-stand" onclick="ChangeStatus(18,\'Stand By\')"><a href="#">Stand By</a></li>' : "" ?>
                                <?= (!empty($BtnArte)) ? '<li style="display:none" class=" btn-opt  btn-arte" onclick="ChangeStatus(22,\'Arte Final\')"><a style="color: #00c0ef;" href="#">Arte Final</a></li>' : "" ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-12 anule-text" style="display:none">
                        <br />
                        <div class="alert alert-danger alert-dismissible" id="alert-anulate">
                            <h4><i class="icon fa fa-ban"></i> Motivo</h4>
                            <?=$info->motivo_anulacion?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Descripción De Tarea: </label>
                            <?= $info->descripcion ?>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <ul class="mailbox-attachments clearfix">
                            <?php foreach ($adjuntos as $v) : ?>
                                <li>
                                    <div class="mailbox-attachment-info">
                                        <a href="<?= base_url() ?>Adjuntos/OP/<?= $v->url ?>" class="mailbox-attachment-name" download="<?= $v->url ?>" target="_blank"><i class="fa fa-paperclip"></i> <?= substr($v->nombre, 0, 20) ?></a>
                                        <span class="mailbox-attachment-size">
                                            <?= $v->tipo ?>
                                            <?= $v->fecha ?>
                                            <a href="<?= base_url() ?>Adjuntos/OP/<?= $v->url ?>" download="<?= $v->url ?>" class="btn btn-primary btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                                        </span>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <br />
                    </div>
                    <div class="col-md-12">
                        <input type="hidden" id="token-key">
                        <form role="form" id="form-task" method="POST" enctype="multipart/form-data">
                            <hr />
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Modalidad: </label>
                                        <?php foreach ($modalidades as $v) : 
                                            if($info->modalidad_cobro == $v->descripcion):?>
                                                <?=$v->descripcion ?>
                                        <?php endif; endforeach; ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Area De Negocio: </label>
                                        <?php foreach ($unidades as $v) : 
                                            if($info->id_unidad == $v->id_unidad):?>
                                                <?=$v->descripcion ?>
                                        <?php endif; endforeach; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Responsable: </label>
                                        <?php 
                                        $array_responsable = explode(',', $info->id_responsable);
                                        foreach ($usuarios as $v) : 
                                            if(in_array($v->id_users, $array_responsable)):?>
                                                <?= $v->name.', ' ?>
                                        <?php endif; endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="fecha_entrega">Fecha De Entrega: </label>
                                        <?= $info->fecha_entrega ?>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="">Notificados: </label>
                                            <?php 
                                            $array_notificados = explode(',', $info->notificados);
                                            foreach ($notificados as $v) : 
                                                if(in_array($v->id_users, $array_notificados)):?>
                                                <?= $v->name.', ' ?>
                                            <?php endif; endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3" style="display:none">
                                    <div class="form-group">
                                        <label for="responsable">Área Responsable: </label>
                                        <?php foreach ($area_responsable as $v) : 
                                        if($info->area_responsable == $v->id_area):?>
                                                <?=$v->descripcion ?>
                                        <?php endif; endforeach; ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Categoría: </label>
                                        <?php foreach ($categorias as $v) :
                                            if($info->id_categoria == $v->id_categoria):?>
                                                <?=$v->descripcion ?>
                                        <?php endif; endforeach; ?>
                                    </div>
                                </div>
                                <div id="content-form">
                                    <?= $form ?>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12" id="all-cooment">
                        <?= $comment ?>
                    </div>
                    <!-- /.col -->
                </div>
            </div>
        </div>
        <a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Click to return on the top page" data-toggle="tooltip" data-placement="left"><span class="glyphicon glyphicon-chevron-up"></span></a>
    </section>
</div>
<?= $modal ?>
<?= $modalCot ?>
<div class="modal fade" id="modal-comment">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-group">
                    <textarea class="form-control " id="new-comment" rows="2" placeholder="Enter ..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn  btn-warning pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-modal-comment" class="btn  btn-primary pull-right" onclick="Send()" >Enviar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-anule">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="anule-title">Anular Tarea</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Motivo</label>
                    <textarea class="form-control" id="motivo" rows="3" placeholder="Enter ..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn  btn-warning pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn  btn-primary pull-right" id="btn-anule"  >Aceptar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-ppto">
    <div class="modal-dialog" style="width: 750px;">
        <div class="modal-content" >
            <div class="modal-header" style="background-color: #3c8dbc; color: #fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Generar Presupuesto</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tipo_ppto">Tipo Presupuesto</label>
                            <select class="form-control  input-ppto" id="tipo_ppto" name="tipo_ppto" onchange="LoadSelect('other_service',this.value)">
                                <option value="">. . .</option>
                                <?php foreach ($pptos as $v) : ?>
                                    <option value="<?= $v->id_categoria ?>" ><?= $v->descripcion ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Opción</label>
                            <select class="form-control  input-ppto" id="opcion" name="opcion" onchange="ShowinputNew(this.value)">
                                <option value="">. . .</option>
                                <option value="add" >ADICIONAR EXISTENTE</option>
                                <option value="new" >GENERAR NUEVO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" style="display:none" id="div-new">
                            <label for="add_ppto">Presupuesto</label>
                            <input type="text" class="form-control  input-ppto" id="add_ppto">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group other_service">
                            <label for="other_service">Tipo Servicio</label>
                            <select class="form-control  input-ppto" id="other_service" name="other_service">
                                <option value="">. . .</option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="all_task">Tarea</label>
                            <select class="form-control  select2" multiple id="all_task" name="all_task" style="width: 100%;">
                                <option value="">. . .</option>
                                <?php foreach ($op_task as $p) : ?>
                                    <option value="<?=$p->id_tarea?>" <?=($p->id_tarea == $id)?"selected":''?> ><?='('.$p->unidad.'-'.$p->id_tarea.')'.$p->descripcion?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn  btn-primary pull-right GeneratePpto"  >Generar</button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?= base_url() ?>dist/Upload/externa/blueimp-gallery.min.css">
<link rel="stylesheet" href="<?= base_url() ?>dist/Upload/css/jquery.fileupload.css">
<link rel="stylesheet" href="<?= base_url() ?>dist/Upload/css/jquery.fileupload-ui.css">
<script src="<?= base_url() ?>dist/Upload/js/vendor/jquery.ui.widget.js"></script>
<script src="<?= base_url() ?>dist/Upload/js/vendor/jquery.ui.widget.js"></script>
<script src="<?= base_url() ?>dist/Upload/externa/tmpl.min.js"></script>
<script src="<?= base_url() ?>dist/Upload/externa/load-image.all.min.js"></script>
<script src="<?= base_url() ?>dist/Upload/externa/canvas-to-blob.min.js"></script>
<script src="<?= base_url() ?>dist/Upload/externa/jquery.blueimp-gallery.min.js"></script>
<script src="<?= base_url() ?>dist/Upload/js/jquery.iframe-transport.js"></script>
<script src="<?= base_url() ?>dist/Upload/js/jquery.fileupload.js"></script>
<script src="<?= base_url() ?>dist/Upload/js/jquery.fileupload-process.js"></script>
<script src="<?= base_url() ?>dist/Upload/js/jquery.fileupload-image.js"></script>
<script src="<?= base_url() ?>dist/Upload/js/jquery.fileupload-validate.js"></script>
<script src="<?= base_url() ?>dist/Upload/js/jquery.fileupload-ui.js"></script>
<script src="<?= base_url() ?>dist/Upload/js/main_adjuntos_comentarios.js?<?php echo md5(time()) ?>"></script>
<script>

$(function () {
    
    CKEDITOR.replace( 'new-comment', {
        filebrowserUploadUrl: '<?=base_url()?>C_Service/Upload',
        filebrowserBrowseUrl: '<?=base_url()?>C_Service/ShowFiles',
        filebrowserWindowWidth: '1000',
        filebrowserWindowHeight: '600'
    });
    
    $('#token-key').val(Math.random());
    Lock(<?= $info->id_estado ?>);


    <?php if (empty($BtnUpdateTask)): ?>
        $("#form-task :input").attr("disabled", true);
    <?php endif; ?>

    <?php if (!empty($BtnChangeResponsable)): ?>
        $(".input-reasig").attr("disabled", false);
    <?php endif; ?>

    $(".attached").click(function () {
        cargar_adjuntos('<?= base_url() ?>', <?= $id ?>, 'COMMENT', Math.random())
        $("#table-adjuntos > tbody").html("");
        $("#modal-task").modal();
    });

    $(".attachedCot").click(function () {
        cargar_cotizacion('<?= base_url() ?>', <?= $id ?>, 'COMMENT', Math.random())
        $("#table-adjuntos-cot > tbody").html("");
        $("#modal-cot").modal();
    });

    $(".close-task").click(function () {
        CloseTask();
    });
    
    $('#modal-comment').on('shown.bs.modal', function (e) {
        CKEDITOR.instances['new-comment'].destroy();
        $("#new-comment").val('');
        CKEDITOR.replace('new-comment', {
            startupFocus : true, 
            allowedContent: true,
            filebrowserUploadUrl: '<?=base_url()?>C_Service/Upload',
            filebrowserBrowseUrl: '<?=base_url()?>C_Service/ShowFiles',
            filebrowserWindowWidth: '1000',
            filebrowserWindowHeight: '600'
        });
    });
    
    $("#btn-comment").click(function () {
        $('#btn-modal-comment').attr('onclick','Send()').html('<i class="fa fa-comments"></i> Comentar');
        $('#modal-comment').modal();
    });
    
    
    
    $("#NewTaskPhoto").click(function () {
        $('#btn-modal-comment').attr('onclick','IsDuplicate()').html('<i class="fa fa-image"></i> Solicitar Boceto');
        CKEDITOR.instances['new-comment'].setData("");
        $('#modal-comment').modal();
    });

    $(".delete-task").click(function () {
        $("#motivo").attr("disabled", false).val("");
        $("#modal-anule").modal("show");
        $("#anule-title").html('Anular Tarea');
        $("#btn-anule").attr('onclick','Anule(4)');
    });
    $(".cancel-task").click(function () {
        $("#motivo").attr("disabled", false).val("");
        $("#modal-anule").modal("show");
        $("#anule-title").html('Cancelar Tarea');
        $("#btn-anule").attr('onclick','Anule(14)');
    });

    $('.picker, .picker-task').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
    });

    $('.timepicker').timepicker({
        showInputs: false
    });

    $(".select-modal, .select-modal-form, .select2").select2();
    
    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
    });
    $('#back-to-top').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });
    
    $('.timeline-body').each(function(){
        if($(this).text().trim().length == 0){
            $(this).parent('.timeline-item').parent('.li-token').remove();
        }
    });
});

    function DuplicateService(servicio){
    
    }
    
    function OpenV_Task(){
        window.location = '<?= base_url() ?>OP/C_OP/EditTask/<?= $id ?>';
    }

    function ShowinputNew(valor) {
        if (valor == 'add') {
            $('#div-new').show();
        } else {
            $('#div-new').hide();
        }
    }

    function back() {
        window.location = '<?= base_url() ?>/OP/C_OP/Info/<?= $info->id_op ?>';
    }

    function Anule(status) {
        if ($("#motivo").val() != '') {
            ChangeStatus(status, 'Anulada');
            $("#anule-text").show();
            $("#alert-anulate").html('<h4><i class="icon fa fa-ban"></i> Motivo </h4>' + $("#motivo").val());
            $("#modal-anule").modal("hide");
        } else {
            alertify.error("DEBE PROPORCINAR UN MOTIVO");
        }
    }

    function ChangeStatus(estado, name) {
        $(".loader_ajax2").text("Enviado Notificación");
        $.post("<?= base_url() ?>OP/C_OP/ChangeStatus", {id_tarea:<?= $id ?>, id_estado: estado, estado: name, motivo: $("#motivo").val()}, function (data) {
            if (data.res == "OK") {
                Lock(estado);
                alertify.success("OK!");
            } else {
                swal({title: 'Error!', text: data.res, type: 'error'});
            }
        }, 'json');
    }

    function CloseTask() {
        if (validatefield('task-required')) {
             swal({
                title: 'Confirma el cierre de la tarea?',
                text: "Al cerrar la tarea, esta no podra ser modificada y se dara por finalizada",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3c8dbc',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!'
            }).then((result) => {
                if (result) {
                    $.post("<?= base_url() ?>OP/C_OP/ValidateTaskPhoto", {id_tarea:<?= $id ?>}, function (data) {
                        if(data.res > 0){
                            swal({
                                title: 'Atención!',
                                text: "Esta tarea debe ser cobrada?",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'SI COBRAR!',
                                cancelButtonText: 'NO COBRAR!',
                                reverseButtons: true
                            }).then((result) => {
                                if (result) {
                                    Close(1);
                                }
                            }, function (dismiss) {
                                if (dismiss === 'cancel') {
                                    Close(0);
                                }
                            }).catch(swal.noop)
                            
                        }else{
                            Close(1);
                        }
                    }, 'json').fail(function (error) {
                        swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                    });
                }
            }).catch(swal.noop)
        } else {
            alertify.error("DATOS INCOMPLETOS!");
        }
    }
    
    function Close(photoPay) {
        $(".loader_ajax2").text("Enviado Notificación");
        $.post("<?= base_url() ?>OP/C_OP/CloseTask", {id_tarea:<?= $id ?>,pay:photoPay}, function (data) {
            if (data.res == "OK") {
                Lock(13);
                swal({title: '', text: '', type: 'success'});
            } else {
                swal({title: 'Error!', text: data, type: 'error'});
            }
        }, 'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }

    function Lock(estado) {
        $(".btn-opt").hide();
        $(".form-control").attr("disabled", true);
        $(".generate-ppto").show();
        $("#add_ppto").attr("disabled", false);
        
        
        
        if(estado == 1){
            if('<?= $info->modalidad_cobro ?>' == 'COTIZAR'){
                $(".attachedCot").show();
            }
            $(".btn-edit-task, .attached, .reasig-task,  #btn-comment, #NewTaskPhoto").show();
            $(".delete-task, .cancel-task, .close-task, .send-to-task, .btn-ajust, .btn-stand, .sol-aprob, .btn-arte").show();
            $(".form-control").attr("disabled", false); // habilito form
            $("#div-status").html("| ACTIVA");
            
        } else if (estado == 4) {
            $(".anule-text").show();
            $(".generate-ppto").hide();
            $("#div-status").html("| ANULADA");
            
        }else if (estado == 11) {
            $(".btn-edit-task, .attached, .reasig-task,  #btn-comment, #NewTaskPhoto").show();
            $(".delete-task, .btn-ajust, .sol-new-cot, .cancel-task .btn-stand, .close-task, .btn-arte").show();
            $("#div-status").html("| ENVIADA AL CLIENTE");
            $(".form-control").attr("disabled", false);
        }else if (estado == 13) {
            $("#div-status").html("| CERRADA"); 
            
        }else if(estado == 14){
            $(".anule-text").show();
            $(".generate-ppto").hide();
            $("#div-status").html("| CANCELADA");
            
        }else if(estado == 15){
            if('<?= $info->modalidad_cobro ?>' == 'COTIZAR'){
                $(".attachedCot").show();
            }
            $(".btn-edit-task, .attached, #btn-comment, .reasig-task").show();
            $(".delete-task, .cancel-task").show();
            $(".form-control").attr("disabled", false); // habilito form
            $("#div-status").html("| SIN ASIGNAR");
            
        }else if(estado == 16){
            if('<?= $info->modalidad_cobro ?>' == 'COTIZAR'){
                $(".attachedCot").show();
            }
            $(".btn-edit-task, .attached, #btn-comment, .reasig-task").show();
            $(".delete-task, .cancel-task, .btn-stand").show();
            $(".form-control").attr("disabled", false); // habilito form
            $("#div-status").html("| POR COTIZAR");
            
        }else if(estado == 17){
            if('<?= $info->modalidad_cobro ?>' == 'COTIZAR'){
                $(".attachedCot").show();
            }
            $(".btn-edit-task, .attached, #btn-comment, .reasig-task").show();
            $(".btn-ajust, .aprobe-task, .btn-stand, .sol-new-cot, .delete-task, .cancel-task, .btn-arte ").show();
            $(".form-control").attr("disabled", false); // habilito form
            $("#div-status").html("| APROBAR COTIZACIÓN");
            
        }else if(estado == 18){
            if('<?= $info->modalidad_cobro ?>' == 'COTIZAR'){
                $(".attachedCot").show();
            }
            $(".btn-edit-task, .attached, #btn-comment, .reasig-task, #NewTaskPhoto").show();
            $(".cancel-task, .delete-task, .sol-new-cot, .btn-ajust, .aprobe-task,  .send-to-task, .btn-arte").show();
            $(".form-control").attr("disabled", false); // habilito form
            $("#div-status").html("| STAND BY");
            
        }else if(estado == 19){
            if('<?= $info->modalidad_cobro ?>' == 'COTIZAR'){
                $(".attachedCot").show();
            }
            $(".btn-edit-task, .attached, #btn-comment, .reasig-task, #NewTaskPhoto").show();
            $(" .sol-aprob, .delete-task, .cancel-task, .btn-ajust, .btn-stand, .sol-new-cot, .btn-arte").show();
            $(".form-control").attr("disabled", false); // habilito form
            $("#div-status").html("| POR AJUSTAR");
            
        }else if(estado == 20){
            if('<?= $info->modalidad_cobro ?>' == 'COTIZAR'){
                $(".attachedCot").show();
            }
            $(".btn-edit-task, .attached, #btn-comment, .reasig-task, #NewTaskPhoto").show();
            $(".aprobe-task, .cancel-task, .delete-task, .btn-stand, .btn-ajust, .btn-arte").show();
            $(".form-control").attr("disabled", false); // habilito form
            $("#div-status").html("| POR APROBAR");
            
        }else if(estado == 21){
            if('<?= $info->modalidad_cobro ?>' == 'COTIZAR'){
                $(".attachedCot").show();
            }
            $(".btn-edit-task, .attached, #btn-comment, .reasig-task, #NewTaskPhoto").show();
            $(".close-task, .send-to-task, .delete-task, .cancel-task, .btn-ajust, .btn-stand, .sol-new-cot, .btn-arte").show();
            $(".form-control").attr("disabled", false); // habilito form
            $("#div-status").html("| APROBADO");
            
        }else if(estado == 22){
            if('<?= $info->modalidad_cobro ?>' == 'COTIZAR'){
                $(".attachedCot").show();
            }
            $(".btn-edit-task, .attached, .reasig-task,  #btn-comment, #NewTaskPhoto").show();
            $(".delete-task, .cancel-task, .close-task, .send-to-task, .btn-ajust, .btn-stand, .sol-aprob").show();
            $(".form-control").attr("disabled", false); // habilito form
            $("#div-status").html("| ARTE FINAL");
            
        }
        
        $('#tipo_ppto, #opcion, #other_service, #all_task').attr("disabled", false);
    }
       
    function Ajust(){
        $('#btn-modal-comment').attr('onclick','AjustSend()');
        $('#modal-comment').modal();
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
    
    function AjustSend(){
        var texto = 'Ajustes : '+CKEDITOR.instances['new-comment'].getData();
        $(".loader_ajax2").text("Enviado Notificación");
        $.post("<?= base_url() ?>OP/C_OP/AjustSend", {id_tarea:<?= $id ?>, texto: texto}, function (data) {
            if (data.res == "OK") {
                $('#modal-comment').modal('hide');
                pasteComment(texto);
                Lock(19);
                CKEDITOR.instances['new-comment'].setData("");
            } else {
                swal({title: 'Error!', text: obj.res, type: 'error'});
            }
        }, 'json');
    }
    
    function IsDuplicate(){
        var comm = CKEDITOR.instances['new-comment'].getData();
        if (comm != "") {
            $.post("<?= base_url() ?>OP/C_OP/IsDuplicatePhoto", {id_tarea:<?= $id ?>}, function (data) {
                if(data.res == 'DUPLICADO'){
                    swal({
                        title: 'Atención!',
                        text: "Ya existe una tarea para fotografia, desea generar otra?",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Aceptar!',
                        reverseButtons: true
                    }).then((result) => {
                        if (result) {
                            AddTask();
                        }
                    }, function (dismiss) {
                        if (dismiss === 'cancel') {
                            
                        }
                    }).catch(swal.noop)
                }else{
                    AddTask();
                }
            }, 'json');
        }
    }
    
    function AddTask(){
        var comm = CKEDITOR.instances['new-comment'].getData();
        if (comm != "") {
            $(".loader_ajax2").text("Enviado Notificación");
            $.post("<?= base_url() ?>OP/C_OP/NewTaskPhoto", {id_tarea:<?= $id ?>, op: <?=$info->id_op?>, texto: comm}, function (data) {
                $('#modal-comment').modal('hide');
                if(data.res == 'OK'){
                    pasteComment('Solicitó material a fotografia <br />'+comm);
                    swal({title: '', text: "Se le asigno una tarea al personal de fotografía", type: 'success'});
                }else{
                    swal({title: 'Error!', text: 'Ocurrio un error '+data.res, type: 'error'});
                }
            }, 'json');
        }
    }
        
    function Send() {
        var comm = CKEDITOR.instances['new-comment'].getData();
        if (comm != "") {
            $(".loader_ajax2").text("Enviado Notificación");
            $.post("<?= base_url() ?>OP/C_OP/NewComment", {id_tarea:<?= $id ?>, texto: comm}, function (data) {
                if (data.res == "OK") {
                    $('#modal-comment').modal('hide');
                    var comment = '<li class="time-label">';
                    comment += '<span class="bg-red">'+ShowDateJS()+'</span>';
                    comment += '</li>';
                    comment += '<li>';
                    comment += '<i class="fa fa-comments bg-blue"></i>';
                    comment += '<div class="timeline-item">';
                    comment += '<span class="time"><i class="fa fa-clock-o"></i> Ahora </span>';

                    comment += '<h3 class="timeline-header"><a href="#" class="img-header"><?=$this->session->NameUser?>...<img class="img-circle img-sm" src="<?= base_url() ?>/dist/img/<?=$this->session->Avatar?>" alt="User Image"></a></h3>';

                    comment += '<div class="timeline-body">';
                    comment += comm;
                    comment += '</div>';
                    comment += '</div>';

                    comment += '</li>';

                    $(".timeline").prepend(comment);

                    CKEDITOR.instances['new-comment'].setData("");
                } else {
                    swal({title: 'Error!', text: obj.res, type: 'error'});
                }
            }, 'json');
        }
    }

    function UpdateTask(opcion,op) {

            if (validatefield('task-required')) {
                $(".overlay_ajax").show();

                var notificados = "";
                $.each($("#notificados").val(), function (e, i) {
                    if (notificados != "") {
                        notificados += ",";
                    }
                    notificados += i;
                });
                
                var servicios = '';
                $.each($('#id_tarifa_servicio').val(), function (e, i) {
                    if (servicios != "") {
                        servicios += ",";
                    }
                    servicios += i;
                });

                var responsables = "";
                $.each($("#t_responsable").val(), function (e, i) {
                    if (responsables != "") {
                        responsables += ",";
                    }
                    responsables += i;
                });

                var formData = new FormData($('#form-task')[0]);

                formData.append("id_tarea", <?= $id ?>);//0
                formData.append("notificados", notificados);//1
                formData.append("id_responsable", responsables);//2
                
                formData.append("id_tarifa_servicio", servicios);
                if (!opcion) {
                    formData.append("id_categoria", $("#id_categoria").val());
                }
                formData.append("id_op", op);
                $.ajax({
                    url: "<?= base_url() ?>OP/C_OP/UpdateTask",
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        var obj = jQuery.parseJSON(data);
                        if (obj.res == "OK") {
                            alertify.success("OK!");
                            if('<?= $info->modalidad_cobro ?>' != 'COTIZAR'){
                                $(".attachedCot").hide();
                            }else{
                                $(".attachedCot").show();
                            }
                        } else {
                            swal({title: 'Error!', text: obj.res, type: 'error'});
                        }
                    },
                    global: true,
                    cache: false,
                    contentType: false,
                    processData: false
                }).fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            } else {
                alertify.error("DATOS INCOMPLETOS!");
            }
        }

    function LoadSelect(id,valor){
        var option = '<option value="">. . .</option>';

        if(id == 't_responsable'){
            valor = $('#id_unidad option:selected ').attr('area');
            $('#area_responsable').val(valor).trigger('change');
        }

        if (valor != "") {
            $.post("<?= base_url() ?>OP/C_OP/LoadSelect", {select: id, valor: valor}, function (data) {

                switch (id) {
                    case 't_programa':
                        $.each(data.datos, function (e, i) {
                            option += '<option value="' + i.progr_id + '">' + i.progr_nombre + '</option>';
                        });
                        break;
                    case 't_responsable':
                        $.each(data.datos, function (e, i) {
                            option += '<option value="' + i.id_users + '">' + i.name + '</option>';
                        });
                        break;
                    case 'other_service':
                        $.each(data.datos, function (e, i) {
                            option += '<option value="' + i.id_tipo_servicio + '">' + i.nombre + '</option>';
                        });
                        break;

                    default:

                        break;
                }

                $("#" + id).html(option).trigger('change');

            }, 'json');
        } else {
            $("#" + id).html(option).trigger('change');
        }
    }

    function LoadForm(categoria) {
        var form = $("#id_categoria option:selected ").attr('form');
        if (categoria != '') {
            $.post("<?= base_url() ?>OP/C_OP/CargarFormulario", {form: form, id_categoria: categoria, option: "update", id_tarea:<?= $id ?>}, function (data) {
                $("#content-form").html(data.form);
                $(".select-modal-form").select2();
                $('.picker-task').datepicker({
                    autoclose: true,
                    format: 'yyyy-mm-dd',
                });
                $('.timepicker').timepicker({
                    showInputs: false
                });
            }, 'json');
        } else {
            $("#content-form").html('');
        }
    }

    function OpenPpto(id_tarea) {
        $('.input-ppto').val('');
        $('#modal-ppto').modal('show');
        $('.GeneratePpto').attr('onclick', 'GeneratePpto(' + id_tarea + ')');  
    }

    function GeneratePpto(id_tarea) {
        if ($('#tipo_ppto').val() == 'add' && $('#add_ppto').val() == '') {
            alertify.error('DIGITE UN PRESUPUESTO');
        }else if ($('#other_service').val() == '') {
            alertify.error('SELECCIONE UN TIPO DE SERVICIO');
        }else if ($('#opcion').val() == '') {
            alertify.error('SELECCIONE UNA OPCIÓN');
        } else if ($('#tipo_ppto').val() != '') {
            
            var tasks = "";
            $.each($("#all_task").val(), function (e, i) {
                if (tasks != "") {
                    tasks += ",";
                }
                tasks += i;
            });
            
            if(tasks == ""){
                alertify.error('Debe seleccionar las tareas');
                return false;
            }
            
            swal({
                title: 'Confirma la generacion de presupuesto para esta tarea?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3c8dbc',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!'
            }).then((result) => {
                if (result) {
                    $(".loader_ajax2").text("Enviado Notificación");
                    $.post("<?= base_url() ?>OP/C_OP/GeneratePpto", {id_tarea: id_tarea, type: $('#tipo_ppto').val(),opcion:$('#opcion').val(), ppto: $('#add_ppto').val(), t_servicio: $('#other_service').val(), id_categoria: $('#id_categoria').val(),tasks:tasks}, function (data) {
                        if (data.res == "OK") {
                            swal({title: '', text: '', type: 'success'});
                            $(".title-box").html("Tarea N&deg; <?= $id ?> - OP N&deg; <?= $info->id_op ?> - Presupuesto N&deg; " + data.ppto);

                            $('#modal-ppto').modal('hide');
                        }else if(data.res == "ERROR MEDIOS"){
                            swal({title: 'Error!', text: 'Los presupuestos digitados no existen o no son validos, por favor revisar que el numero de presupuesto corresponda al tipo seleccionado', type: 'error'});
                        } else {
                            swal({title: 'Error!', text: data.res, type: 'error'});
                        }
                    }, 'json').fail(function (error) {
                        swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                    });
                }
            }).catch(swal.noop)

        } else {
            alertify.error('SELECCIONE UN TIPO');
        }
    }
    
    function ShowNewPieza(valor){
        if(valor == 'new'){
            $('#content-new-pieza').show();
            $('#tarifa_new').addClass('task-required');
        }else{
            $('#content-new-pieza').hide();
            $('#tarifa_new').removeClass('task-required');
        }
    }
</script>