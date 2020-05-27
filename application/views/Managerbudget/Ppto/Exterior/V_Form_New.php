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
            <i class="fa fa-edit"></i>Nuevo Presupuesto De Publicidad Exterior
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Medios</a></li>
            <li><a href="<?= base_url() ?>Exterior">Listar</a></li>
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
                                        <input type="text" class="form-control input-sm decimals" id="pubext_desc" name="pubext_desc" value="0" placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Iva</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input type="text" class="form-control input-sm decimals" id="pubext_iva" name="pubext_iva" value="19"  placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input type="text" class="form-control input-sm decimals" id="pubext_spa" name="pubext_spa" value="10"  placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Iva Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input readonly type="text" class="form-control input-sm decimals" id="pubext_ivaspa" name="pubext_ivaspa" value="19"  placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Valor</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control input-sm decimals" id="pubext_valor" value="0" placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Descuento</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="pubext_valordesc"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Iva</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="pubext_valoriva"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="pubext_totalspa"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Iva Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="pubext_valorivaspa"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm numerico" id="pubext_total" name="pubext_total" placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="button" class="btn btn-default" onclick="window.location.href = '<?= base_url() ?>Exterior'">Cancelar</button>
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
                                                        <option value="<?= $v->id_client ?>" <?=($v->id_status == 9999)?' style="background-color:#eee;" disabled':''?>><?= $v->nombre ?></option>
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
                                                        <option value="<?= $v->id_client ?>"><?= $v->nombre ?></option>
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
                                                <select class="form-control input-sm info-required" id="pdcl_id" name="pdcl_id">
                                                    <option value="">. . .</option>
                                                    <?php foreach ($rubros as $v) : ?>
                                                        <option value="<?= $v->pdcl_id ?>" ><?= $v->pdcl_nombre ?></option>
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
                                                        <option value="<?= $v->id_tipo_servicio ?>" ><?= $v->nombre ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Orden Cliente</label>
                                                <input type="text" class="form-control input-sm" id="pubext_numorden" name="pubext_numorden" value="" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No.Cotización</label>
                                                <input type="text" class="form-control input-sm" id="pubext_numcotizacion" name="pubext_numcotizacion" value="" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Observación</label>
                                                <textarea type="text" class="form-control input-sm" rows="2" id="pubext_observacion" name="pubext_observacion" ></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Observación Orden</label>
                                                <textarea type="text" class="form-control input-sm" rows="2" id="ord_observacion" name="ord_observacion" ></textarea>
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
                                <label>Pieza</label>
                                <select class="form-control input-sm det-required" id="pieza_id" name="pieza_id">
                                    <option value="">. . .</option>
                                    <?php foreach ($piezas as $v) : ?>
                                        <option value="<?= $v->pieza_id ?>" ><?= $v->pieza_nombre ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Fecha Inicio</label>
                                <input type="text" class="form-control  input-sm det-required" id="dpubext_fechainicio" name="dpubext_fechainicio" onchange="calcularDetalle()">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Fecha Fin</label>
                                <input type="text" class="form-control  input-sm det-required" id="dpubext_fechafin" name="dpubext_fechafin" onchange="calcularDetalle()">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Duración</label>
                                <input readonly type="number" class="form-control input-sm "  id="dpubext_duracion" name="dpubext_duracion" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tamaño impresion</label>
                                <input type="text" class="form-control input-sm "  id="dpubext_tamimpresion" name="dpubext_tamimpresion" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Area Visual</label>
                                <input type="text" class="form-control input-sm "  id="dpubext_areavisual" name="dpubext_areavisual" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Ciudad</label>
                                <input type="text" class="form-control input-sm det-required"  id="dpubext_ciudad" name="dpubext_ciudad" />
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Ubicación</label>
                                <textarea type="text" class="form-control input-sm " rows="2" id="dpubext_ubicacion" name="dpubext_ubicacion" ></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Detalle</label>
                                <textarea type="text" class="form-control input-sm " rows="2" id="dpubext_detalle" name="dpubext_detalle" ></textarea>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Cantidad</label>
                                <input type="number" class="form-control input-sm det-required" value="1"  id="dpubext_cantidad" name="dpubext_cantidad" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Valor Unitario</label>
                                <input type="text" class="form-control input-sm det-required decimals" value="0" id="dpubext_vlruni"   />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Total</label>
                                <input readonly type="text" class="form-control input-sm det-required numerico"  id="dpubext_total"   />
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
        
        $('#dpubext_fechainicio, #dpubext_fechafin').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
        });
        
        $('#dpubext_fechainicio, #dpubext_fechafin').datepicker('setDate',today);

        $('#pubext_desc, #pubext_iva, #pubext_valor, #pubext_spa').keyup(function () {
             CalcularTotal();
        });

        $('#dpubext_cantidad, #dpubext_vlruni').keyup(function () {
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
        lock('0');
    });
    
    function calcularDetalle(){
        var fecha = new Date();
        var primero = $('#dpubext_fechainicio').val();
        var segundo = $('#dpubext_fechafin').val();
        var numdias = (Math.floor((Date.parse(segundo) - Date.parse(primero)) / 86400000))+ 1;
        
        if(numdias < 0){
            numdias = numdias*(-1);
        }
        $('#dpubext_duracion').val(numdias);
        
        var valorDet = ($('#dpubext_vlruni').val() == '') ? 0 : $('#dpubext_vlruni').val().replace(/\./g, '').replace(/,/g, '.');
        
        var total  = parseFloat(valorDet * $('#dpubext_cantidad').val());
        
        $('#dpubext_total').autoNumeric('set', total);
    }
    
    function lock(id_estado){
        if(id_estado != '1' && id_estado != '0'){
            $('.form-control').attr('disabled','disabled');
            $('#save ,#add-detail ,#add-oc').hide();
            $('.btn-danger ,.btn-info').attr('disabled','disabled').removeAttr('onclick');
        }else if(id_estado == '0'){
            $('#add-detail').hide();
        }
    }

    function CalcularTotal() {
        var porcDescuento = ($('#pubext_desc').val() == '') ? 0 : $('#pubext_desc').val().replace(/\./g, '').replace(/,/g, '.');
        var PorcIva = ($('#pubext_iva').val() == '') ? 0 : $('#pubext_iva').val().replace(/\./g, '').replace(/,/g, '.');
        var PorcSpa = ($('#pubext_spa').val() == '') ? 0 : $('#pubext_spa').val().replace(/\./g, '').replace(/,/g, '.');
        var PorcIvaSpa = ($('#pubext_ivaspa').val() == '') ? 0 : $('#pubext_ivaspa').val().replace(/\./g, '').replace(/,/g, '.');
        var valBruto = $('#pubext_valor').val().replace(/\./g, '').replace(/,/g, '.');
        
        var descuento = valBruto * (porcDescuento / 100);
        
        var subtotal = parseFloat(valBruto - descuento);
        
        var iva = parseFloat((valBruto - descuento) * (PorcIva / 100));
        var total_spa = parseFloat(subtotal * (PorcSpa / 100));
        var iva_spa = parseFloat(total_spa * (PorcIvaSpa / 100));

        $('#pubext_valordesc').autoNumeric('set', descuento);
        $('#pubext_valoriva').autoNumeric('set', iva);
        $('#pubext_totalspa').autoNumeric('set', total_spa);       
        $('#pubext_valorivaspa').autoNumeric('set', iva_spa);       

        var total = parseFloat(subtotal + iva + total_spa + iva_spa);

        $('#pubext_total').autoNumeric('set', total);

    }
    
    function AddDetail(id){
        if (validatefield('det-required')) {
            
            var formData = new FormData($('#form-detail')[0]);
            formData.append("pubext_id", id);
            formData.append("tipo", <?= $tipo ?>);
            formData.append("dpubext_vlruni", $('#dpubext_vlruni').val().replace(/\./g, '').replace(/,/g, '.'));
            formData.append("dpubext_total", $('#dpubext_total').val().replace(/\./g, '').replace(/,/g, '.'));
            formData.append("dpubext_fecha", '<?=date("Y-m-d")?>');
            $.ajax({
                url: "<?= base_url() ?>Managerbudget/C_Ppto/AddDetail",
                type: 'POST',
                data: formData,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        if(obj.reverse == ""){
                            swal({title: 'OK!', text: '', type: 'success'});
                        window.location.replace('<?= base_url() ?>Exterior/Edit/'+id+'/8');
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
            var pubext_desc = ($('#pubext_desc').val() == '') ? 0 : $('#pubext_desc').val().replace(/\./g, '').replace(/,/g, '.');
            var pubext_iva = ($('#pubext_iva').val() == '') ? 0 : $('#pubext_iva').val().replace(/\./g, '').replace(/,/g, '.');
            var pubext_spa = ($('#pubext_spa').val() == '') ? 0 : $('#pubext_spa').val().replace(/\./g, '').replace(/,/g, '.');
            var pubext_ivaspa = ($('#pubext_ivaspa').val() == '') ? 0 : $('#pubext_ivaspa').val().replace(/\./g, '').replace(/,/g, '.');
            var pubext_valor = $('#pubext_valor').val().replace(/\./g, '').replace(/,/g, '.');
            var pubext_total = $('#pubext_total').val().replace(/\./g, '').replace(/,/g, '.');

            var formData = new FormData($('#form')[0]);
            formData.append("tipo", <?= $tipo ?>);
            formData.append("pubext_desc", pubext_desc);
            formData.append("pubext_iva", pubext_iva);
            formData.append("pubext_valor", pubext_valor);
            formData.append("pubext_total", pubext_total);
            formData.append("pubext_spa", pubext_spa);
            formData.append("pubext_ivaspa", pubext_ivaspa);
            formData.append("est_id", 1);
            formData.append("usr_mod", '<?=$this->session->UserMedios?>');
            formData.append("usr_id", '<?=$this->session->UserMedios?>');
            formData.append("pubext_fecha", '<?=date("Y-m-d")?>');
            $.ajax({
                url: "<?= base_url() ?>Managerbudget/C_Ppto/InsertInfo",
                type: 'POST',
                data: formData,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        $('#update').show().attr('onclick','Update('+obj.id+','+obj.ord_id+')');
                        $('#save').hide();
                        $('#add-detail ,#add-oc').show();
                        $('#btn-create').attr('onclick','AddDetail('+obj.id+')');
                        $('#titulo').html('<i class="fa fa-edit"></i> Publicidad Exterior N°<small>'+obj.id+' Activo - Orden N° '+obj.ord_id+'</small>');
                        swal({title: 'OK!', text: '', type: 'success'});
                    } else {
                        swal({title: 'Error!', text: obj.msg, type: 'error'});
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
    
    function Update(id,ord_id) {
        if (validatefield('info-required')) {
            var pubext_desc = ($('#pubext_desc').val() == '') ? 0 : $('#pubext_desc').val().replace(/\./g, '').replace(/,/g, '.');
            var pubext_iva = ($('#pubext_iva').val() == '') ? 0 : $('#pubext_iva').val().replace(/\./g, '').replace(/,/g, '.');
            var pubext_spa = ($('#pubext_spa').val() == '') ? 0 : $('#pubext_spa').val().replace(/\./g, '').replace(/,/g, '.');
            var pubext_ivaspa = ($('#pubext_ivaspa').val() == '') ? 0 : $('#pubext_ivaspa').val().replace(/\./g, '').replace(/,/g, '.');
            var pubext_valor = $('#pubext_valor').val().replace(/\./g, '').replace(/,/g, '.');
            var pubext_total = $('#pubext_total').val().replace(/\./g, '').replace(/,/g, '.');

            var formData = new FormData($('#form')[0]);
            formData.append("ord_id", ord_id);
            formData.append("ppto", id);
            formData.append("tipo", <?= $tipo ?>);
            formData.append("pubext_desc", pubext_desc);
            formData.append("pubext_iva", pubext_iva);
            formData.append("pubext_valor", pubext_valor);
            formData.append("pubext_total", pubext_total);
            formData.append("pubext_spa", pubext_spa);
            formData.append("pubext_ivaspa", pubext_ivaspa);
            formData.append("total", pubext_total);
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
    
</script>

