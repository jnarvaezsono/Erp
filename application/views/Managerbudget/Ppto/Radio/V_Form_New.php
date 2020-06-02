<style>
    .nav-tabs-custom>.nav-tabs>li.active {
        border-top-color: #d2d6de;
    }
    .form-horizontal .control-label {
        text-align: left;
    }
</style>
<?php 
$lista = (!$pre_order)?'Radio':'PreRadio'
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1 id="titulo">
            <i class="fa fa-edit"></i><?=$title?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Medios</a></li>
            <li><a href="<?= base_url($lista) ?>">Listar</a></li>
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
                                        <input type="text" class="form-control input-sm decimals" id="psrad_desc" name="psrad_desc" value="0" placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Iva</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input type="text" class="form-control input-sm decimals" id="psrad_iva" name="psrad_iva" value="19"  placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input type="text" class="form-control input-sm decimals" id="psrad_spa" name="psrad_spa" value="10"  placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Iva Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input readonly type="text" class="form-control input-sm decimals" id="psrad_ivaspa" name="psrad_ivaspa" value="19"  placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Valor</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control input-sm decimals" id="psrad_valor" value="0" placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Descuento</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="psrad_valordesc"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Iva</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="psrad_valoriva"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="psrad_totalspa"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Iva Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="psrad_valorivaspa"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm numerico" id="psrad_total" name="psrad_total" placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="button" class="btn btn-default" onclick="window.location.href = '<?= base_url() ?>Radio'">Cancelar</button>
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
                                                <input type="text" class="form-control input-sm" id="psrad_numorden" name="psrad_numorden" value="" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No.Cotización</label>
                                                <input type="text" class="form-control input-sm" id="psrad_numcotizacion" name="psrad_numcotizacion" value="" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Observación</label>
                                                <textarea type="text" class="form-control input-sm" rows="2" id="psrad_observa" name="psrad_observa" ></textarea>
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Emisora</label>
                                <select class="form-control input-sm det-required" id="emis_id" name="emis_id">
                                    <option value="">. . .</option>
                                    <?php foreach ($emisoras as $v) : ?>
                                        <option value="<?= $v->emis_id ?>" ><?= $v->emis_nombre ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Programa</label>
                                <select class="form-control input-sm det-required" id="progr_id" name="progr_id">
                                    <option value="">. . .</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Ciudad</label>
                                <input type="text" class="form-control input-sm "  id="drad_ciudad" name="drad_ciudad" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Frecuencia</label>
                                <input type="text" class="form-control input-sm "  id="drad_frecuencia" name="drad_frecuencia" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Fecha Inicio</label>
                                <input type="text" class="form-control  input-sm det-required" id="drad_fechaini" name="drad_fechaini">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Fecha Fin</label>
                                <input type="text" class="form-control  input-sm det-required" id="drad_fechafin" name="drad_fechafin">
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
                                <label>Segundos</label>
                                <input type="number" class="form-control input-sm det-required "  id="drad_seg" name="drad_seg" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Dias</label>
                                <input type="number" class="form-control input-sm det-required "  id="drad_dias" name="drad_dias" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>No.Cuña</label>
                                <input type="number" class="form-control input-sm det-required "  id="drad_numcuna" name="drad_numcuna" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Total Cuña</label>
                                <input readonly type="text" class="form-control input-sm det-required"  id="drad_totalcuna" name="drad_totalcuna"  />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tarifa</label>
                                <input type="text" class="form-control input-sm det-required decimals" value="0" id="drad_tarifa" name="drad_tarifa"  />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Global</label>
                                <input type="text" class="form-control input-sm det-required decimals" value="0" id="drad_global" name="drad_global" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Total</label>
                                <input readonly type="text" class="form-control input-sm det-required numerico"  id="drad_total" name="drad_total"  />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Detalle</label>
                                <textarea type="text" class="form-control input-sm " rows="2" id="drad_detalle" name="drad_detalle" ></textarea>
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
        
        $('#drad_fechaini, #drad_fechafin').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
        });
        
        $('#drad_fechaini, #drad_fechafin').datepicker('setDate',today);

        CalcularTotal();

        $('#psrad_desc, #psrad_iva, #psrad_valor, #psrad_spa').keyup(function () {
             CalcularTotal();
        });

        $('#drad_dias, #drad_numcuna, #drad_tarifa, #drad_global').keyup(function () {
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
        lock('0');
    });
    
    function cargarPrograma(id,field,table,value = false){
        $.post('<?= base_url() ?>Managerbudget/C_Ppto/Select', {id: id,field:field,table:table}, function (data) {
            var option = '<option value="">. . .</option>';
            $.each(data.programas, function (e, i) {
                option += '<option value="' + i.progr_id + '">' + i.progr_nombre + '</option>';
            });
            $('#progr_id').html(option);
            if(value){
                $('#progr_id').val(value);
            }
        }, 'json');
    }
    
    function calcularDetalle(){
        
        var valorTari = ($('#drad_tarifa').val() == '') ? 0 : $('#drad_tarifa').val().replace(/\./g, '').replace(/,/g, '.');
        var valorglobal = ($('#drad_global').val() == '') ? 0 : $('#drad_global').val().replace(/\./g, '').replace(/,/g, '.');
        
        if($('#drad_dias').val() == ''){
            $('#drad_dias').val(0);
        }
        
        if($('#drad_dias').val() == ''){
            $('#drad_dias').val(0);
        }
        
        var TotalCuna = ($('#drad_dias').val() * $('#drad_numcuna').val());
        $('#drad_totalcuna').val(TotalCuna);
        
        var total  = parseFloat(valorglobal) + parseFloat(valorTari * TotalCuna);
        
        $('#drad_total').autoNumeric('set', total);
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
        var porcDescuento = ($('#psrad_desc').val() == '') ? 0 : $('#psrad_desc').val().replace(/\./g, '').replace(/,/g, '.');
        var PorcIva = ($('#psrad_iva').val() == '') ? 0 : $('#psrad_iva').val().replace(/\./g, '').replace(/,/g, '.');
        var PorcSpa = ($('#psrad_spa').val() == '') ? 0 : $('#psrad_spa').val().replace(/\./g, '').replace(/,/g, '.');
        var PorcIvaSpa = ($('#psrad_ivaspa').val() == '') ? 0 : $('#psrad_ivaspa').val().replace(/\./g, '').replace(/,/g, '.');
        var valBruto = $('#psrad_valor').val().replace(/\./g, '').replace(/,/g, '.');
        
        var descuento = valBruto * (porcDescuento / 100);
        
        var subtotal = parseFloat(valBruto - descuento);
        
        var iva = parseFloat((valBruto - descuento) * (PorcIva / 100));
        var total_spa = parseFloat(subtotal * (PorcSpa / 100));
        var iva_spa = parseFloat(total_spa * (PorcIvaSpa / 100));

        $('#psrad_valordesc').autoNumeric('set', descuento);
        $('#psrad_valoriva').autoNumeric('set', iva);
        $('#psrad_totalspa').autoNumeric('set', total_spa);       
        $('#psrad_valorivaspa').autoNumeric('set', iva_spa);       

        var total = parseFloat(subtotal + iva + total_spa + iva_spa);

        $('#psrad_total').autoNumeric('set', total);

    }
    
    function AddDetail(id){
        if (validatefield('det-required')) {
            
            var formData = new FormData($('#form-detail')[0]);
            formData.append("psrad_id", id);
            formData.append("tipo", <?= $tipo ?>);
            formData.append("tabla", '<?= $tabla ?>');
            formData.append("drad_tarifa", $('#drad_tarifa').val().replace(/\./g, '').replace(/,/g, '.'));
            formData.append("drad_global", $('#drad_global').val().replace(/\./g, '').replace(/,/g, '.'));
            formData.append("drad_total", $('#drad_total').val().replace(/\./g, '').replace(/,/g, '.'));
            
            <?php if($lista == 'Radio'): ?>
                var controller = "C_Ppto";
                var edit = 'Edit';
            <?php else: ?>
                var controller = "C_Preorden";
                var edit = 'EditOrden';
            <?php endif; ?>
            
            $.ajax({
                url: "<?= base_url() ?>Managerbudget/"+controller+"/AddDetail",
                type: 'POST',
                data: formData,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        if(obj.reverse == ""){
                            swal({title: 'OK!', text: '', type: 'success'});
                            window.location.replace('<?= base_url() ?>Radio/'+edit+'/'+id+'/4');
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
            var psrad_desc = ($('#psrad_desc').val() == '') ? 0 : $('#psrad_desc').val().replace(/\./g, '').replace(/,/g, '.');
            var psrad_iva = ($('#psrad_iva').val() == '') ? 0 : $('#psrad_iva').val().replace(/\./g, '').replace(/,/g, '.');
            var psrad_spa = ($('#psrad_spa').val() == '') ? 0 : $('#psrad_spa').val().replace(/\./g, '').replace(/,/g, '.');
            var psrad_ivaspa = ($('#psrad_ivaspa').val() == '') ? 0 : $('#psrad_ivaspa').val().replace(/\./g, '').replace(/,/g, '.');
            var psrad_valor = $('#psrad_valor').val().replace(/\./g, '').replace(/,/g, '.');
            var psrad_total = $('#psrad_total').val().replace(/\./g, '').replace(/,/g, '.');

            var formData = new FormData($('#form')[0]);
            formData.append("tabla", '<?= $tabla ?>');
            formData.append("tipo", <?= $tipo ?>);
            formData.append("psrad_desc", psrad_desc);
            formData.append("psrad_iva", psrad_iva);
            formData.append("psrad_valor", psrad_valor);
            formData.append("psrad_total", psrad_total);
            formData.append("psrad_spa", psrad_spa);
            formData.append("psrad_ivaspa", psrad_ivaspa);
            formData.append("psrad_estado", 1);
            formData.append("usr_mod", '<?=$this->session->UserMedios?>');
            formData.append("usr_id", '<?=$this->session->UserMedios?>');
            formData.append("psrad_fecha", '<?=date("Y-m-d")?>');
            $.ajax({
                url: "<?= base_url() ?>Managerbudget/C_Ppto/InsertInfoMore",
                type: 'POST',
                data: formData,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        $('#update').show().attr('onclick','Update('+obj.id+','+obj.ord_id+')');
                        $('#save').hide();
                        $('#add-detail ,#add-oc').show();
                        $('#btn-create').attr('onclick','AddDetail('+obj.id+')');
                        
                        <?php if($lista == 'Radio'): ?>
                            var name = "Presupuesto De Radio";
                        <?php else: ?>
                            var name = "Pre Orden De Radio";
                        <?php endif; ?>
                            
                        $('#titulo').html('<i class="fa fa-edit"></i> '+name+' N°<small>'+obj.id+' Activo - Orden N° '+obj.ord_id+'</small>');
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
            var psrad_desc = ($('#psrad_desc').val() == '') ? 0 : $('#psrad_desc').val().replace(/\./g, '').replace(/,/g, '.');
            var psrad_iva = ($('#psrad_iva').val() == '') ? 0 : $('#psrad_iva').val().replace(/\./g, '').replace(/,/g, '.');
            var psrad_spa = ($('#psrad_spa').val() == '') ? 0 : $('#psrad_spa').val().replace(/\./g, '').replace(/,/g, '.');
            var psrad_ivaspa = ($('#psrad_ivaspa').val() == '') ? 0 : $('#psrad_ivaspa').val().replace(/\./g, '').replace(/,/g, '.');
            var psrad_valor = $('#psrad_valor').val().replace(/\./g, '').replace(/,/g, '.');
            var psrad_total = $('#psrad_total').val().replace(/\./g, '').replace(/,/g, '.');

            var formData = new FormData($('#form')[0]);
            formData.append("ppto", id);
            formData.append("ord_id", ord_id);
            formData.append("tipo", <?= $tipo ?>);
            formData.append("tabla", '<?= $tabla ?>');
            formData.append("psrad_desc", psrad_desc);
            formData.append("psrad_iva", psrad_iva);
            formData.append("psrad_valor", psrad_valor);
            formData.append("psrad_total", psrad_total);
            formData.append("psrad_spa", psrad_spa);
            formData.append("psrad_ivaspa", psrad_ivaspa);
            formData.append("total", psrad_total);
            $.ajax({
                url: "<?= base_url() ?>Managerbudget/C_Preorden/UpdateInfo",
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