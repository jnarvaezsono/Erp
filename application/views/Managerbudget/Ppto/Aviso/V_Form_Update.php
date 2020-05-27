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
            <i class="fa fa-edit"></i> Prensa N&deg;
            <small><?= $id ?> <?= $row->estado ?> - Orden N&deg; <?=$orden->ord_id?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Medios</a></li>
            <li><a href="<?= base_url() ?>Prensa">Listar</a></li>
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
                                        <input type="text" class="form-control input-sm decimals" id="psav_desc" name="psav_desc" value="<?= $row->descuento ?>" placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Iva</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input type="text" class="form-control input-sm decimals" id="psav_iva" name="psav_iva" value="<?= $row->iva ?>"  placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input type="text" class="form-control input-sm decimals" id="psav_spa" name="psav_spa" value="<?= $row->spa ?>"  placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Iva Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input readonly type="text" class="form-control input-sm decimals" id="psav_ivaspa" name="psav_ivaspa" value="<?= $row->iva_spa ?>"  placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Valor</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control input-sm decimals" id="psav_valor" value="<?= $row->valor ?>" placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Descuento</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="psav_valordesc"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Iva</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="psav_valoriva"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="psav_totalspa"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Iva Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="psav_valorivaspa"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm numerico" id="psav_total" name="psav_total" placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="button" class="btn btn-default" onclick="window.location.href = '<?= base_url() ?>Prensa'">Cancelar</button>
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
                                                <label>Medio</label>
                                                <select class="form-control input-sm info-required" id="medio_id" name="medio_id">
                                                    <option value="">. . .</option>
                                                    <?php foreach ($medios as $v) : ?>
                                                        <option value="<?= $v->medio_id ?>" <?= ($v->medio_id == $row->medio) ? 'selected' : '' ?> ><?= $v->medio_nombre ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Orden Cliente</label>
                                                <input type="text" class="form-control input-sm" id="psav_numorden" name="psav_numorden" value="<?= $row->orden_cliente ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No.Cotización</label>
                                                <input type="text" class="form-control input-sm" id="psav_numcotizacion" name="psav_numcotizacion" value="<?= $row->cotizacion ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Observación</label>
                                                <textarea type="text" class="form-control input-sm" rows="2" id="psav_observacion" name="psav_observacion" ><?= $row->observacion ?></textarea>
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Titulo</label>
                                <input type="text" class="form-control input-sm det-required "  id="detavi_titulo" name="detavi_titulo" />
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
                                <label>Pagina</label>
                                <select class="form-control input-sm det-required" id="pagina_id" name="pagina_id">
                                    <option value="">. . .</option>
                                    <?php foreach ($paginas as $v) : ?>
                                        <option value="<?= $v->pagina_id ?>" ><?= $v->pagina_nombre ?></option>
                                    <?php endforeach; ?>
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
                                <label>Columnas</label>
                                <input type="number" class="form-control input-sm det-required "  id="detavi_numcolum" name="detavi_numcolum" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Centimetros</label>
                                <input type="number" class="form-control input-sm det-required "  id="detavi_numcentim" name="detavi_numcentim" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>Habilitar pagina</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="checkbox" id="ck">
                                </span>
                                <input type="text" disabled class="form-control input-sm" id="detavi_tamano" name="detavi_tamano">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Posición</label>
                                <input type="text" class="form-control input-sm det-required "  id="detavi_posicion" name="detavi_posicion" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tipo</label>
                                <select class="form-control input-sm det-required" id="detavi_tpo" name="detavi_tpo">
                                    <option value="">. . .</option>
                                    <option value="0">Publicación</option>
                                    <option value="1">Preventa cuota fija</option>
                                    <option value="2">Preventa consumo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Detalle</label>
                                <textarea type="text" class="form-control input-sm " rows="2" id="detavi_detalle" name="detavi_detalle" ></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Dias Publicación</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right input-sm" id="detavi_fechinser" name="detavi_fechinser">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tarifa</label>
                                <input type="text" class="form-control input-sm det-required decimals"  id="detavi_tarifa"  />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Valor Unitario</label>
                                <input readonly type="text" class="form-control input-sm det-required decimals"  id="detavi_valor"/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>No.Publicaciones</label>
                                <input readonly type="number" class="form-control input-sm det-required "  id="detavi_numavisos" name="detavi_numavisos" value="1" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Total</label>
                                <input readonly type="text" class="form-control input-sm det-required numerico"  id="detavi_total"  />
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
        
        $('#detavi_fechinser').datepicker({
            multidate: true,
            format: 'MM dd/yyyy'
        });
        
        $('#detavi_fechinser').change(function(){
            var fechas = $(this).val().split(",");
            var dias = fechas.length;
            $('#detavi_numavisos').val(dias);
            calcularDetalleavisos();
        });


        CalcularTotal();

        $('#psav_desc, #psav_iva, #psav_valor, #psav_spa').keyup(function () {
             CalcularTotal();
        });

        $('#detavi_numcolum, #detavi_numcentim, #detavi_tarifa').keyup(function () {
            calcularDetalleavisos();
        });
        $('#ck').change(function () {
            calcularDetalleavisos();
        });

        $('#dpsav_valor, #dpsav_cant').keyup(function () {
            CalcularTotalDetail();
        });

        $('#edit_valor').keyup(function () {
            CalcularTotalDetailOrder();
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
        lock('<?=$row->id_estado?>');
    });
    
    function calcularDetalleavisos(){
        
        var valorTari = ($('#detavi_tarifa').val() == '') ? 0 : $('#detavi_tarifa').val().replace(/\./g, '').replace(/,/g, '.');
        
        if($('#ck').is(':checked')){
            $('#detavi_tamano').attr('disabled',false);
            $('#detavi_numcentim, #detavi_numcolum').attr('disabled',true).val(0);
            var subTotal = valorTari;
            $('#detavi_valor').autoNumeric('set', subTotal);
        }else{
            $('#detavi_tamano').attr('disabled',true).val('');
            $('#detavi_numcentim, #detavi_numcolum').attr('disabled',false);
            
            var subTotal = valorTari * ($('#detavi_numcolum').val() * $('#detavi_numcentim').val());
            $('#detavi_valor').autoNumeric('set', subTotal);
        }
        
        $('#detavi_total').autoNumeric('set', subTotal * $('#detavi_numavisos').val());
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
        $.post('<?= base_url() ?>Managerbudget/C_Ppto/GetRowDetailppto',{table:'det_avisos',field:'detavi_id',id_detalle:id_detalle},function(data){
           
            $('#detavi_titulo').val(data.detavi_titulo);
            $('#unidad').val(data.unidad);
            $('#pagina_id').val(data.pagina_id);
            $('#tinta_id').val(data.tinta_id);
            $('#detavi_numcolum').val(data.detavi_numcolum);
            $('#detavi_numcentim').val(data.detavi_numcentim);
            
            $('#detavi_posicion').val(data.detavi_posicion);
            $('#detavi_tpo').val(data.detavi_tpo);
            $('#detavi_detalle').val(data.detavi_detalle);
            $('#detavi_numavisos').val(data.detavi_numavisos);
            
            var fechas = data.detavi_fechinser.split(",");
            $('#detavi_fechinser').datepicker('setDate', fechas );
            
            $('#detavi_tarifa').autoNumeric('set', data.detavi_tarifa);
            $('#detavi_valor').autoNumeric('set', data.detavi_valor);
            $('#detavi_total').autoNumeric('set', data.detavi_total);
            
            if(data.detavi_tamano != ''){
                $('#ck').prop('checked',true);
            }else{
                $('#ck').prop('checked',false);
            }
            $('#detavi_tamano').val(data.detavi_tamano);
            calcularDetalleavisos();
            $('#btn-create').hide();
            $('#btn-update').show();
            $('#btn-update').attr('onclick','UpdateDetail('+id_detalle+')');
            $('#modal-update').modal();
            
        },'json');
    }

    function CalcularTotal() {
        var porcDescuento = ($('#psav_desc').val() == '') ? 0 : $('#psav_desc').val().replace(/\./g, '').replace(/,/g, '.');
        var PorcIva = ($('#psav_iva').val() == '') ? 0 : $('#psav_iva').val().replace(/\./g, '').replace(/,/g, '.');
        var PorcSpa = ($('#psav_spa').val() == '') ? 0 : $('#psav_spa').val().replace(/\./g, '').replace(/,/g, '.');
        var PorcIvaSpa = ($('#psav_ivaspa').val() == '') ? 0 : $('#psav_ivaspa').val().replace(/\./g, '').replace(/,/g, '.');
        var valBruto = $('#psav_valor').val().replace(/\./g, '').replace(/,/g, '.');
        
        var descuento = valBruto * (porcDescuento / 100);
        
        var subtotal = parseFloat(valBruto - descuento);
        
        var iva = parseFloat((valBruto - descuento) * (PorcIva / 100));
        var total_spa = parseFloat(subtotal * (PorcSpa / 100));
        var iva_spa = parseFloat(total_spa * (PorcIvaSpa / 100));

        $('#psav_valordesc').autoNumeric('set', descuento);
        $('#psav_valoriva').autoNumeric('set', iva);
        $('#psav_totalspa').autoNumeric('set', total_spa);       
        $('#psav_valorivaspa').autoNumeric('set', iva_spa);       

        var total = parseFloat(subtotal + iva + total_spa + iva_spa);

        $('#psav_total').autoNumeric('set', total);

    }
    
    function AddDetail(){
        if (validatefield('det-required')) {
            
            var formData = new FormData($('#form-detail')[0]);
            formData.append("psav_id", <?= $id ?>);
            formData.append("tipo", <?= $tipo ?>);
            formData.append("detavi_tarifa", $('#detavi_tarifa').val().replace(/\./g, '').replace(/,/g, '.'));
            formData.append("detavi_valor", $('#detavi_valor').val().replace(/\./g, '').replace(/,/g, '.'));
            formData.append("detavi_total", $('#detavi_total').val().replace(/\./g, '').replace(/,/g, '.'));
            
            if($('#ck').is(':checked')){
                formData.append("detavi_numcolum",0);
                formData.append("detavi_numcentim",0);
            }else{
                formData.append("detavi_tamano","");
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
            formData.append("detavi_id", id_detalle);
            formData.append("psav_id", <?= $id ?>);
            formData.append("tipo", <?= $tipo ?>);
            formData.append("detavi_tarifa", $('#detavi_tarifa').val().replace(/\./g, '').replace(/,/g, '.'));
            formData.append("detavi_valor", $('#detavi_valor').val().replace(/\./g, '').replace(/,/g, '.'));
            formData.append("detavi_total", $('#detavi_total').val().replace(/\./g, '').replace(/,/g, '.'));
            
            if($('#ck').is(':checked')){
                formData.append("detavi_numcolum",0);
                formData.append("detavi_numcentim",0);
            }else{
                formData.append("detavi_tamano","");
            }
            
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
            var psav_desc = ($('#psav_desc').val() == '') ? 0 : $('#psav_desc').val().replace(/\./g, '').replace(/,/g, '.');
            var psav_iva = ($('#psav_iva').val() == '') ? 0 : $('#psav_iva').val().replace(/\./g, '').replace(/,/g, '.');
             var psav_spa = ($('#psav_spa').val() == '') ? 0 : $('#psav_spa').val().replace(/\./g, '').replace(/,/g, '.');
            var psav_ivaspa = ($('#psav_ivaspa').val() == '') ? 0 : $('#psav_ivaspa').val().replace(/\./g, '').replace(/,/g, '.');
            var psav_valor = $('#psav_valor').val().replace(/\./g, '').replace(/,/g, '.');
            var psav_total = $('#psav_total').val().replace(/\./g, '').replace(/,/g, '.');

            var formData = new FormData($('#form')[0]);
            formData.append("ord_id", <?=$orden->ord_id?>);
            formData.append("ppto", <?= $id ?>);
            formData.append("tipo", <?= $tipo ?>);
            formData.append("psav_desc", psav_desc);
            formData.append("psav_iva", psav_iva);
            formData.append("psav_valor", psav_valor);
            formData.append("psav_total", psav_total);
            formData.append("psav_spa", psav_spa);
            formData.append("psav_ivaspa", psav_ivaspa);
            formData.append("total", psav_total);
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

