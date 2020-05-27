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
            <i class="fa fa-edit"></i> Externa N&deg;
            <small><?= $id ?> <?= $row->estado ?> - Orden N&deg; <?=$orden->ord_id?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Medios</a></li>
            <li><a href="<?= base_url() ?>Externa">Listar</a></li>
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
                                        <input type="text" class="form-control input-sm decimals" id="psex_desc" name="psex_desc" value="<?= $row->descuento ?>" placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Iva</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input type="text" class="form-control input-sm decimals" id="psex_iva" name="psex_iva" value="<?= $row->iva ?>"  placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input type="text" class="form-control input-sm decimals" id="psex_spa" name="psex_spa" value="<?= $row->spa ?>"  placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Iva Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input readonly type="text" class="form-control input-sm decimals" id="psex_ivaspa" name="psex_ivaspa" value="<?= $row->iva_spa ?>"  placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Valor</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control input-sm decimals" id="psex_valor" value="<?= $row->valor ?>" placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Descuento</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="psex_valordesc"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Iva</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="psex_valoriva"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="psex_totalspa"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Iva Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="psex_valorivaspa"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm numerico" id="psex_total" name="psex_total" placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="button" class="btn btn-default" onclick="window.location.href = '<?= base_url() ?>Externa'">Cancelar</button>
                            <button type="button" class="btn btn-primary pull-right" id="save">Actualizar</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs nav-default">
                        <li ><a href="#tab_1" data-toggle="tab">Info</a></li>
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
                                                <select class="form-control input-sm info-required" id="tpsv_id" name="tpsv_id" onchange="loadOrden(this.value)">
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
                                                <input type="text" class="form-control input-sm" id="psex_numorden" name="psex_numorden" value="<?= $row->orden_cliente ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Forma de Pago</label>
                                                <input type="text" class="form-control input-sm" id="psex_formapago" name="psex_formapago" value="<?= $row->forma_pago ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No.Cotización</label>
                                                <input type="text" class="form-control input-sm" id="psex_numcotizacion" name="psex_numcotizacion" value="<?= $row->cotizacion ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Observación</label>
                                                <textarea type="text" class="form-control input-sm" rows="2" id="psex_observacion" name="psex_observacion" ><?= $row->observacion ?></textarea>
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
                            <button type="button" class="btn  btn-default btn-sm " id="add-oc"><i class="fa fa-plus"></i> Agregar Desde OC</button>
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
                        <div class="col-md-12">
                            <div class="form-group" id="div-orden">
                                <label>Orden Costo</label>
                                <select class="form-control input-sm " id="ordcos_id" name="ordcos_id" onchange="changeOrder(this)">
                                    <option value="" total="0">. . .</option>
                                    <?php foreach ($ordenes as $v) : ?>
                                        <option value="<?= $v->ordcos_id ?>" total="<?= $v->ordcos_valor - $v->ordcos_vlrcobrado ?>"><?= $v->ordcos_id ?> - <?= $v->nombre ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Servicio</label>
                                <select class="form-control input-sm det-required" id="detinterna" name="tpsv_id">
                                    <option value="">. . .</option>
                                    <?php foreach ($servicios as $v) : ?>
                                        <option value="<?= $v->id_tipo_servicio ?>"><?= $v->nombre ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Valor</label>
                                <input  type="text" class="form-control input-sm det-required decimals"  id="dprode_valor"  />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Detalle</label>
                                <textarea type="text" class="form-control input-sm " rows="2" id="dprode_detalle" name="dprode_detalle" ></textarea>
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
        $('.numerico, .decimals').autoNumeric('init', {
            mDec: 2,
            aDec: ',',
            aSep: '.'
        });
        
        CalcularTotal();

        $('#psex_desc, #psex_iva, #psex_valor, #psex_spa').keyup(function () {
             CalcularTotal();
        });

        $('#save').click(function () {
            save();
        });
        
        $('#add-oc').click(function () {
            $('#div-orden').show();
            $('#btn-create').show();
            $('#btn-update').hide();
            $('#form-detail')[0].reset();
            $('#detinterna').val($('#tpsv_id').val());
            $('#modal-update').modal();
        });

        $('#add-detail').click(function () {
            $('#btn-create').show();
            $('#btn-update').hide();
            $('#form-detail')[0].reset();
            $('#div-orden').hide();
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
        lock('<?=$row->id_estado?>');
    });
    
    function loadOrden(servicio){
        $.post('<?= base_url() ?>Managerbudget/C_Ppto/loadOrdenCosto', {servicio: servicio,tipo:<?= $tipo ?>}, function (data) {
            var option = '<option value="" total="0">. . .</option>';
            
            $.each(data.ordenes, function (e, i) {
                var total = i.ordcos_valor - i.ordcos_vlrcobrado;
                option += '<option value="' + i.ordcos_id + '" total="'+total+'">' + i.ordcos_id + ' - ' + i.nombre + '</option>';
            });
            $('#ordcos_id').html(option);
        }, 'json');
    }
    
    function lock(id_estado){
        if(id_estado != '1'){
            $('.form-control').attr('disabled','disabled');
            $('#save ,#add-detail ,#add-oc').hide();
            $('.btn-danger ,.btn-info').attr('disabled','disabled').removeAttr('onclick');
        }
    }
    
    function changeOrder(select){
        var total = $('#ordcos_id option:selected ').attr('total');
        $('#dprode_valor').autoNumeric('set', total);
        
        if($('#ordcos_id').val() != ''){
            $.post('<?= base_url() ?>Managerbudget/C_Ppto/GetDetailOrdCosto',{orden:$('#ordcos_id').val()},function(data){
                var txt = '';
                $.each(data,function(e,i){
                    txt += i.dordcos_detalle+'\n';
                });
                $('#dprode_detalle').val(txt);
            },'json');
        }else{
            $('#edit_dpsin_detalle').val('');
        }
    }
    
    function OpenDetail(id_detalle){
        $('#form-detail')[0].reset();
        $('#div-orden').hide();
        $.post('<?= base_url() ?>Managerbudget/C_Ppto/GetRowDetailppto',{table:'det_prode',field:'dprode_id',id_detalle:id_detalle},function(data){
           
            $('#dprode_detalle').val(data.dprode_detalle);
            $('#unidad').val(data.unidad);
            $('#detinterna').val(data.tpsv_id);
            
            $('#dprode_valor').autoNumeric('set', data.dprode_valor);
            
            $('#div-orden').hide();
            $('#btn-create').hide();
            $('#btn-update').show();
            $('#btn-update').attr('onclick','UpdateDetail('+id_detalle+')');
            $('#modal-update').modal();
            
        },'json');
    }

    function CalcularTotal() {
        var porcDescuento = ($('#psex_desc').val() == '') ? 0 : $('#psex_desc').val().replace(/\./g, '').replace(/,/g, '.');
        var PorcIva = ($('#psex_iva').val() == '') ? 0 : $('#psex_iva').val().replace(/\./g, '').replace(/,/g, '.');
        var PorcSpa = ($('#psex_spa').val() == '') ? 0 : $('#psex_spa').val().replace(/\./g, '').replace(/,/g, '.');
        var PorcIvaSpa = ($('#psex_ivaspa').val() == '') ? 0 : $('#psex_ivaspa').val().replace(/\./g, '').replace(/,/g, '.');
        var valBruto = $('#psex_valor').val().replace(/\./g, '').replace(/,/g, '.');
        
        var descuento = valBruto * (porcDescuento / 100);
        
        var subtotal = parseFloat(valBruto - descuento);
        
        var iva = parseFloat((valBruto - descuento) * (PorcIva / 100));
        var total_spa = parseFloat(subtotal * (PorcSpa / 100));
        var iva_spa = parseFloat(total_spa * (PorcIvaSpa / 100));

        $('#psex_valordesc').autoNumeric('set', descuento);
        $('#psex_valoriva').autoNumeric('set', iva);
        $('#psex_totalspa').autoNumeric('set', total_spa);       
        $('#psex_valorivaspa').autoNumeric('set', iva_spa);       

        var total = parseFloat(subtotal + iva + total_spa + iva_spa);

        $('#psex_total').autoNumeric('set', total);

    }
    
    function AddDetail(){
        if (validatefield('det-required')) {
            var ordcos_id = 0;
            var valor = $('#dprode_valor').val().replace(/\./g, '').replace(/,/g, '.');
            if($('#ordcos_id').is(':visible')){
                ordcos_id = $('#ordcos_id').val();
                if(parseFloat(valor) > parseFloat($('#ordcos_id option:selected ').attr('total'))){
                    swal({title: 'Error!', text: 'El valor debe ser menor o igual a la orden seleccionada', type: 'error'});
                    return false;
                }
            }
            
            var formData = new FormData($('#form-detail')[0]);
            formData.append("psex_id", <?= $id ?>);
            formData.append("tipo", <?= $tipo ?>);
            formData.append("dprode_valor", valor);
            formData.append("dprode_iva", 19);
            formData.append("ordcos_id", ordcos_id);
            
            if(ordcos_id != 0){
                formData.append("ordcos_vlrcobrado", $('#dprode_valor').val().replace(/\./g, '').replace(/,/g, '.'));
            }
            
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
            formData.append("dprode_id", id_detalle);
            formData.append("psex_id", <?= $id ?>);
            formData.append("tipo", <?= $tipo ?>);
            formData.append("dprode_valor", $('#dprode_valor').val().replace(/\./g, '').replace(/,/g, '.'));
            
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
            var psex_desc = ($('#psex_desc').val() == '') ? 0 : $('#psex_desc').val().replace(/\./g, '').replace(/,/g, '.');
            var psex_iva = ($('#psex_iva').val() == '') ? 0 : $('#psex_iva').val().replace(/\./g, '').replace(/,/g, '.');
             var psex_spa = ($('#psex_spa').val() == '') ? 0 : $('#psex_spa').val().replace(/\./g, '').replace(/,/g, '.');
            var psex_ivaspa = ($('#psex_ivaspa').val() == '') ? 0 : $('#psex_ivaspa').val().replace(/\./g, '').replace(/,/g, '.');
            var psex_valor = $('#psex_valor').val().replace(/\./g, '').replace(/,/g, '.');
            var psex_total = $('#psex_total').val().replace(/\./g, '').replace(/,/g, '.');

            var formData = new FormData($('#form')[0]);
            formData.append("ord_id", <?=$orden->ord_id?>);
            formData.append("ppto", <?= $id ?>);
            formData.append("tipo", <?= $tipo ?>);
            formData.append("psex_desc", psex_desc);
            formData.append("psex_iva", psex_iva);
            formData.append("psex_valor", psex_valor);
            formData.append("psex_total", psex_total);
            formData.append("psex_spa", psex_spa);
            formData.append("psex_ivaspa", psex_ivaspa);
            formData.append("total", psex_total);
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
    
    function DeleteDetail(id_detalle,orden,total){
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
                    total:total,
                    id_detalle:id_detalle,
                    ordcos_id:orden,
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

