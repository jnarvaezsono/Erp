<div class="content-wrapper">
    <section class="content-header">
        <h1 id="titulo">
            <i class="fa fa-edit" ></i> Nuevo Doc. Equivalente
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Medios</a></li>
            <li><a href="<?= base_url() ?>Document">Listar</a></li>
            <li class="active">Crear</li>
        </ol>
    </section>
    <section class="content">
        <?php if($ant > 0): ?>
            <?php if($act > 0): ?>
            <div class="alert alert-warning alert-dismissible">
                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                El periodo actual ya fue cerrado por lo tanto no se puede generar mas documentos este mes.
            </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="alert alert-warning alert-dismissible">
                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                Para generar nuevos documentos equivalentes debe cerrarse el perido anterior.
            </div>
        <?php endif; ?>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Form</h3>
            </div>
            <form id="form-new" role="form" method="POST" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tpo_doc">Tipo de documento</label>
                                <select id="tpo_doc" name="tpo_doc" class="form-control input-sm info-required" >
                                    <option value="" >. . .</option>
                                    <option value="costo">Orden de Costo</option>
                                    <option value="gasto">Orden de Gasto</option>
                                    <option value="ppto">Orden de Externa</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="id_doc">Nº Documento</label>
                                <input readonly type="number" class="form-control input-sm info-required" id="id_doc" name="id_doc" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Proveedor</label>
                                <select disabled class="form-control input-sm info-required" id="pvcl_id" name="pvcl_id" >
                                    <option value="">. . .</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Fecha</label>
                                <input  type="text" class="form-control input-sm info-required" id="docequi_fecha" name="docequi_fecha" >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Fecha vencimiento</label>
                                <input readonly type="text" class="form-control input-sm info-required" id="docequi_fechavencimiento" name="docequi_fechavencimiento" >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Valor</label>
                                <div class="input-group">
                                    <span class="input-group-addon">$.</span>
                                    <input readonly type="text" class="form-control input-sm decimals info-required" id="docequi_valor"  placeholder="$ 0">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Detalle</label>
                                <textarea type="text" class="form-control input-sm info-required" rows="6" id="docequi_detalle" name="docequi_detalle" ></textarea>
                            </div>
                        </div>
                    </div>



                </div>

                <div class="box-footer">
                    <button type="button" class="btn btn-default" onclick="window.location.href = '<?= base_url() ?>Document'">Cancelar</button>
                    <?php if($ant > 0): ?>
                        <?php if($act <= 0): ?>
                            <button type="button" class="btn btn-primary pull-right" id="save"><i class="fa fa-save"></i> Guardar</button>
                            <button type="button" class="btn btn-primary pull-right" style="display:none" id="update"><i class="fa fa-refresh"></i> Guardar Cambios</button>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </form>
        </div>

    </section>
</div>

<div class="modal fade" id="modal-order">
    <div class="modal-dialog" style="width:300px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Asociar Orden</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="div-orden">
                        <div class="form-group">
                            <label>Orden</label>
                            <select class="form-control input-sm " id="order" name="order" style="width: 100%" onchange="loadInfo()">
                                <option value="">. . .</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12" id="div-ordenE">
                        <div class="form-group">
                            <label>Orden</label>
                            <input type="text" class="form-control input-sm " id="orderE" name="orderE" style="width: 100%"  />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary pull-right" id="btn-create" > Aceptar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('#docequi_fecha').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
        });

        $('#docequi_fecha').change(function () {
            $("#docequi_fechavencimiento").val(addDiasFecha($(this).val(), 30));
        });

        $('.numerico, .decimals').autoNumeric('init', {
            mDec: 2,
            aDec: ',',
            aSep: '.'
        });

        $('#tpo_doc').change(function () {
            if(this.value != ''){
                LoadOrder(this.value);
            }
        });

        $('#save').click(function () {
            save();
        });
        
        lock('0');
    });
    
    function validateTipo(tipo,order){
        if(tipo != $('#tpo_doc').val() && order == $('#id_doc').val()){
            $('#tpo_doc').val(tipo);
        }
    }
    
    function lock(id_estado){
        if(id_estado != '1' && id_estado != '0'){
            $('.form-control').attr('disabled','disabled');
            $('#save').hide();
        }
    }

    function LoadOrder(tipo) {
        if(tipo == 'ppto'){
            $('#div-orden').hide();
            $('#div-ordenE').show();
            $('#modal-order').modal();
            $('#btn-create').attr('onclick','AddOrder()');
        }else{
            $('#btn-create').attr('onclick','');
            $('#div-orden').show();
            $('#div-ordenE').hide();
            $.post('<?= base_url() ?>Billing/C_Document/LoadOrder',{tipo:tipo},function(data){
                var option = '<option value="" >. . .</option>';
                $.each(data.orders,function(e,i){
                    option += '<option value="'+i.order+'" >'+i.order+' '+i.proveedor+'</option>';
                });
                $('#order').html(option);
                $('#modal-order').modal();
            },'json');
        }   
    }
    
    function loadInfo(){
        if($('#order').val() != ''){
            $.post('<?= base_url() ?>Billing/C_Document/LoadDetail',{order:$('#order').val(),tipo:$('#tpo_doc').val()},function(data){
                $('#id_doc').val($('#order').val());
                $('#docequi_detalle').val(data.detalle);
                $('#docequi_valor').autoNumeric('set', data.valor);
                $('#pvcl_id').html('<option value="'+data.id_prov+'" selected>'+data.proveedor+'</option>');
                $('#modal-order').modal('hide');
            },'json');
        }
    }
    
    function save(){
        if (validatefield('info-required')) {
            
            var docequi_valor = $('#docequi_valor').val().replace(/\./g, '').replace(/,/g, '.');

            var formData = new FormData($('#form-new')[0]);
            
            formData.append("pvcl_id", $('#pvcl_id').val());
            
            formData.append("docequi_valor", docequi_valor);
            formData.append("docequi_total", docequi_valor);
            formData.append("usr_mod", '<?=$this->session->UserMedios?>');
            formData.append("usr_id", '<?=$this->session->UserMedios?>');
            formData.append("est_id", 1);
            formData.append("num_impresiones", '-1');
            formData.append("docequi_fecha", '<?=date("Y-m-d")?>');
            formData.append("dLS\n\
        ?=date("H:i:s")?>');
            $.ajax({
                url: "<?= base_url() ?>Billing/C_Document/InsertInfo",
                type: 'POST',
                data: formData,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        $('#update').show().attr('onclick','Update('+obj.id+')');
                        $('#save').hide();
                        $('#titulo').html('<i class="fa fa-edit"></i> Doc. Equivalente N°<small>'+obj.id+' Activo </small>');
                        
                        swal({title: 'OK!', text: '', type: 'success'});
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
    
    function AddOrder(){
        if(ValidateInput('orderE')){
            $.post('<?= base_url() ?>Billing/C_Document/LoadOrderE',{order:$('#orderE').val()},function(data){
                if(data.res == 'success'){
                    $('#id_doc').val(data.datos.order);
                    $('#docequi_detalle').val(data.datos.detalle);
                    $('#docequi_valor').autoNumeric('set', data.datos.valor);
                    $('#pvcl_id').html('<option value="'+data.datos.id_prov+'" selected>'+data.datos.proveedor+'</option>');
                    $('#modal-order').modal('hide');
                }else if(data.res == 'warning'){
                    swal({title: 'Atención!', text: data.msg, type: 'warning'});
                }else if(data.res == 'error'){
                    swal({title: 'Error!', text: data.msg, type: 'error'});
                }
            },'json');
        }
    }
    
    function Update(id){
        if (validatefield('info-required')) {
            var docequi_valor = $('#docequi_valor').val().replace(/\./g, '').replace(/,/g, '.');

            var formData = new FormData($('#form-new')[0]);
            formData.append("docequi_id", id);
            formData.append("pvcl_id", $('#pvcl_id').val());
            
            formData.append("docequi_valor", docequi_valor);
            formData.append("docequi_total", docequi_valor);
            formData.append("usr_mod", '<?=$this->session->UserMedios?>');
            $.ajax({
                url: "<?= base_url() ?>Billing/C_Document/UpdateInfo",
                type: 'POST',
                data: formData,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        swal({title: 'OK!', text: '', type: 'success'});
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
    

    function addDiasFecha(fecha, dias) {
        var fechahoy = fecha;

        var sumarDias = parseInt(dias);

        fecha = fechahoy;

        fecha = fecha.replace("-", "/").replace("-", "/");

        fecha = new Date(fecha);
        fecha.setDate(fecha.getDate() + sumarDias);

        var anio = fecha.getFullYear();
        var mes = fecha.getMonth() + 1;
        var dia = fecha.getDate();

        if (mes.toString().length < 2) {
            mes = "0".concat(mes);
        }

        if (dia.toString().length < 2) {
            dia = "0".concat(dia);
        }

        return anio + "-" + mes + "-" + dia;
    }

</script>