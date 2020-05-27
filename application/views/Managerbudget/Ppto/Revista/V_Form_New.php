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
            <i class="fa fa-edit"></i>Nuevo Presupuesto Revista
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Medios</a></li>
            <li><a href="<?= base_url() ?>Revista">Listar</a></li>
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
                                        <input type="text" class="form-control input-sm decimals" id="psrev_desc" name="psrev_desc" value="0" placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Iva</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input type="text" class="form-control input-sm decimals" id="psrev_iva" name="psrev_iva" value="19"  placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input type="text" class="form-control input-sm decimals" id="psrev_spa" name="psrev_spa" value="10"  placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Iva Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input readonly type="text" class="form-control input-sm decimals" id="psrev_ivaspa" name="psrev_ivaspa" value="19"  placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Valor</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control input-sm decimals" id="psrev_valor" value="0" placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Descuento</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="psrev_valordesc"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Iva</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="psrev_valoriva"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="psrev_totalspa"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Iva Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="psrev_valorivaspa"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm numerico" id="psrev_total" name="psrev_total" placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="button" class="btn btn-default" onclick="window.location.href = '<?= base_url() ?>Revista'">Cancelar</button>
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
                                                <label>Medio</label>
                                                <select class="form-control input-sm info-required" id="medio_id" name="medio_id">
                                                    <option value="">. . .</option>
                                                    <?php foreach ($medios as $v) : ?>
                                                        <option value="<?= $v->medio_id ?>"  ><?= $v->medio_nombre ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Orden Cliente</label>
                                                <input type="text" class="form-control input-sm" id="psrev_numorden" name="psrev_numorden" value="" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No.Cotización</label>
                                                <input type="text" class="form-control input-sm" id="psrev_numcotizacion" name="psrev_numcotizacion" value="" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Observación</label>
                                                <textarea type="text" class="form-control input-sm" rows="2" id="psrev_observa" name="psrev_observa" ></textarea>
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
                                <label>Titulo</label>
                                <input type="text" class="form-control input-sm det-required "  id="drevis_titulo" name="drevis_titulo" />
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
                                <label>Tinta</label>
                                <select class="form-control input-sm det-required" id="tinta_id" name="tinta_id">
                                    <option value="">. . .</option>
                                    <?php foreach ($tintas as $v) : ?>
                                        <option value="<?= $v->tinta_id ?>" ><?= $v->tinta_nombre ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tamaño</label>
                                <input type="texto" class="form-control input-sm calc det-required "  id="drevis_tamano" name="drevis_tamano"  />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Frecuencia</label>
                                <input type="texto" class="form-control input-sm calc det-required "  id="drevis_frecuencia" name="drevis_frecuencia"  />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Aviso</label>
                                <input type="number" class="form-control input-sm calc det-required "  id="drevis_numavisos" name="drevis_numavisos"  />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Fecha Inserción</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right input-sm " id="drevis_fechinser" name="drevis_fechinser">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Detalle</label>
                                <textarea type="text" class="form-control input-sm " rows="2" id="drevis_detalle" name="drevis_detalle" ></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Posición</label>
                                <input type="texto" class="form-control input-sm calc det-required "  id="drevis_posicion" name="drevis_posicion"  />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tarifa</label>
                                <input type="text" class="form-control input-sm det-required decimals"  id="drevis_tarifa"  />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Valor</label>
                                <input readonly type="text" class="form-control input-sm det-required decimals"  id="drevis_valor"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Total</label>
                                <input readonly type="text" class="form-control input-sm det-required numerico"  id="drevis_total"  />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tipo</label>
                                <select class="form-control input-sm " id="drevis_tpo" name="drevis_tpo">
                                    <option value="0">Publicación</option>
                                    <option value="1">Preventa cuota fija</option>
                                    <option value="2">Preventa consumo</option>
                                </select>
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
        
        $('#drevis_fechinser').datepicker({
            multidate: true,
            format: 'MM dd/yyyy'
        });
        
        CalcularTotal();

        $('#psrev_desc, #psrev_iva, #psrev_valor, #psrev_spa').keyup(function () {
             CalcularTotal();
        });

        $('#drevis_tarifa, #drevis_numavisos').keyup(function () {
            calcularDetalleavisos();
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
    
    function calcularDetalleavisos(){
        
        var valorTarifa = ($('#drevis_tarifa').val() == '') ? 0 : $('#drevis_tarifa').val().replace(/\./g, '').replace(/,/g, '.');
        var numavisos = $('#drevis_numavisos').val();
        var valor = valorTarifa * numavisos;
        
        $('#drevis_valor').autoNumeric('set', valor);
        $('#drevis_total').autoNumeric('set', valor);
        
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
        var porcDescuento = ($('#psrev_desc').val() == '') ? 0 : $('#psrev_desc').val().replace(/\./g, '').replace(/,/g, '.');
        var PorcIva = ($('#psrev_iva').val() == '') ? 0 : $('#psrev_iva').val().replace(/\./g, '').replace(/,/g, '.');
        var PorcSpa = ($('#psrev_spa').val() == '') ? 0 : $('#psrev_spa').val().replace(/\./g, '').replace(/,/g, '.');
        var PorcIvaSpa = ($('#psrev_ivaspa').val() == '') ? 0 : $('#psrev_ivaspa').val().replace(/\./g, '').replace(/,/g, '.');
        var valBruto = $('#psrev_valor').val().replace(/\./g, '').replace(/,/g, '.');
        
        var descuento = valBruto * (porcDescuento / 100);
        
        var subtotal = parseFloat(valBruto - descuento);
        
        var iva = parseFloat((valBruto - descuento) * (PorcIva / 100));
        var total_spa = parseFloat(subtotal * (PorcSpa / 100));
        var iva_spa = parseFloat(total_spa * (PorcIvaSpa / 100));

        $('#psrev_valordesc').autoNumeric('set', descuento);
        $('#psrev_valoriva').autoNumeric('set', iva);
        $('#psrev_totalspa').autoNumeric('set', total_spa);       
        $('#psrev_valorivaspa').autoNumeric('set', iva_spa);       

        var total = parseFloat(subtotal + iva + total_spa + iva_spa);

        $('#psrev_total').autoNumeric('set', total);

    }
    
    function AddDetail(id){
        if (validatefield('det-required')) {
            
            var formData = new FormData($('#form-detail')[0]);
            formData.append("psrev_id", id);
            formData.append("tipo", <?= $tipo ?>);
            formData.append("drevis_tarifa", $('#drevis_tarifa').val().replace(/\./g, '').replace(/,/g, '.'));
            formData.append("drevis_valor", $('#drevis_valor').val().replace(/\./g, '').replace(/,/g, '.'));
            formData.append("drevis_total", $('#drevis_total').val().replace(/\./g, '').replace(/,/g, '.'));
            
            $.ajax({
                url: "<?= base_url() ?>Managerbudget/C_Ppto/AddDetail",
                type: 'POST',
                data: formData,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        if(obj.reverse == ""){
                            swal({title: 'OK!', text: '', type: 'success'});
                            window.location.replace('<?= base_url() ?>Revista/Edit/'+id+'/3');
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
            var psrev_desc = ($('#psrev_desc').val() == '') ? 0 : $('#psrev_desc').val().replace(/\./g, '').replace(/,/g, '.');
            var psrev_iva = ($('#psrev_iva').val() == '') ? 0 : $('#psrev_iva').val().replace(/\./g, '').replace(/,/g, '.');
             var psrev_spa = ($('#psrev_spa').val() == '') ? 0 : $('#psrev_spa').val().replace(/\./g, '').replace(/,/g, '.');
            var psrev_ivaspa = ($('#psrev_ivaspa').val() == '') ? 0 : $('#psrev_ivaspa').val().replace(/\./g, '').replace(/,/g, '.');
            var psrev_valor = $('#psrev_valor').val().replace(/\./g, '').replace(/,/g, '.');
            var psrev_total = $('#psrev_total').val().replace(/\./g, '').replace(/,/g, '.');

            var formData = new FormData($('#form')[0]);
            formData.append("tipo", <?= $tipo ?>);
            formData.append("psrev_desc", psrev_desc);
            formData.append("psrev_iva", psrev_iva);
            formData.append("psrev_valor", psrev_valor);
            formData.append("psrev_total", psrev_total);
            formData.append("psrev_spa", psrev_spa);
            formData.append("psrev_ivaspa", psrev_ivaspa);
            formData.append("psrev_estado", 1);
            formData.append("usr_id_crea", '<?=$this->session->UserMedios?>');
            formData.append("usr_id_mod", '<?=$this->session->UserMedios?>');
            formData.append("psrev_fecha", '<?=date("Y-m-d")?>');
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
                        $('#titulo').html('<i class="fa fa-edit"></i> Revista N°<small>'+obj.id+' Activo - Orden N° '+obj.ord_id+'</small>');
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
            var psrev_desc = ($('#psrev_desc').val() == '') ? 0 : $('#psrev_desc').val().replace(/\./g, '').replace(/,/g, '.');
            var psrev_iva = ($('#psrev_iva').val() == '') ? 0 : $('#psrev_iva').val().replace(/\./g, '').replace(/,/g, '.');
             var psrev_spa = ($('#psrev_spa').val() == '') ? 0 : $('#psrev_spa').val().replace(/\./g, '').replace(/,/g, '.');
            var psrev_ivaspa = ($('#psrev_ivaspa').val() == '') ? 0 : $('#psrev_ivaspa').val().replace(/\./g, '').replace(/,/g, '.');
            var psrev_valor = $('#psrev_valor').val().replace(/\./g, '').replace(/,/g, '.');
            var psrev_total = $('#psrev_total').val().replace(/\./g, '').replace(/,/g, '.');

            var formData = new FormData($('#form')[0]);
            formData.append("ord_id", ord_id);
            formData.append("ppto", id);
            formData.append("tipo", <?= $tipo ?>);
            formData.append("psrev_desc", psrev_desc);
            formData.append("psrev_iva", psrev_iva);
            formData.append("psrev_valor", psrev_valor);
            formData.append("psrev_total", psrev_total);
            formData.append("psrev_spa", psrev_spa);
            formData.append("psrev_ivaspa", psrev_ivaspa);
            formData.append("total", psrev_total);
            
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

