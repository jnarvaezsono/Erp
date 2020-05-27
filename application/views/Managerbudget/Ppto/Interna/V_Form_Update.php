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
            <i class="fa fa-edit"></i> Interna N&deg;
            <small><?= $id ?> <?= $row->estado ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Medios</a></li>
            <li><a href="<?= base_url() ?>Interna">Listar</a></li>
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
                                        <input type="text" class="form-control input-sm decimals" id="psin_desc" name="psin_desc" value="<?= $row->descuento ?>" placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Iva</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input type="text" class="form-control input-sm decimals" id="psin_iva" name="psin_iva" value="<?= $row->iva ?>"  placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Valor</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control input-sm decimals" id="psin_valor" value="<?= $row->valor ?>" placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Descuento</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="psin_valordesc"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Iva</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="psin_valoriva"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm numerico" id="psin_total" name="psin_total" placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="button" class="btn btn-default" onclick="window.location.href = '<?= base_url() ?>Interna'">Cancelar</button>
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
<!--                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                Dropdown <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
                                <li role="presentation" class="divider"></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
                            </ul>
                        </li>-->
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
                                                <select class="form-control input-sm info-required" id="cod_ser" name="cod_ser">
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
                                                <input type="text" class="form-control input-sm" id="psin_numorden" name="psin_numorden" value="<?= $row->orden_cliente ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No.Cotización</label>
                                                <input type="text" class="form-control input-sm" id="psin_numcotizacion" name="psin_numcotizacion" value="<?= $row->cotizacion ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Observación</label>
                                                <textarea type="text" class="form-control input-sm" rows="2" id="psin_observa" name="psin_observa" ><?= $row->observacion ?></textarea>
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
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Detalle</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Servicio</label>
                            <select class="form-control input-sm det-required" id="tpsv_id" name="tpsv_id">
                                <option value="">. . .</option>
                                <?php foreach ($servicios as $v) : ?>
                                    <option value="<?= $v->id_tipo_servicio ?>"><?= $v->nombre ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
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
                            <label>Detalle</label>
                            <textarea type="text" class="form-control input-sm det-required" rows="2" id="dpsin_detalle" name="dpsin_detalle" ></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Cantidad</label>
                            <input type="number" class="form-control input-sm det-required "  id="dpsin_cant" name="dpsin_cant" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Valor</label>
                            <input type="text" class="form-control input-sm det-required decimals"  id="dpsin_valor" name="dpsin_valor" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Total</label>
                            <input readonly type="text" class="form-control input-sm det-required numerico"  id="dpsin_total" name="dpsin_total" />
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

<div class="modal fade" id="modal-oc">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nuevo Detalle</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Orden Costo</label>
                            <select class="form-control input-sm e-det-required" id="ordcos_id" name="ordcos_id" onchange="changeOrder(this)">
                                <option value="" total="0">. . .</option>
                                <?php foreach ($ordenes as $v) : ?>
                                    <option value="<?= $v->ordcos_id ?>" total="<?= $v->ordcos_valor - $v->ordcos_vlrcobrado ?>"><?= $v->ordcos_id ?> - <?= $v->nombre ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Total Faltante</label>
                            <input readonly type="text" class="form-control input-sm e-det-required numerico"  id="edit_total" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Servicio</label>
                            <select class="form-control input-sm e-det-required" id="edit_tpsv_id" name="tpsv_id">
                                <option value="">. . .</option>
                                <?php foreach ($servicios as $v) : ?>
                                    <option value="<?= $v->id_tipo_servicio ?>"><?= $v->nombre ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Unidad</label>
                            <select class="form-control input-sm e-det-required" id="edit_unidad" name="unidad">
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
                            <label>Detalle</label>
                            <textarea type="text" class="form-control input-sm e-det-required" rows="2" id="edit_dpsin_detalle" name="dpsin_detalle" ></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Valor</label>
                            <input  type="text" class="form-control input-sm e-det-required numerico"  id="edit_valor" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Incremento</label>
                            <input type="number" class="form-control input-sm e-det-required "  value="20" id="edit_dpsin_valor" name="dpsin_valor" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Total</label>
                            <input readonly type="text" class="form-control input-sm e-det-required numerico"  id="edit_dpsin_total" name="dpsin_total" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary pull-right" id="btn-create-orden" onclick="AddDetailOrden()"><i class="fa fa-save"></i> Crear</button>
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

        $('#psin_desc, #psin_iva, #psin_valor').keyup(function () {
             CalcularTotal();
        });

        $('#dpsin_valor, #dpsin_cant').keyup(function () {
            CalcularTotalDetail();
        });

        $('#edit_valor').keyup(function () {
            CalcularTotalDetailOrder();
        });

        $('#edit_dpsin_valor').change(function () {
            CalcularTotalDetailOrder();
        });

        $('#save').click(function () {
            save();
        });

        $('#add-detail').click(function () {
            $('#btn-create').show();
            $('#btn-update').hide();
            $('#modal-update').modal();
        });

        $('#add-oc').click(function () {
            
            $('#modal-oc').modal();
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
    
    function lock(id_estado){
        if(id_estado != '1'){
            $('.form-control').attr('disabled','disabled');
            $('#save ,#add-detail ,#add-oc').hide();
            $('.btn-danger ,.btn-info').attr('disabled','disabled').removeAttr('onclick');
        }
    }
    
    function OpenDetail(id_detalle){
        $.post('<?= base_url() ?>Managerbudget/C_Ppto/GetRowDetailppto',{table:'det_prodi',field:'dpsin_id',id_detalle:id_detalle},function(data){
            $('#tpsv_id').val(data.tpsv_id);
            $('#unidad').val(data.unidad);
            $('#dpsin_detalle').val(data.dpsin_detalle);
            $('#dpsin_cant').val(data.dpsin_cant);
            $('#dpsin_valor').val(data.dpsin_valor);
            
            $('#dpsin_total').autoNumeric('set', data.dpsin_total);
            $('#dpsin_valor').autoNumeric('set', data.dpsin_valor);
            $('#btn-create').hide();
            $('#btn-update').show();
            $('#btn-update').attr('onclick','UpdateDetail('+id_detalle+')');
            $('#modal-update').modal();
            
        },'json');
    }
    
    function changeOrder(select){
        var total = $('#ordcos_id option:selected ').attr('total');
        $('#edit_total, #edit_valor').autoNumeric('set', total);
        CalcularTotalDetailOrder();
        if($('#ordcos_id').val() != ''){
            $.post('<?= base_url() ?>Managerbudget/C_Ppto/GetDetailOrdCosto',{orden:$('#ordcos_id').val()},function(data){
                var txt = '';
                $.each(data,function(e,i){
                    txt += i.dordcos_detalle+'\n';
                });
                $('#edit_dpsin_detalle').val(txt);
            },'json');
        }else{
            $('#edit_dpsin_detalle').val('');
        }
    }
    
    function CalcularTotalDetailOrder(){
        if($('#edit_dpsin_valor').val() == '' || $('#edit_dpsin_valor').val() < 15){
            $('#edit_dpsin_valor').val(15);
        }
        
        var valor = ($('#edit_valor').val() == '') ? 0 : $('#edit_valor').val().replace(/\./g, '').replace(/,/g, '.');
        var porc = valor * ($('#edit_dpsin_valor').val() / 100);
        var total = parseFloat(valor) + parseFloat(porc);
        
        $('#edit_dpsin_total').autoNumeric('set', total);
    }
    
    function CalcularTotalDetail(){
        var valor = ($('#dpsin_valor').val() == '') ? 0 : $('#dpsin_valor').val().replace(/\./g, '').replace(/,/g, '.');
        var cantidad = $('#dpsin_cant').val();
        
        var total = parseFloat(valor * cantidad);
        
        $('#dpsin_total').autoNumeric('set', total);
    }

    function CalcularTotal() {
        var porcDescuento = ($('#psin_desc').val() == '') ? 0 : $('#psin_desc').val().replace(/\./g, '').replace(/,/g, '.');
        var PorcIva = ($('#psin_iva').val() == '') ? 0 : $('#psin_iva').val().replace(/\./g, '').replace(/,/g, '.');
        var valBruto = $('#psin_valor').val().replace(/\./g, '').replace(/,/g, '.');

        var descuento = valBruto * (porcDescuento / 100);
        var iva = parseFloat((valBruto - descuento) * (PorcIva / 100));


        $('#psin_valordesc').autoNumeric('set', descuento);
        $('#psin_valoriva').autoNumeric('set', iva);

        var total = parseFloat((valBruto - descuento) + iva);

        $('#psin_total').autoNumeric('set', total);

    }
    
    function AddDetailOrden(){
        if (validatefield('e-det-required')) {
            var total = $('#edit_dpsin_total').val().replace(/\./g, '').replace(/,/g, '.');
            var valorCosto = $('#edit_valor').val().replace(/\./g, '').replace(/,/g, '.');
            $.post('<?= base_url() ?>Managerbudget/C_Ppto/AddDetail',{
                psin_id:<?= $id ?>,
                tipo:<?= $tipo ?>,
                dpsin_valor:total,
                dpsin_total:total,
                ordcos_vlrcobrado:valorCosto,
                tpsv_id:$('#edit_tpsv_id').val(),
                unidad:$('#edit_unidad').val(),
                dpsin_detalle:$('#edit_dpsin_detalle').val(),
                dpsin_cant:1,
                ordcos_id:$('#ordcos_id').val(),
                dpsin_ordaumento:$('#edit_dpsin_valor').val(),
            },function(data){
                if(data.res == 'OK'){
                    swal({title: 'OK!', text: '', type: 'success'});
                    location.reload();
                } else {
                    swal({title: 'Error!', text: obj.res, type: 'error'});
                }
            },'json');
        }else {
            alertify.error("DATOS INCOMPLETOS!");
        }
    }
    
    function AddDetail(){
        if (validatefield('det-required')) {
            
            var valor = ($('#dpsin_valor').val() == '') ? 0 : $('#dpsin_valor').val().replace(/\./g, '').replace(/,/g, '.');
            var total = $('#dpsin_total').val().replace(/\./g, '').replace(/,/g, '.');
            $.post('<?= base_url() ?>Managerbudget/C_Ppto/AddDetail',{
                psin_id:<?= $id ?>,
                tipo:<?= $tipo ?>,
                dpsin_valor:valor,
                dpsin_total:total,
                tpsv_id:$('#tpsv_id').val(),
                unidad:$('#unidad').val(),
                dpsin_detalle:$('#dpsin_detalle').val(),
                dpsin_cant:$('#dpsin_cant').val(),
                ordcos_id:0,
                dpsin_ordaumento:0,
            },function(data){
                if(data.res == 'OK'){
                    if(data.reverse == ''){
                        swal({title: 'OK!', text: '', type: 'success'});
                        location.reload();
                    }else{
                        swal({title: 'Warning!', text: data.msg , type: 'error'});
                    }
                } else {
                    swal({title: 'Error!', text: obj.res, type: 'error'});
                }
            },'json');
        }else {
            alertify.error("DATOS INCOMPLETOS!");
        }
    }
    
    function UpdateDetail(id_detalle){
        if (validatefield('det-required')) {
            
            var valor = ($('#dpsin_valor').val() == '') ? 0 : $('#dpsin_valor').val().replace(/\./g, '').replace(/,/g, '.');
            var total = $('#dpsin_total').val().replace(/\./g, '').replace(/,/g, '.');
            $.post('<?= base_url() ?>Managerbudget/C_Ppto/UpdateDetail',{
                dpsin_id:id_detalle,
                psin_id:<?= $id ?>,
                tipo:<?= $tipo ?>,
                dpsin_valor:valor,
                dpsin_total:total,
                tpsv_id:$('#tpsv_id').val(),
                unidad:$('#unidad').val(),
                dpsin_detalle:$('#dpsin_detalle').val(),
                dpsin_cant:$('#dpsin_cant').val()
            },function(data){
                if(data.res == 'OK'){
                    if(data.reverse == ''){
                        swal({title: 'OK!', text: '', type: 'success'});
                        location.reload();
                    }else{
                        swal({title: 'Warning!', text: data.msg , type: 'error'});
                    }
                } else {
                    swal({title: 'Error!', text: obj.res, type: 'error'});
                }
            },'json');
        }else {
            alertify.error("DATOS INCOMPLETOS!");
        }
    }

    function save() {
        if (validatefield('info-required')) {
            var psin_desc = ($('#psin_desc').val() == '') ? 0 : $('#psin_desc').val().replace(/\./g, '').replace(/,/g, '.');
            var psin_iva = ($('#psin_iva').val() == '') ? 0 : $('#psin_iva').val().replace(/\./g, '').replace(/,/g, '.');
            var psin_valor = $('#psin_valor').val().replace(/\./g, '').replace(/,/g, '.');
            var psin_total = $('#psin_total').val().replace(/\./g, '').replace(/,/g, '.');

            var formData = new FormData($('#form')[0]);
            formData.append("ppto", <?= $id ?>);
            formData.append("tipo", <?= $tipo ?>);
            formData.append("psin_desc", psin_desc);
            formData.append("psin_iva", psin_iva);
            formData.append("psin_valor", psin_valor);
            formData.append("psin_total", psin_total);
            formData.append("total", psin_total);
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

