<style>
    .nav-tabs-custom>.nav-tabs>li.active {
        border-top-color: #d2d6de;
    }
    .form-horizontal .control-label {
        text-align: left;
    }
    .jFiler-items, .jFiler-row {
        width: 400px;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1 id="titulo">
            <i class="fa fa-edit"></i>Nuevo Presupuesto Televisión
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Medios</a></li>
            <li><a href="<?= base_url() ?>Tv">Listar</a></li>
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
                                        <input type="text" class="form-control input-sm decimals" id="pstv_desc" name="pstv_desc" value="0" placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Iva</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input type="text" class="form-control input-sm decimals" id="pstv_iva" name="pstv_iva" value="19"  placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input type="text" class="form-control input-sm decimals" id="pstv_spa" name="pstv_spa" value="10"  placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Iva Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input readonly type="text" class="form-control input-sm decimals" id="pstv_ivaspa" name="pstv_ivaspa" value="19"  placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Valor</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control input-sm decimals" id="pstv_valor" value="0" placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Descuento</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="pstv_valordesc"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Iva</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="pstv_valoriva"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="pstv_totalspa"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Iva Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="pstv_valorivaspa"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm numerico" id="pstv_total" name="pstv_total" placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="button" class="btn btn-default" onclick="window.location.href = '<?= base_url() ?>Tv'">Cancelar</button>
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
                                                        <option value="<?= $v->pdcl_id ?>"><?= $v->pdcl_nombre ?></option>
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
                                                <label>Medio</label>
                                                <select class="form-control input-sm info-required" id="valp_id_medio" name="valp_id_medio">
                                                    <option value="">. . .</option>
                                                    <?php foreach ($medios as $v) : ?>
                                                        <option value="<?= $v->medio_id ?>" ><?= $v->medio_nombre ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Orden Cliente</label>
                                                <input type="text" class="form-control input-sm" id="pstv_numorden" name="pstv_numorden"  />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No.Cotización</label>
                                                <input type="text" class="form-control input-sm" id="pstv_numcotizacion" name="pstv_numcotizacion"  />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Observación</label>
                                                <textarea type="text" class="form-control input-sm" rows="2" id="pstv_observacion_presup" name="pstv_observacion_presup" ></textarea>
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
                        <div class="tab-pane" id="tab_2" style="overflow-y: scroll; height:400px;">
                            <br />
                            <button type="button" class="btn  btn-default btn-sm " id="import-detail" ><i class="fa fa-upload"></i> Importar</button> 
                            <button type="button" class="btn  btn-default btn-sm " id="add-detail"><i class="fa fa-plus"></i> Agregar Detalle</button>
                            <div class="col-md-5">
                                <form role="form" id="form-import" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <input class="" type="file" name="files[]" id="import" >
                                    </div>
                                </form>
                            </div>
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
                                <label>Cliente</label>
                                <input type="text" class="form-control input-sm "  id="dtv_cliente" name="dtv_cliente" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Codigo Comercial</label>
                                <input type="text" class="form-control input-sm "  id="cod_comercial" name="cod_comercial" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Producto</label>
                                <input type="text" class="form-control input-sm "  id="dtv_producto" name="dtv_producto" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Programa</label>
                                <input type="text" class="form-control input-sm det-required"  id="dtv_programa" name="dtv_programa" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Fecha</label>
                                <input type="text" class="form-control  input-sm det-required det-required" id="dtv_fechasalida" name="dtv_fechasalida">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <label>Hora</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control input-sm timepicker det-required" id="dtv_hora" name="dtv_hora">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Duración</label>
                                <input type="text" class="form-control input-sm det-required"  id="dtv_segundo" name="dtv_segundo" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>No. Comerciales</label>
                                <input type="text" class="form-control input-sm det-required"  id="dtv_numcomer" name="dtv_numcomer" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Frecuencia</label>
                                <input type="text" class="form-control input-sm "  id="dtv_frecuencia" name="dtv_frecuencia" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Canal</label>
                                <input type="text" class="form-control input-sm "  id="dtv_canal" name="dtv_canal" />
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
                                <label>Tarifa</label>
                                <input type="text" class="form-control input-sm det-required decimals" value="0" id="dtv_tarifa"  />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Franja</label>
                                <input readonly type="text" class="form-control input-sm "  id="dtv_franja" name="dtv_franja" />
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Referencia</label>
                                <input type="text" class="form-control input-sm "  id="dtv_referencia" name="dtv_referencia" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Global</label>
                                <input type="text" class="form-control input-sm det-required decimals" value="0" id="dtv_global"  />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Total</label>
                                <input readonly type="text" class="form-control input-sm det-required numerico"  id="dtv_total"  />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Detalle</label>
                                <textarea type="text" class="form-control input-sm " rows="2" id="dtv_detalle" name="dtv_detalle" ></textarea>
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
        
        $('#dtv_fechasalida').datepicker({
            multidate: true,
        });
        
        $('#import').filer({
            showThumbs: true,
            addMore: true,
            allowDuplicates: false,
            limit: 1,
            extensions: ["xls", "xlsx"]
        });
        
        $('.timepicker').timepicker({
            showInputs: false,
            showSeconds:true,
            secondStep:1,
            showMeridian:false,
            minuteStep:30
        });
        
        $('#dtv_fechasalida').datepicker('setDate',today);

        CalcularTotal();

        $('#pstv_desc, #pstv_iva, #pstv_valor, #pstv_spa').keyup(function () {
             CalcularTotal();
        });

        $('#dtv_tarifa, #dtv_global, #dtv_numcomer').keyup(function () {
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
        
        $('#dtv_hora').change(function (e) {
            var hora = $(this).val();
            hora = hora+':00';
            var unoDay = "06:00:00";
            var dosDay = "12:00:00";
            var dosEarly = "19:00:00";
            var dosPrime = "22:30:59";
            var unoLate = "23:00:00";

            if ((hora >= unoDay) && (hora < dosDay)) {
                $('#dtv_franja').val("Day");
            } else if ((hora >= dosDay) && (hora < dosEarly)) {
                $('#dtv_franja').val("Early");
            } else if ((hora >= dosEarly) && (hora <= dosPrime)) {
                $('#dtv_franja').val("Prime");
            } else {
                $('#dtv_franja').val("Late");
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
    
    function calcularDetalle(){
        
        var valorTari = ($('#dtv_tarifa').val() == '') ? 0 : $('#dtv_tarifa').val().replace(/\./g, '').replace(/,/g, '.');
        var valorglobal = ($('#dtv_global').val() == '') ? 0 : $('#dtv_global').val().replace(/\./g, '').replace(/,/g, '.');
        
        if($('#dtv_numcomer').val() == ''){
            $('#dtv_numcomer').val(1);
        }
        
        var total  = parseFloat(valorglobal) + parseFloat(valorTari * $('#dtv_numcomer').val());
        
        $('#dtv_total').autoNumeric('set', total);
    }
    
    function lock(id_estado){
        if(id_estado != '1' && id_estado != '0'){
            $('.form-control').attr('disabled','disabled');
            $('#save ,#add-detail ,#add-oc ,#import-detail').hide();
            $('.btn-danger ,.btn-info').attr('disabled','disabled').removeAttr('onclick');
        }else if(id_estado == '0'){
            $('#add-detail, #import-detail').hide();
        }
    }

    function CalcularTotal() {
        var porcDescuento = ($('#pstv_desc').val() == '') ? 0 : $('#pstv_desc').val().replace(/\./g, '').replace(/,/g, '.');
        var PorcIva = ($('#pstv_iva').val() == '') ? 0 : $('#pstv_iva').val().replace(/\./g, '').replace(/,/g, '.');
        var PorcSpa = ($('#pstv_spa').val() == '') ? 0 : $('#pstv_spa').val().replace(/\./g, '').replace(/,/g, '.');
        var PorcIvaSpa = ($('#pstv_ivaspa').val() == '') ? 0 : $('#pstv_ivaspa').val().replace(/\./g, '').replace(/,/g, '.');
        var valBruto = $('#pstv_valor').val().replace(/\./g, '').replace(/,/g, '.');
        
        var descuento = valBruto * (porcDescuento / 100);
        
        var subtotal = parseFloat(valBruto - descuento);
        
        var iva = parseFloat((valBruto - descuento) * (PorcIva / 100));
        var total_spa = parseFloat(subtotal * (PorcSpa / 100));
        var iva_spa = parseFloat(total_spa * (PorcIvaSpa / 100));

        $('#pstv_valordesc').autoNumeric('set', descuento);
        $('#pstv_valoriva').autoNumeric('set', iva);
        $('#pstv_totalspa').autoNumeric('set', total_spa);       
        $('#pstv_valorivaspa').autoNumeric('set', iva_spa);       

        var total = parseFloat(subtotal + iva + total_spa + iva_spa);

        $('#pstv_total').autoNumeric('set', total);

    }
    
    function AddDetail(id){
        if (validatefield('det-required')) {
            
            var formData = new FormData($('#form-detail')[0]);
            formData.append("pstv_id", id);
            formData.append("tipo", <?= $tipo ?>);
            var tarifa = $('#dtv_tarifa').val().replace(/\./g, '').replace(/,/g, '.');
            formData.append("dtv_tarifa", tarifa);
            formData.append("dtv_global", $('#dtv_global').val().replace(/\./g, '').replace(/,/g, '.'));
            formData.append("dtv_total", $('#dtv_total').val().replace(/\./g, '').replace(/,/g, '.'));
            formData.append("dtv_valor", tarifa);
            
            $.ajax({
                url: "<?= base_url() ?>Managerbudget/C_Ppto/AddDetail",
                type: 'POST',
                data: formData,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        if(obj.reverse == ""){
                            swal({title: 'OK!', text: '', type: 'success'});
                        window.location.replace('<?= base_url() ?>Tv/Edit/'+id+'/5');
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
            var pstv_desc = ($('#pstv_desc').val() == '') ? 0 : $('#pstv_desc').val().replace(/\./g, '').replace(/,/g, '.');
            var pstv_iva = ($('#pstv_iva').val() == '') ? 0 : $('#pstv_iva').val().replace(/\./g, '').replace(/,/g, '.');
            var pstv_spa = ($('#pstv_spa').val() == '') ? 0 : $('#pstv_spa').val().replace(/\./g, '').replace(/,/g, '.');
            var pstv_ivaspa = ($('#pstv_ivaspa').val() == '') ? 0 : $('#pstv_ivaspa').val().replace(/\./g, '').replace(/,/g, '.');
            var pstv_valor = $('#pstv_valor').val().replace(/\./g, '').replace(/,/g, '.');
            var pstv_total = $('#pstv_total').val().replace(/\./g, '').replace(/,/g, '.');

            var formData = new FormData($('#form')[0]);
            formData.append("tipo", <?= $tipo ?>);
            formData.append("pstv_desc", pstv_desc);
            formData.append("pstv_iva", pstv_iva);
            formData.append("pstv_valor", pstv_valor);
            formData.append("pstv_total", pstv_total);
            formData.append("pstv_spa", pstv_spa);
            formData.append("pstv_ivaspa", pstv_ivaspa);
            formData.append("usr_id_mod", '<?=$this->session->UserMedios?>');
            formData.append("usr_id_crea", '<?=$this->session->UserMedios?>');
            formData.append("pstv_fecha", '<?=date("Y-m-d")?>');
            $.ajax({
                url: "<?= base_url() ?>Managerbudget/C_Ppto/InsertInfo",
                type: 'POST',
                data: formData,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        $('#update').show().attr('onclick','Update('+obj.id+','+obj.ord_id+')');
                        $('#import-detail').show().attr('onclick','Upexcelfile('+obj.id+','+obj.ord_id+')');
                        $('#save').hide();
                        $('#add-detail, #import-detail').show();
                        $('#btn-create').attr('onclick','AddDetail('+obj.id+')');
                        $('#titulo').html('<i class="fa fa-edit"></i> Televisión N°<small>'+obj.id+' Activo - Orden N° '+obj.ord_id+'</small>');
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
            var pstv_desc = ($('#pstv_desc').val() == '') ? 0 : $('#pstv_desc').val().replace(/\./g, '').replace(/,/g, '.');
            var pstv_iva = ($('#pstv_iva').val() == '') ? 0 : $('#pstv_iva').val().replace(/\./g, '').replace(/,/g, '.');
            var pstv_spa = ($('#pstv_spa').val() == '') ? 0 : $('#pstv_spa').val().replace(/\./g, '').replace(/,/g, '.');
            var pstv_ivaspa = ($('#pstv_ivaspa').val() == '') ? 0 : $('#pstv_ivaspa').val().replace(/\./g, '').replace(/,/g, '.');
            var pstv_valor = $('#pstv_valor').val().replace(/\./g, '').replace(/,/g, '.');
            var pstv_total = $('#pstv_total').val().replace(/\./g, '').replace(/,/g, '.');

            var formData = new FormData($('#form')[0]);
            
            formData.append("ppto", id);
            formData.append("ord_id", ord_id);
            formData.append("tipo", <?= $tipo ?>);
            formData.append("pstv_desc", pstv_desc);
            formData.append("pstv_iva", pstv_iva);
            formData.append("pstv_valor", pstv_valor);
            formData.append("pstv_total", pstv_total);
            formData.append("pstv_spa", pstv_spa);
            formData.append("pstv_ivaspa", pstv_ivaspa);
            formData.append("total", pstv_total);
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
    
    function Upexcelfile(id){
        if($("#import").val() != ''){
            var formData = new FormData($('#form-import')[0]);
            formData.append('ppto',id);
            formData.append('tipo',<?= $tipo ?>);

            $.ajax({
                url: "<?= base_url() ?>Managerbudget/C_Ppto/Upexcelfile",
                type: 'POST',
                data: formData,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        if(obj.opcion[1] == 0){
                            if(obj.opcion[0].length <= 0 ){
                                swal({title: 'Atención!', text: 'El archivo esta vacio', type: 'warning'});
                            }else{
                                var texto ='';
                                $.each(obj.opcion[0],function(e,i){
                                    texto += i+' - ';
                                });
                                swal({title: 'Atención!', text: texto, type: 'warning'});
                            }
                        }else{
                            window.location.replace('<?= base_url() ?>Tv/Edit/'+id+'/5');
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
        }  
    }
</script>

