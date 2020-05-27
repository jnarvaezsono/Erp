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
        <h1>
            <i class="fa fa-edit"></i> Articulo Publicitario N&deg;
            <small><?= $id ?> <?= $row->estado ?> - Orden N&deg; <?=$orden->ord_id?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Medios</a></li>
            <li><a href="<?= base_url() ?>Articulo">Listar</a></li>
            <li class="active">Editar</li>
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
                                        <input type="text" class="form-control input-sm decimals" id="artp_desc" name="artp_desc" value="<?= $row->descuento ?>" placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Iva</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input type="text" class="form-control input-sm decimals" id="artp_iva" name="artp_iva" value="<?= $row->iva ?>"  placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input type="text" class="form-control input-sm decimals" id="artp_spa" name="artp_spa" value="<?= $row->spa ?>"  placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Iva Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input readonly type="text" class="form-control input-sm decimals" id="artp_ivaspa" name="artp_ivaspa" value="<?= $row->iva_spa ?>"  placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Valor</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control input-sm decimals" id="artp_valor" value="<?= $row->valor ?>" placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Descuento</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="artp_valordesc"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Iva</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="artp_valoriva"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="artp_totalspa"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Iva Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="artp_valorivaspa"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm numerico" id="artp_total" name="artp_total" placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="button" class="btn btn-default" onclick="window.location.href = '<?= base_url() ?>Articulo'">Cancelar</button>
                            <button type="button" class="btn btn-primary pull-right" id="save">Actualizar</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs nav-default">
                        <li><a href="#tab_1" data-toggle="tab">Info</a></li>
                        <li class="active"><a href="#tab_2" data-toggle="tab">Detalle</a></li>
                        <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane " id="tab_1">
                            <form role="form" id="form" method="POST" enctype="multipart/form-data">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Cliente</label>
                                                <select class="form-control input-sm info-required" id="pvcl_id_clie" name="pvcl_id_clie">
                                                    <option value="">. . .</option>
                                                    <?php foreach ($clientes as $v) : ?>
                                                        <option value="<?= $v->id_client ?>" <?= ($v->id_client == $row->cliente) ? 'selected' : '' ?>><?= $v->nombre ?></option>
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
                                                        <option value="<?= $v->id_client ?>" <?= ($v->id_client == $row->proveedor) ? 'selected' : '' ?>><?= $v->nombre ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Campaña</label>
                                                <select class="form-control input-sm info-required" id="camp_id" name="camp_id">
                                                    <option value="">. . .</option>
                                                    <?php foreach ($campanas as $v) : ?>
                                                        <option value="<?= $v->camp_id ?>" <?= ($v->camp_id == $row->campana) ? 'selected' : '' ?>><?= $v->camp_nombre ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Producto</label>
                                                <select class="form-control input-sm info-required" id="pdcl_id" name="pdcl_id">
                                                    <option value="">. . .</option>
                                                    <?php foreach ($rubros as $v) : ?>
                                                        <option value="<?= $v->pdcl_id ?>" <?= ($v->pdcl_id == $row->producto) ? 'selected' : '' ?>><?= $v->pdcl_nombre ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Servicio</label>
                                                <select class="form-control input-sm info-required" id="tpsv_id" name="tpsv_id">
                                                    <option value="">. . .</option>
                                                    <?php foreach ($servicios as $v) : ?>
                                                        <option value="<?= $v->id_tipo_servicio ?>" <?= ($v->id_tipo_servicio == $row->servicio) ? 'selected' : '' ?>><?= $v->nombre ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Orden Cliente</label>
                                                <input type="text" class="form-control input-sm" id="artp_numorden" name="artp_numorden" value="<?= $row->orden_cliente ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No.Cotización</label>
                                                <input type="text" class="form-control input-sm" id="artp_numcotizacion" name="artp_numcotizacion" value="<?= $row->cotizacion ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Observación</label>
                                                <textarea type="text" class="form-control input-sm" rows="2" id="artp_observacion" name="artp_observacion" ><?= $row->observacion ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Observación Orden</label>
                                                <textarea type="text" class="form-control input-sm" rows="2" id="ord_observacion" name="ord_observacion" ><?=$orden->ord_observacion?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane active" id="tab_2">
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
    <div class="modal-dialog" style="width:70%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Detalle</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form id="form-detail" role="form" method="POST" enctype="multipart/form-data">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Producto</label>
                                <input type="text" class="form-control input-sm det-required" value=""  id="dartp_producto" name="dartp_producto" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tamaño</label>
                                <input type="text" class="form-control input-sm " id="dartp_tamano" name="dartp_tamano" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Material</label>
                                <input type="text" class="form-control input-sm " id="dartp_material" name="dartp_material" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tintas</label>
                                <input type="text" class="form-control input-sm det-required" value=""  id="dartp_tintas" name="dartp_tintas" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Características</label>
                                <textarea type="text" class="form-control input-sm " rows="2" id="dartp_caracteristicas" name="dartp_caracteristicas" ></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Detalle</label>
                                <textarea type="text" class="form-control input-sm " rows="2" id="dartp_observacion" name="dartp_observacion" ></textarea>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Unidad</label>
                                <select class="form-control input-sm det-required" id="unidad" name="unidad">
                                    <option value="">. . .</option>
                                    <option value="1">BTL</option>
                                    <option value="2">MEDIOS</option>
                                    <option value="3">PRODUCCIÓN</option>
                                    <option value="4">DIGITAL</option>
                                    <option value="5">DISEÑO</option>
                                    <option value="6">SISTEMAS</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Cantidad</label>
                                <input type="number" class="form-control input-sm det-required" value="1"  id="dartp_cantidad" name="dartp_cantidad" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Valor</label>
                                <input type="text" class="form-control input-sm det-required decimals" value="0" id="dartp_valor"   />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Total</label>
                                <input readonly type="text" class="form-control input-sm det-required numerico"  id="dartp_total"   />
                            </div>
                        </div>
                        
                    </form>
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

<script>
    $(function () {
        var sw = false;
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        
        $('.numerico, .decimals').autoNumeric('init', {
            mDec: 2,
            aDec: ',',
            aSep: '.'
        });
        
        CalcularTotal();

        $('#artp_desc, #artp_iva, #artp_valor, #artp_spa').keyup(function () {
             CalcularTotal();
        });

        $('#dartp_cantidad, #dartp_valor').keyup(function () {
            calcularDetalle();
        });

        $('#save').click(function () {
            save();
        });

        $('#add-detail').click(function () {
            $('#btn-create').show();
            $('#btn-update').hide();
            $('#form-detail')[0].reset();
            $('#modal-update').modal();
        });
        
        $('#emis_id').change(function () {
            if ($(this).val() != '') {
                cargarPrograma($(this).val(),'emis_id','cat_programasr');
            }
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
                    $('#pdcl_id').html(option);
                }, 'json');
            }
        });
        lock('<?=$row->id_estado?>');
    });
    
    function calcularDetalle(){
        
        var valorDet = ($('#dartp_valor').val() == '') ? 0 : $('#dartp_valor').val().replace(/\./g, '').replace(/,/g, '.');
        var total  = parseFloat(valorDet * $('#dartp_cantidad').val());
        
        $('#dartp_total').autoNumeric('set', total);
    }
    
    function lock(id_estado){
        if(id_estado != '1'){
            $('.form-control').attr('disabled','disabled');
            $('#save ,#add-detail ,#add-oc').hide();
            $('.btn-danger ,.btn-info').attr('disabled','disabled').removeAttr('onclick');
        }
    }
    
    function OpenDetail(id_detalle){
        $('#form-detail')[0].reset();
        $.post('<?= base_url() ?>Managerbudget/C_Ppto/GetRowDetailppto',{table:'det_artpub',field:'dartp_id',id_detalle:id_detalle},function(data){
            
            $('#dartp_producto').val(data.dartp_producto);
            $('#unidad').val(data.unidad);
            $('#dartp_tamano').val(data.dartp_tamano);
            $('#dartp_material').val(data.dartp_material);
            $('#dartp_tintas').val(data.dartp_tintas);
            $('#dartp_cantidad').val(data.dartp_cantidad);
            $('#dartp_caracteristicas').val(data.dartp_caracteristicas);
            $('#dartp_observacion').val(data.dartp_observacion);
            $('#dartp_valor').autoNumeric('set', data.dartp_valor);
            $('#dartp_total').autoNumeric('set', data.dartp_total);
            
            //calcularDetalle();
            
            $('#btn-create').hide();
            $('#btn-update').show();
            $('#btn-update').attr('onclick','UpdateDetail('+id_detalle+')');
            $('#modal-update').modal();
            
        },'json');
    }

    function CalcularTotal() {
        var porcDescuento = ($('#artp_desc').val() == '') ? 0 : $('#artp_desc').val().replace(/\./g, '').replace(/,/g, '.');
        var PorcIva = ($('#artp_iva').val() == '') ? 0 : $('#artp_iva').val().replace(/\./g, '').replace(/,/g, '.');
        var PorcSpa = ($('#artp_spa').val() == '') ? 0 : $('#artp_spa').val().replace(/\./g, '').replace(/,/g, '.');
        var PorcIvaSpa = ($('#artp_ivaspa').val() == '') ? 0 : $('#artp_ivaspa').val().replace(/\./g, '').replace(/,/g, '.');
        var valBruto = $('#artp_valor').val().replace(/\./g, '').replace(/,/g, '.');
        
        var descuento = valBruto * (porcDescuento / 100);
        
        var subtotal = parseFloat(valBruto - descuento);
        
        var iva = parseFloat((valBruto - descuento) * (PorcIva / 100));
        var total_spa = parseFloat(subtotal * (PorcSpa / 100));
        var iva_spa = parseFloat(total_spa * (PorcIvaSpa / 100));

        $('#artp_valordesc').autoNumeric('set', descuento);
        $('#artp_valoriva').autoNumeric('set', iva);
        $('#artp_totalspa').autoNumeric('set', total_spa);       
        $('#artp_valorivaspa').autoNumeric('set', iva_spa);       

        var total = parseFloat(subtotal + iva + total_spa + iva_spa);

        $('#artp_total').autoNumeric('set', total);

    }
    
    function AddDetail(){
        if (validatefield('det-required')) {
            
            var formData = new FormData($('#form-detail')[0]);
            formData.append("artp_id", <?= $id ?>);
            formData.append("tipo", <?= $tipo ?>);
            formData.append("dartp_valor", $('#dartp_valor').val().replace(/\./g, '').replace(/,/g, '.'));
            formData.append("dartp_total", $('#dartp_total').val().replace(/\./g, '').replace(/,/g, '.'));
            formData.append("dartp_fecha", '<?=date("Y-m-d")?>');
            $.ajax({
                url: "<?= base_url() ?>Managerbudget/C_Ppto/AddDetail",
                type: 'POST',
                data: formData,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        if(obj.reverse == ""){
                            swal({title: 'OK!', text: '', type: 'success'});
                            location.reload();
                        }else{
                            swal({title: 'Warning!', text: obj.msg , type: 'error'});
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
        }else {
            alertify.error("DATOS INCOMPLETOS!");
        }
    }
    
    function UpdateDetail(id_detalle){
        if (validatefield('det-required')) {
            
            var formData = new FormData($('#form-detail')[0]);
            formData.append("dartp_id", id_detalle);
            formData.append("artp_id", <?= $id ?>);
            formData.append("tipo", <?= $tipo ?>);
            formData.append("dartp_valor", $('#dartp_valor').val().replace(/\./g, '').replace(/,/g, '.'));
            formData.append("dartp_total", $('#dartp_total').val().replace(/\./g, '').replace(/,/g, '.'));
            
            $.ajax({
                url: "<?= base_url() ?>Managerbudget/C_Ppto/UpdateDetail",
                type: 'POST',
                data: formData,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        if(obj.reverse == ""){
                            swal({title: 'OK!', text: '', type: 'success'});
                            location.reload();
                        }else{
                            swal({title: 'Warning!', text: obj.msg , type: 'error'});
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
        }else {
            alertify.error("DATOS INCOMPLETOS!");
        }
    }

    function save() {
        if (validatefield('info-required')) {
            var artp_desc = ($('#artp_desc').val() == '') ? 0 : $('#artp_desc').val().replace(/\./g, '').replace(/,/g, '.');
            var artp_iva = ($('#artp_iva').val() == '') ? 0 : $('#artp_iva').val().replace(/\./g, '').replace(/,/g, '.');
            var artp_spa = ($('#artp_spa').val() == '') ? 0 : $('#artp_spa').val().replace(/\./g, '').replace(/,/g, '.');
            var artp_ivaspa = ($('#artp_ivaspa').val() == '') ? 0 : $('#artp_ivaspa').val().replace(/\./g, '').replace(/,/g, '.');
            var artp_valor = $('#artp_valor').val().replace(/\./g, '').replace(/,/g, '.');
            var artp_total = $('#artp_total').val().replace(/\./g, '').replace(/,/g, '.');

            var formData = new FormData($('#form')[0]);
            formData.append("ord_id", <?=$orden->ord_id?>);
            formData.append("ppto", <?= $id ?>);
            formData.append("tipo", <?= $tipo ?>);
            formData.append("artp_desc", artp_desc);
            formData.append("artp_iva", artp_iva);
            formData.append("artp_valor", artp_valor);
            formData.append("artp_total", artp_total);
            formData.append("artp_spa", artp_spa);
            formData.append("artp_ivaspa", artp_ivaspa);
            formData.append("total", artp_total);
            $.ajax({
                url: "<?= base_url() ?>Managerbudget/C_Ppto/UpdateInfo",
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
    
    function DeleteDetail(id_detalle){
        swal({
            title: 'Confirmar!',
            text: "Eliminar detalle",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar!',
            reverseButtons: true
        }).then((result) => {
            if (result) {
                $.post('<?= base_url() ?>Managerbudget/C_Ppto/DeleteDetail',{
                    id_detalle:id_detalle,
                    ppto:<?= $id ?>,
                    tipo:<?= $tipo ?>,
                },function(data){
                    if(data.res == 'OK'){
                        swal({title: 'OK!', text: '', type: 'success'});
                        location.reload();
                    } else {
                        swal({title: 'Error!', text: obj.res, type: 'error'});
                    }
                },'json');
            }
        }, function (dismiss) {
            if (dismiss === 'cancel') {
                
            }
        }).catch(swal.noop)
    
        
    }
</script>

