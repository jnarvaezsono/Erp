<style>
    .table-bordered>thead>tr>th {
        text-align: center !important;
    }
    .label{
        white-space: inherit !important;
    }
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Recibidos</h3>

            </div>
            <div class="box-body">
                <div class="row"> 
                    <div class="col-md-12" id="content-table">
                        <?= $table ?>
                    </div>
                </div>
            </div>
            <div class="box-footer">

            </div>
        </div>
    </section>
</div>
<div id="menu_form"  class="modal fade" tabindex="-1" role="dialog"   >
    <div class="modal-dialog modal-lg">
        <div class="modal-content box">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Datos</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form role="form" id="form" method="POST" enctype="multipart/form-data">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date_received">Fecha Recibido</label>
                                    <input type="text" name="date_received" class="form-control required picker" id="date_received" value="<?=date('Y-m-d')?>"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group register">
                                    <label for="type">Tipo</label>
                                    <select name="type" class="form-control required" id="type">
                                        <option value="">. . .</option>
                                        <option value="CARTA">CARTA</option>
                                        <option value="CONTRATO">CONTRATO</option>
                                        <option value="CUADERNILLO">CUADERNILLO</option>
                                        <option value="DEVOLUCIÓN">DEVOLUCIÓN</option>
                                        <option value="INFORME">INFORME</option>
                                        <option value="LIBRO">LIBRO</option>
                                        <option value="POLIZA">POLIZA</option>
                                        <option value="OTRO">OTRO</option>
                                    </select>
                                </div>
                            </div> 
                            <div class="col-md-4">
                                 <div class="form-group register">
                                    <label for="company">Empresa</label>
                                    <input type="text" name="company" class="form-control required" id="company"   />
                                </div>
                            </div>
                            <div class="col-md-4">
                                 <div class="form-group register">
                                    <label for="sender">Remitente</label>
                                    <input type="text" name="sender" class="form-control required" id="sender"   />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group register">
                                    <label for="addressee">Destinatario</label>
                                    <select name="addressee" class="form-control required" id="addressee">
                                        <option value="">. . .</option>
                                        <?php foreach($users as $u): ?>
                                            <option value="<?=$u->id_users?>"><?=$u->name?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div> 
                            <div class="col-md-12">
                                 <div class="form-group register">
                                    <label for="description_register">Decripcion</label>
                                    <textarea type="text" name="description_register" class="form-control " id="description_register"   ></textarea>
                                </div>
                            </div>
                        </form>
                        <div class="col-md-12 obs" style="display:none">
                            <div class="form-group register">
                               <label for="observacion">Observación</label>
                               <div class="input-group">
                                   <input class="form-control" placeholder="Obs..." id="obs">

                                   <div class="input-group-btn">
                                       <button type="button" class="btn btn-primary btn-obs" ><i class="fa fa-plus"></i></button>
                                   </div>
                               </div>
                           </div>
                       </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">CANCELAR</button>
                <button type="button" class="btn btn-primary create" onclick="CreateRegister()">CREAR</button>
                <button type="button" class="btn btn-primary update" >ACTUALIZAR</button>
            </div>
        </div>
    </div>
</div>
<div id="mod-resend"  class="modal fade" tabindex="-1" role="dialog"   >
    <div class="modal-dialog modal-lg" style="width:320px;">
        <div class="modal-content box">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Reenviar</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group register">
                            <label for="resend_format">Formato</label>
                            <select name="resend_format" class="form-control" id="resend_format">
                                <option value="ORIGINAL">ORIGINAL</option>
                                <option value="COPIA">COPIA</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group register">
                            <label for="resend_addressee">Destinatario</label>
                            <select name="resend_addressee" class="form-control" id="resend_addressee">
                                <option value="">. . .</option>
                                <?php foreach($users as $u): ?>
                                    <option value="<?=$u->id_users?>"><?=$u->name?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn-resend">Enviar</button>
            </div>
        </div>
    </div>
</div>
<script>
    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    $(function () {
        CreateTable();
        <?php if(!$inbox):  ?>
            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Create()" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla" href="#"><span><i class="fa fa-file"></i> Crear</span></a></label>');
        <?php else:  ?>
            
        <?php endif;  ?>
            
        $('.picker').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
        });
        $('.picker').datepicker('setDate',today);
        
    });
    
    
    function Resend(id,format){
        if(format == 1){
            $('#resend_format').val('ORIGINAL');
            $("#resend_format option:selected").attr('disabled','disabled').siblings().removeAttr('disabled');
            $('#resend_format').val('COPIA');
        }
        $('#btn-resend').attr('onclick','CreateResend('+id+')');
        $("#mod-resend").modal("show");
    }
    
    function CreateResend(id){
        if($('#resend_addressee').val() != ''){
            $.post('<?=base_url()?>Reception/C_Received/CreateResend',{id:id,resend_format:$('#resend_format').val(),resend_addressee:$('#resend_addressee').val(),resend_name:$('#resend_addressee option:selected').text()},function(data){
                if(data.res == 'OK'){
                    swal('Operacion Exitosa!', 'El registro enviado.', 'success').then((result) => {});
                    $("#mod-resend").modal("hide");
                    if($('#resend_format').val() == 'ORIGINAL'){
                        $("#btn-resend-"+id).hide();
                        $('#status'+id).html('<span style="width:100%" class="label label-5 label-primary">ACEPTADO Y REENVIADO A '+$('#resend_addressee option:selected').text()+'</span>');
                    }else{
                        $('#status'+id).html('<span style="width:100%" class="label label-5 label-primary">ACEPTADO Y REENVIADO A '+$('#resend_addressee option:selected').text()+'</span>');
                    }
                }else{
                    swal({title: 'Error!', text: data.res, type: 'error'});
                }
            },'json');
        }else{
            alertify.error('DEBE SELECCIONAR UN DESTINO');
        }
    }
    
    function Update(id,status) {
        $("#form")[0].reset();
        $("#date_received").val($("#date_received" + id).text());
        $("#sender").val($("#sender" + id).text());
        $("#addressee").val($("#addressee" + id).attr('num'));
        $("#company").val($("#company" + id).text());
        $("#description_register").val($("#id" + id).attr('desc'));
        $("#type").val($("#type" + id).text());
        $("#obs").val($("#id" + id).attr('obs'));
        $('.update').removeAttr('disabled');
        $('.required').removeAttr('disabled');
        $('#description_register').removeAttr('disabled');
        
        <?php if(!$inbox):  ?>
            if(status == 23){
                $('.update').attr('disabled','disabled');
                $('.required').attr('disabled','disabled');
                $('#description_register').attr('disabled','disabled');
            }
        <?php else:  ?>
            $('.update').attr('disabled','disabled');
            $('.required').attr('disabled','disabled');
            $('#description_register').attr('disabled','disabled');
        <?php endif;  ?>
        
        $('.obs').show();
            
        $(".update").show();
        $(".create").hide();
        $("#menu_form").modal("show");
        $(".update").attr("onclick", "UpdateReceived(" + id + ")");
        $(".btn-obs").attr("onclick", "newobs(" + id + ")");
    }

    function newobs(id) {
        if($('#obs').val() != ''){
            $.post("<?= base_url() ?>Reception/C_Received/NewObs", {id: id, obs:$('#obs').val()}, function (data) {
                if (data.res == "OK") {
                    $("#id" + id).attr('obs',$("#obs").val());
                    alertify.success('OK');
                } else {
                    alertify.success('ERROR :'+data.res);
                }
            }, 'json').fail(function (error) {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            });
        }
    }

    function Create() {
        $("#form")[0].reset();
        $(".update").hide();
        $(".create").show();
        $('.required').removeAttr('disabled');
        $('#description_register').removeAttr('disabled');
        $("#menu_form").modal("show");
    }

    function UpdateReceived(id) {
        var error = false;
        $(".required").each(function () {
            if (!ValidateInput($(this).attr("id"))) {
                error = true;
            }
        });
        if (!error) {
            
            var formData = new FormData($('#form')[0]);
            formData.append("id", id);
            $.ajax({
                url: "<?= base_url() ?>Reception/C_Received/UpdateReceived",
                type: 'POST',
                data: formData,
                async: false,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        $("#date_received"+ id).text($("#date_received").val());
                        $("#sender"+ id).text($("#sender").val());
                        $("#addressee"+ id).text($("#addressee option:selected").text());
                        $("#addressee"+ id).attr('num',$("#addressee").val());
                        $("#company"+ id).text($("#company").val());
                        
                        $("#id" + id).attr('desc',$("#description_register").val())
                        $("#type" + id).text($("#type").val());
                        $("#menu_form").modal("hide");
                        swal({
                            title: 'Operacion Exitosa!',
                            text: "El registro ha sido actualizado.",
                            type: 'success'
                        }).then((result) => {
                            
                        });
                        $('.label-'+id).removeClass('label-default').addClass('label-success').html('CREADO');
                    } else {
                        swal({title: 'Error!', text: obj.res, type: 'error'});
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            }).fail(function (error) {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            });
        }
    }
    function printTicket(id,consecutive,fecha){
        window.open('<?= base_url() ?>Reception/C_Received/PrintLabel/'+id+'/'+consecutive+'/'+fecha, '_blank');
    }
    

    function CreateRegister() {
        var error = false;
        $(".required").each(function () {
            if (!ValidateInput($(this).attr("id"))) {
                error = true;
            }
        });
        if (!error) {
            
            var formData = new FormData($('#form')[0]);
            $.ajax({
                url: "<?= base_url() ?>Reception/C_Received/CreateRegister",
                type: 'POST',
                data: formData,
                async: false,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        swal({
                            title: 'Operacion Exitosa!',
                            text: "El registro ha sido creado.",
                            type: 'success'
                        }).then((result) => {
                            $("#content-table").html(obj.tabla);
                            var table = CreateTable();
                            <?php if(!$inbox):  ?>
                                $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Create()" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla" href="#"><span><i class="fa fa-user-plus"></i> Crear</span></a></label>');
                            <?php endif;  ?>
                            $("#menu_form").modal("hide");
                        });
                    } else {
                        swal({title: 'Error!', text: obj.res, type: 'error'});
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            }).fail(function (error) {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            });
        }
    }

    function Anule(id) {
        swal({
            title: 'Esta seguro de anular el registro ',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Anular!'
        }).then((result) => {
            if (result) {
                $.post("<?= base_url() ?>Reception/C_Received/ChangeStatus", {id: id, status:'4', resend:0}, function (data) {
                    if (data.res == "OK") {
                        swal('Operacion Exitosa!', 'El registro ha sido anulado.', 'success').then((result) => {});
                        $('.label-'+id).removeClass('label-success').addClass('label-default').html('ANULADO');
                    } else {
                        swal({title: 'Error!', text: data, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            }
        }).catch(swal.noop)
    }
    
    function Accept(id,status,resend_of){
        
        var txt = (status == 23)?'ACEPTADO':'RECHAZADO';
    
        swal({
            title: (status == 23) ? 'Aceptar Correspondencia?' : 'Rechazar Correspondencia?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'SI!'
        }).then((result) => {
            if (result) {
                $.post("<?= base_url() ?>Reception/C_Received/ChangeStatus", {id: id,status:status,resend:resend_of}, function (data) {
                    if (data.res == "OK") {
                        swal('Operacion Exitosa!', '', 'success').then((result) => {});
                        $('.label-'+id).removeClass('label-success').addClass('label-info').html(txt);
                       
                        if(status == 23){
                            var coop = '0';
                            if($('#id'+id).attr('copy') == '1'){
                                var coop = '1';
                            }
                            
                            $('#btns'+id).html('<button type="button"  class="btn btn-info btn-xs btn-tabla" title="Editar" onclick="Update('+id+',23)"><i class="fa fa-search"></i></button> <button type="button"  class="btn btn-info btn-xs btn-tabla" id="btn-resend-'+id+'" title="Reenviar" onclick="Resend('+id+','+coop+')"><i class="fa fa-send"></i></button>');
                        }else{
                            $('#btns'+id).html('');
                        }
                    } else {
                        swal({title: 'Error!', text: data, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            }
        }).catch(swal.noop)
    }
    
    function CreateTable(){
        var oTable = $('#tabla').dataTable({
            "searching": false,
            dom: 'Bfrtip',
            'autoWidth': false,
            fixedHeader: true,
            sScrollX: false,
            scrollCollapse: true,
            "scrollY": "300px",
            "ordering": false,
            buttons: [
                $.extend(true, {}, {}, {
                    extend: 'copyHtml5'
                }),
                $.extend(true, {}, {}, {
                    extend: 'excelHtml5'
                })
            ],
            "language": {
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                }
            }
        });
    }

</script>