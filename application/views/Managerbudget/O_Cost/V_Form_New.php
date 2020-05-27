<style>
    .nav-tabs-custom>.nav-tabs>li.active {
        border-top-color: #d2d6de;
    }
    .form-horizontal .control-label {
        text-align: left;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1 id="titulo">
            <i class="fa fa-edit"></i>NUEVA ORDEN DE COSTO
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Medios</a></li>
            <li><a href="<?= base_url() ?>OrderC">Listar</a></li>
            <li class="active">Crear</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Valores</h3>
                    </div>
                    <form class="form-horizontal">
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Descuento</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input type="text" class="form-control input-sm decimals" id="ordcos_desc" name="ordcos_desc" value="0" placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Iva</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input type="text" class="form-control input-sm decimals" id="ordcos_iva" name="ordcos_iva" value="19"  placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Valor</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control input-sm decimals" id="ordcos_valor" value="0" placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Descuento</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="ordcos_valordesc"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Iva</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="ordcos_valoriva"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm numerico" id="ordcos_total" name="ordcos_total" placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="button" class="btn btn-default" onclick="window.location.href = '<?= base_url() ?>OrderC'">Cancelar</button>
                           <button type="button" class="btn btn-primary pull-right" id="save">Guardar</button>
                            <button type="button" class="btn btn-primary pull-right" style="display:none" id="update">Actualizar</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs nav-default">
                        <li class="active"><a href="#tab_1" data-toggle="tab">Info</a></li>
                        <li><a href="#tab_2" data-toggle="tab">Detalle</a></li>
                        <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <form role="form" id="form" method="POST" enctype="multipart/form-data">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Cliente</label>
                                                <select class="form-control input-sm info-required" id="pvcl_id_clie" name="pvcl_id_clie">
                                                    <option value="">. . .</option>
                                                    <?php foreach ($clientes as $v) : ?>
                                                        <option value="<?= $v->id_client ?>" ><?= $v->nombre ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Proveedor</label>
                                                <select class="form-control input-sm info-required" id="pvcl_id_prov" name="pvcl_id_prov">
                                                    <option value="">. . .</option>
                                                    <?php foreach ($proveedores as $v) : ?>
                                                        <option value="<?= $v->id_client ?>" ><?= $v->nombre ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Campaña</label>
                                                <select class="form-control input-sm info-required" id="camp_id" name="camp_id">
                                                    <option value="">. . .</option>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Producto</label>
                                                <select class="form-control input-sm info-required" id="prod_id" name="prod_id">
                                                    <option value="">. . .</option>
                                                    <?php foreach ($rubros as $v) : ?>
                                                        <option value="<?= $v->pdcl_id ?>" ><?= $v->pdcl_nombre ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tipo Orden</label>
                                                <select class="form-control input-sm info-required" id="tipo" name="tipo" >
                                                    <option value="I" selected>INTERNA</option>
                                                    <option value="E">EXTERNA</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Servicio</label>
                                                <select class="form-control input-sm info-required" id="tpsv_id" name="tpsv_id">
                                                    <option value="">. . .</option>
                                                    <?php foreach ($servicios as $v) : ?>
                                                        <option value="<?= $v->id_tipo_servicio ?>"><?= $v->nombre ?> (<?= $v->tabla ?>)</option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6" id="div-ppto" style="display:none">
                                            <div class="form-group">
                                                <label>Presupuesto</label>
                                                <div class="input-group input-group-sm">
                                                    <input readonly id="ordcos_noorden" name="ordcos_noorden" type="text" class="form-control" value="">
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default btn-flat" onclick="openModal()"><i class="fa fa-undo"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Observación</label>
                                                <textarea type="text" class="form-control input-sm" rows="2" id="ordcos_observa" name="ordcos_observa" ></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2">
                            <br /><button type="button" class="btn  btn-default btn-sm " id="add-detail"><i class="fa fa-plus"></i> Agregar Detalle</button> 
                            <br /><br />
                            <?= $detail ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modal-update">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Detalle</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Detalle</label>
                            <textarea type="text" class="form-control input-sm det-required" rows="2" id="dordcos_detalle" name="dordcos_detalle" ></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Cantidad</label>
                            <input type="number" class="form-control input-sm det-required "  id="dordcos_cant" name="dordcos_cant" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Valor</label>
                            <input type="text" class="form-control input-sm det-required decimals"  id="dordcos_valor" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Total</label>
                            <input readonly type="text" class="form-control input-sm det-required numerico"  id="dordcos_total"  />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary pull-right" id="btn-create" onclick="AddDetail()"><i class="fa fa-save"></i> Crear</button>
                <button type="button" class="btn btn-primary pull-right" id="btn-update" ><i class="fa fa-refresh"></i> Actualizar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-ppto">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Detalle</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Presupuestos</label>
                            <select class="form-control input-sm select2" style="width: 100%" multiple id="noorden" name="noorden[]">
                                <option value="">. . .</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary pull-right" id="btn-ppto" ><i class="fa fa-save"></i> Agregar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('.numerico, .decimals').autoNumeric('init', {
            mDec: 2,
            aDec: ',',
            aSep: '.'
        });
        
        $('.select2').select2();

        $('#ordcos_desc, #ordcos_iva, #ordcos_valor').keyup(function () {
             CalcularTotal();
        });

        $('#dordcos_valor, #dordcos_cant').keyup(function () {
            CalcularTotalDetail();
        });

        $('#save').click(function () {
            save();
        });

        $('#add-detail').click(function () {
            $('#btn-create').show();
            $('#btn-update').hide();
            $('#modal-update').modal();
        });
        
        $('#pvcl_id_clie').change(function () {
            if ($(this).val() != '') {
                $.post('<?= base_url() ?>Managerbudget/C_Ppto/LoadSelect', {cliente: $(this).val()}, function (data) {
                    var option = '<option value="">. . .</option>';
                    $.each(data.campanas, function (e, i) {
                        option += '<option value="' + i.camp_id + '">' + i.camp_nombre + '</option>';
                    });
                    $('#camp_id').html(option);

                    var option = '<option value="">. . .</option>';
                    $.each(data.rubros, function (e, i) {
                        option += '<option value="' + i.pdcl_id + '">' + i.pdcl_nombre + '</option>';
                    });
                    $('#prod_id').html(option);
                }, 'json');
            }
        });
        
        $('#tipo').change(function () {
            $.post('<?= base_url() ?>Managerbudget/O_Cost/C_Order_Cost/LoadServices', {tipo: $(this).val()}, function (data) {
                var option = '<option value="">. . .</option>';
                $.each(data.services, function (e, i) {
                    option += '<option value="' + i.id_tipo_servicio + '">' + i.nombre + '('+i.tabla+')</option>';
                });
                $('#tpsv_id').html(option);
            }, 'json');
        });
        lock('0');
    });
    
    function openModal(){
        if($('#prod_id').val() != '' && $('#tpsv_id').val() != '' && $('#pvcl_id_clie').val() != '' && $('#camp_id').val() != ''){
            $(".loader_ajax2").text("Buscando Presupuestos");
            $.post('<?= base_url() ?>Managerbudget/O_Cost/C_Order_Cost/LoadSelect', {
                cliente: $('#pvcl_id_clie').val(),
                servicio: $('#tpsv_id').val(),
                campana: $('#camp_id').val(),
                producto: $('#prod_id').val(),

            }, function (data) {
                $('#modal-ppto').modal();
                var option = '<option value="">. . .</option>';
                $.each(data.pptos, function (e, i) {
                    option += '<option value="' + i.ppto + '">' + i.ppto + ' - '+i.fecha+'</option>';
                });
                $('#noorden').html(option);
                
                
                if($("#ordcos_noorden").val() != ''){
                    var presupuestos = $("#ordcos_noorden").val();
                    var array_presupuestos = presupuestos.split(',');
                    $("#noorden").val(array_presupuestos);
                }
                $('#noorden').select2();
                $(".loader_ajax2").text("");
            }, 'json');
        }else{
            swal({title: 'Error!', text: 'Debe seleccionar Cliente, Campaña, Producto y Servicio', type: 'error'});
        }
    }
    
    function lock(id_estado){
        if(id_estado != '1' && id_estado != '0'){
            $('.form-control').attr('disabled','disabled');
            $('#save ,#add-detail').hide();
            $('.btn-danger , .btn-info ').attr('disabled','disabled').removeAttr('onclick');
        }else if(id_estado == '0'){
            $('#add-detail ').hide();
        }
    }
    
    function CalcularTotalDetail(){
        var valor = ($('#dordcos_valor').val() == '') ? 0 : $('#dordcos_valor').val().replace(/\./g, '').replace(/,/g, '.');
        var cantidad = $('#dordcos_cant').val();
        
        var total = parseFloat(valor * cantidad);
        
        $('#dordcos_total').autoNumeric('set', total);
    }

    function CalcularTotal() {
        var porcDescuento = ($('#ordcos_desc').val() == '') ? 0 : $('#ordcos_desc').val().replace(/\./g, '').replace(/,/g, '.');
        var PorcIva = ($('#ordcos_iva').val() == '') ? 0 : $('#ordcos_iva').val().replace(/\./g, '').replace(/,/g, '.');
        var valBruto = $('#ordcos_valor').val().replace(/\./g, '').replace(/,/g, '.');

        var descuento = valBruto * (porcDescuento / 100);
        var iva = parseFloat((valBruto - descuento) * (PorcIva / 100));


        $('#ordcos_valordesc').autoNumeric('set', descuento);
        $('#ordcos_valoriva').autoNumeric('set', iva);

        var total = parseFloat((valBruto - descuento) + iva);

        $('#ordcos_total').autoNumeric('set', total);

    }
    
    function AddDetail(id){
        if (validatefield('det-required')) {
            
            var valor = ($('#dordcos_valor').val() == '') ? 0 : $('#dordcos_valor').val().replace(/\./g, '').replace(/,/g, '.');
            var total = $('#dordcos_total').val().replace(/\./g, '').replace(/,/g, '.');
            $.post('<?= base_url() ?>Managerbudget/O_Cost/C_Order_Cost/AddDetail',{
                ordcos_id:id,
                dordcos_valor:valor,
                dordcos_total:total,
                dordcos_detalle:$('#dordcos_detalle').val(),
                dordcos_cant:$('#dordcos_cant').val()
            },function(data){
                if (data.res == "OK") {
                    if(data.reverse == ""){
                        swal({title: 'OK!', text: '', type: 'success'});
                        window.location.replace('<?= base_url() ?>OrderC/Edit/'+id);
                    }else{
                        swal({title: 'Warning!', text: data.msg, type: 'warning'});
                    }
                } else {
                    swal({title: 'Error!', text: data.res, type: 'error'});
                }
            },'json');
        }else {
            alertify.error("DATOS INCOMPLETOS!");
        }
    }
    
    function AddPpto(id){
        var ordcos_noorden = "";
        $.each($("#noorden").val(), function (e, i) {
            if (ordcos_noorden != "") {
                ordcos_noorden += ",";
            }
            ordcos_noorden += i;
        });
        
        $('#modal-ppto').modal('hide');
        $('#ordcos_noorden').val(ordcos_noorden);
        $('#pvcl_id_clie').val($('#pvcl_id_clie').val());
        $('#pvcl_id_prov').val($('#pvcl_id_prov').val());
        $('#camp_id').val($('#camp_id').val());
        $('#prod_id').val($('#prod_id').val());
        $('#tpsv_id').val($('#tpsv_id').val());
        
        $.post('<?= base_url() ?>Managerbudget/O_Cost/C_Order_Cost/UpdateInfo',{
            order:id,
            ordcos_noorden:ordcos_noorden
        },function(data){
            if (data.res == "OK") {
                swal({title: 'OK!', text: '', type: 'success'});
            } else {
                swal({title: 'Error!', text: data.res, type: 'error'});
            }
        },'json');
    }

    function save() {
        if (validatefield('info-required')) {
            var ordcos_desc = ($('#ordcos_desc').val() == '') ? 0 : $('#ordcos_desc').val().replace(/\./g, '').replace(/,/g, '.');
            var ordcos_iva = ($('#ordcos_iva').val() == '') ? 0 : $('#ordcos_iva').val().replace(/\./g, '').replace(/,/g, '.');
            var ordcos_valor = $('#ordcos_valor').val().replace(/\./g, '').replace(/,/g, '.');
            var ordcos_total = $('#ordcos_total').val().replace(/\./g, '').replace(/,/g, '.');
            
            
            
            var formData = new FormData($('#form')[0]);
            formData.append("ordcos_desc", ordcos_desc);
            formData.append("ordcos_iva", ordcos_iva);
            formData.append("ordcos_valor", ordcos_valor);
            formData.append("ordcos_total", ordcos_total);
            formData.append("est_id", 1);
            formData.append("usr_id_mod", '<?=$this->session->UserMedios?>');
            formData.append("usr_id", '<?=$this->session->UserMedios?>');
            formData.append("modulo_id", '0');
            formData.append("ordcos_fecha", '<?=date("Y-m-d")?>');
            $.ajax({
                url: "<?= base_url() ?>Managerbudget/O_Cost/C_Order_Cost/InsertInfo",
                type: 'POST',
                data: formData,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        $('#update').show().attr('onclick','Update('+obj.id+')');
                        $('#save').hide();
                        $('#add-detail ').show();
                        $('#btn-create').attr('onclick','AddDetail('+obj.id+')');
                        $('#btn-ppto').attr('onclick','AddPpto('+obj.id+')');
                        $('#div-ppto').show();
                        $('#titulo').html('<i class="fa fa-edit"></i> ORDEN DE COSTO N°<small>'+obj.id+' Activo</small>');
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

    function Update(id) {
        if (validatefield('info-required')) {
            var ordcos_desc = ($('#ordcos_desc').val() == '') ? 0 : $('#ordcos_desc').val().replace(/\./g, '').replace(/,/g, '.');
            var ordcos_iva = ($('#ordcos_iva').val() == '') ? 0 : $('#ordcos_iva').val().replace(/\./g, '').replace(/,/g, '.');
            var ordcos_valor = $('#ordcos_valor').val().replace(/\./g, '').replace(/,/g, '.');
            var ordcos_total = $('#ordcos_total').val().replace(/\./g, '').replace(/,/g, '.');
            
            var formData = new FormData($('#form')[0]);
            formData.append("order", id);
            formData.append("ordcos_desc", ordcos_desc);
            formData.append("ordcos_iva", ordcos_iva);
            formData.append("ordcos_valor", ordcos_valor);
            formData.append("ordcos_total", ordcos_total);
            $.ajax({
                url: "<?= base_url() ?>Managerbudget/O_Cost/C_Order_Cost/UpdateInfo",
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
    
</script>

