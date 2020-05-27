<style>
    .nav-tabs-custom>.nav-tabs>li.active {
        border-top-color: #d2d6de;
    }
    .form-horizontal .control-label {
        text-align: left;
    }
</style>
<?php 
$lista = (!$pre_order)?'Clasificado':'PreClasificado'
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-edit"></i> <?=$title?>
            <small><?= $id ?> <?= $row->estado ?> - Orden N&deg; <?=$orden->ord_id?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Medios</a></li>
            <li><a href="<?= base_url($lista) ?>">Listar</a></li>
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
                                        <input type="text" class="form-control input-sm decimals" id="pscf_desc" name="pscf_desc" value="<?= $row->descuento ?>" placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Iva</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input type="text" class="form-control input-sm decimals" id="pscf_iva" name="pscf_iva" value="<?= $row->iva ?>"  placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input type="text" class="form-control input-sm decimals" id="pscf_spa" name="pscf_spa" value="<?= $row->spa ?>"  placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Iva Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input readonly type="text" class="form-control input-sm decimals" id="pscf_ivaspa" name="pscf_ivaspa" value="<?= $row->iva_spa ?>"  placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Valor</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control input-sm decimals" id="pscf_valor" value="<?= $row->valor ?>" placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Descuento</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="pscf_valordesc"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Iva</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="pscf_valoriva"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="pscf_totalspa"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Iva Spa</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="pscf_valorivaspa"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm numerico" id="pscf_total" name="pscf_total" placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="button" class="btn btn-default" onclick="window.location.href = '<?= base_url() ?>Clasificado'">Cancelar</button>
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
                        <div class="tab-pane" id="tab_1">
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
                                                <input type="text" class="form-control input-sm" id="pscf_numorden" name="pscf_numorden" value="<?= $row->orden_cliente ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No.Cotización</label>
                                                <input type="text" class="form-control input-sm" id="pscf_numcotizacion" name="pscf_numcotizacion" value="<?= $row->cotizacion ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Observación</label>
                                                <textarea type="text" class="form-control input-sm" rows="2" id="pscf_observacion" name="pscf_observacion" ><?= $row->observacion ?></textarea>
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
                                <label>Sección</label>
                                <input type="text" class="form-control input-sm det-required "  id="dclasi_seccion" name="dclasi_seccion" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Titulo</label>
                                <input type="text" class="form-control input-sm det-required "  id="dclasi_titulo" name="dclasi_titulo" />
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Palabras</label>
                                <input type="number" class="form-control input-sm calc det-required "  id="dclasi_palabras" name="dclasi_palabras" value="0" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Número de avisos</label>
                                <input type="number" class="form-control input-sm calc det-required "  id="dclasi_numavisos" name="dclasi_numavisos" value="1" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>No. Foto</label>
                                <input type="number" class="form-control input-sm calc det-required "  id="dclasi_foto" name="dclasi_foto" value="0" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Valor Foto</label>
                                <input type="number" class="form-control input-sm calc det-required "  id="dclasi_vlrfoto" name="dclasi_vlrfoto" value="0" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Negrilla</label>
                                <input type="number" class="form-control input-sm calc det-required "  id="dclasi_negrilla" name="dclasi_negrilla" value="0" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Valor Negrilla</label>
                                <input type="number" class="form-control input-sm calc det-required "  id="dclasi_vlrnegrilla" name="dclasi_vlrnegrilla" value="0" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Mayuscula</label>
                                <input type="number" class="form-control input-sm calc det-required "  id="dclasi_mayuscula" name="dclasi_mayuscula" value="0" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Valor Mayuscula</label>
                                <input type="number" class="form-control input-sm calc det-required "  id="dclasi_vlrmayuscula" name="dclasi_vlrmayuscula" value="0" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Fondo Color</label>
                                <input type="number" class="form-control input-sm calc det-required "  id="dclasi_fondocolor" name="dclasi_fondocolor" value="0" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Valor Fondo Color</label>
                                <input type="number" class="form-control input-sm calc det-required "  id="dclasi_vlrfondocolor" name="dclasi_vlrfondocolor" value="0" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Logo Grande</label>
                                <input type="number" class="form-control input-sm calc det-required "  id="dclasi_logogr" name="dclasi_logogr" value="0" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Valor Logo Grande</label>
                                <input type="number" class="form-control input-sm calc  det-required"  id="dclasi_vlrlogogr" name="dclasi_vlrlogogr" value="0" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Descripción Logo Grande</label>
                                <input type="texto" class="form-control input-sm   "  id="dclasi_descriplogogr" name="dclasi_descriplogogr"  />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Logo Pequeño</label>
                                <input type="number" class="form-control input-sm calc  det-required"  id="dclasi_logopeq" name="dclasi_logopeq" value="0" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Valor Logo Pequeño</label>
                                <input type="number" class="form-control input-sm calc  det-required"  id="dclasi_vlrlogopeq" name="dclasi_vlrlogopeq" value="0" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Descripción Logo Pequeño</label>
                                <input type="texto" class="form-control input-sm  "  id="dclasi_descriplogopeq" name="dclasi_descriplogopeq"  />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Detalle</label>
                                <textarea type="text" class="form-control input-sm " rows="2" id="dclasi_detalle" name="dclasi_detalle" ></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Dias Publicación</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right input-sm" id="dclasi_fechas" name="dclasi_fechas" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tarifa</label>
                                <input type="text" class="form-control input-sm det-required decimals"  id="dclasi_tarifa"  />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Valor</label>
                                <input readonly type="text" class="form-control input-sm det-required decimals"  id="dclasi_valor"/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>No.Publicaciones</label>
                                <input readonly type="number" class="form-control input-sm det-required "  id="dclasi_publi" name="dclasi_publi" value="1" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Total</label>
                                <input readonly type="text" class="form-control input-sm det-required numerico"  id="dclasi_total"  />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-default pull-right" id="btn-create" onclick="AddDetail()"><i class="fa fa-save"></i> Crear</button>
                <button type="button" class="btn btn-default pull-right" id="btn-update" ><i class="fa fa-refresh"></i> Actualizar</button>
                <button type="button" class="btn btn-info pull-right" onclick="CleanForm();"><i class="fa fa-recycle"></i> Limpiar</button>
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
        
        $('#dclasi_fechas').datepicker({
            multidate: true,
            format: 'MM dd/yyyy'
        });
        
        $('#dclasi_fechas').change(function(){
            var fechas = $(this).val().split(",");
            var dias = fechas.length;
            $('#dclasi_publi').val(dias);
            calcularDetalleavisos();
        });


        CalcularTotal();

        $('#pscf_desc, #pscf_iva, #pscf_valor, #pscf_spa').keyup(function () {
             CalcularTotal();
        });

        $('.calc, #dclasi_tarifa').keyup(function () {
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
        lock('<?=$row->id_estado?>');
    });
    
    function calcularDetalleavisos(){
        
        var valorTarifa = ($('#dclasi_tarifa').val() == '') ? 0 : $('#dclasi_tarifa').val().replace(/\./g, '').replace(/,/g, '.');
       
        var valorfoto = $('#dclasi_vlrfoto').val() * $('#dclasi_publi').val();
        var valornegrita = $('#dclasi_vlrnegrilla').val() * $('#dclasi_publi').val();
        var valormayuscula = $('#dclasi_vlrmayuscula').val() * $('#dclasi_publi').val();
        var valorfondocolor = $('#dclasi_vlrfondocolor').val() * $('#dclasi_publi').val();
        var valorlogogr = $('#dclasi_vlrlogogr').val() * $('#dclasi_publi').val();
        var valorlogopeq = $('#dclasi_vlrlogopeq').val() * $('#dclasi_publi').val();
        var valor = (valorTarifa * $('#dclasi_palabras').val() * $('#dclasi_publi').val());
        var total = valorfoto + valornegrita + valormayuscula + valorfondocolor + valorlogogr + valorlogopeq + valor;
        
        $('#dclasi_valor').autoNumeric('set', valor);
        $('#dclasi_total').autoNumeric('set', total);
        
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
        $.post('<?= base_url() ?>Managerbudget/C_Ppto/GetRowDetailppto',{table:'det_clasi',field:'dclasi_id',id_detalle:id_detalle},function(data){
           
            $('#dclasi_seccion').val(data.dclasi_seccion);
            $('#unidad').val(data.unidad);
            $('#dclasi_titulo').val(data.dclasi_titulo);
            $('#dclasi_palabras').val(data.dclasi_palabras);
            $('#dclasi_numavisos').val(data.dclasi_numavisos);
            $('#dclasi_foto').val(data.dclasi_foto);
            $('#dclasi_vlrfoto').val(data.dclasi_vlrfoto);
            $('#dclasi_negrilla').val(data.dclasi_negrilla);
            $('#dclasi_vlrnegrilla').val(data.dclasi_vlrnegrilla);
            $('#dclasi_mayuscula').val(data.dclasi_mayuscula);
            $('#dclasi_vlrmayuscula').val(data.dclasi_vlrmayuscula);
            $('#dclasi_fondocolor').val(data.dclasi_fondocolor);
            $('#dclasi_vlrfondocolor').val(data.dclasi_vlrfondocolor);
            $('#dclasi_logogr').val(data.dclasi_logogr);
            $('#dclasi_vlrlogogr').val(data.dclasi_vlrlogogr);
            $('#dclasi_descriplogogr').val(data.dclasi_descriplogogr);
            $('#dclasi_logopeq').val(data.dclasi_logopeq);
            $('#dclasi_vlrlogopeq').val(data.dclasi_vlrlogopeq);
            $('#dclasi_descriplogopeq').val(data.dclasi_descriplogopeq);
            $('#dclasi_detalle').val(data.dclasi_detalle);
            $('#dclasi_publi').val(data.dclasi_publi);
            
            var fechas = data.dclasi_fechas.split(",");
            $('#dclasi_fechas').datepicker('setDate', fechas );
            
            $('#dclasi_tarifa').autoNumeric('set', data.dclasi_tarifa);
            $('#dclasi_valor').autoNumeric('set', data.dclasi_valor);
            $('#dclasi_total').autoNumeric('set', data.dclasi_total);
            
            
            calcularDetalleavisos();
            $('#btn-create').hide();
            $('#btn-update').show();
            $('#btn-update').attr('onclick','UpdateDetail('+id_detalle+')');
            $('#modal-update').modal();
            
        },'json');
    }
    
    function CleanForm(){
        $('#form-detail')[0].reset();
        $('#dclasi_fechas').datepicker('setDate', '' );
    }

    function CalcularTotal() {
        var porcDescuento = ($('#pscf_desc').val() == '') ? 0 : $('#pscf_desc').val().replace(/\./g, '').replace(/,/g, '.');
        var PorcIva = ($('#pscf_iva').val() == '') ? 0 : $('#pscf_iva').val().replace(/\./g, '').replace(/,/g, '.');
        var PorcSpa = ($('#pscf_spa').val() == '') ? 0 : $('#pscf_spa').val().replace(/\./g, '').replace(/,/g, '.');
        var PorcIvaSpa = ($('#pscf_ivaspa').val() == '') ? 0 : $('#pscf_ivaspa').val().replace(/\./g, '').replace(/,/g, '.');
        var valBruto = $('#pscf_valor').val().replace(/\./g, '').replace(/,/g, '.');
        
        var descuento = valBruto * (porcDescuento / 100);
        
        var subtotal = parseFloat(valBruto - descuento);
        
        var iva = parseFloat((valBruto - descuento) * (PorcIva / 100));
        var total_spa = parseFloat(subtotal * (PorcSpa / 100));
        var iva_spa = parseFloat(total_spa * (PorcIvaSpa / 100));

        $('#pscf_valordesc').autoNumeric('set', descuento);
        $('#pscf_valoriva').autoNumeric('set', iva);
        $('#pscf_totalspa').autoNumeric('set', total_spa);       
        $('#pscf_valorivaspa').autoNumeric('set', iva_spa);       

        var total = parseFloat(subtotal + iva + total_spa + iva_spa);

        $('#pscf_total').autoNumeric('set', total);

    }
    
    function AddDetail(){
        if (validatefield('det-required')) {
            
            var formData = new FormData($('#form-detail')[0]);
            formData.append("pscf_id", <?= $id ?>);
            formData.append("tipo", <?= $tipo ?>);
            formData.append("tabla", '<?= $tabla ?>');
            formData.append("dclasi_tarifa", $('#dclasi_tarifa').val().replace(/\./g, '').replace(/,/g, '.'));
            formData.append("dclasi_valor", $('#dclasi_valor').val().replace(/\./g, '').replace(/,/g, '.'));
            formData.append("dclasi_total", $('#dclasi_total').val().replace(/\./g, '').replace(/,/g, '.'));
            
            <?php if($lista == 'Clasificado'): ?>
                var controller = "C_Ppto";
            <?php else: ?>
                var controller = "C_Preorden";
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
            formData.append("dclasi_id", id_detalle);
            formData.append("pscf_id", <?= $id ?>);
            formData.append("tipo", <?= $tipo ?>);
            formData.append("tabla", '<?= $tabla ?>');
            formData.append("dclasi_tarifa", $('#dclasi_tarifa').val().replace(/\./g, '').replace(/,/g, '.'));
            formData.append("dclasi_valor", $('#dclasi_valor').val().replace(/\./g, '').replace(/,/g, '.'));
            formData.append("dclasi_total", $('#dclasi_total').val().replace(/\./g, '').replace(/,/g, '.'));
            
            <?php if($lista == 'Clasificado'): ?>
                var controller = "C_Ppto";
            <?php else: ?>
                var controller = "C_Preorden";
            <?php endif; ?>
            
            $.ajax({
                url: "<?= base_url() ?>Managerbudget/"+controller+"/UpdateDetail",
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
            var pscf_desc = ($('#pscf_desc').val() == '') ? 0 : $('#pscf_desc').val().replace(/\./g, '').replace(/,/g, '.');
            var pscf_iva = ($('#pscf_iva').val() == '') ? 0 : $('#pscf_iva').val().replace(/\./g, '').replace(/,/g, '.');
             var pscf_spa = ($('#pscf_spa').val() == '') ? 0 : $('#pscf_spa').val().replace(/\./g, '').replace(/,/g, '.');
            var pscf_ivaspa = ($('#pscf_ivaspa').val() == '') ? 0 : $('#pscf_ivaspa').val().replace(/\./g, '').replace(/,/g, '.');
            var pscf_valor = $('#pscf_valor').val().replace(/\./g, '').replace(/,/g, '.');
            var pscf_total = $('#pscf_total').val().replace(/\./g, '').replace(/,/g, '.');

            var formData = new FormData($('#form')[0]);
            formData.append("ord_id", <?=$orden->ord_id?>);
            formData.append("ppto", <?= $id ?>);
            formData.append("tipo", <?= $tipo ?>);
            formData.append("tabla", '<?= $tabla ?>');
            formData.append("pscf_desc", pscf_desc);
            formData.append("pscf_iva", pscf_iva);
            formData.append("pscf_valor", pscf_valor);
            formData.append("pscf_total", pscf_total);
            formData.append("pscf_spa", pscf_spa);
            formData.append("pscf_ivaspa", pscf_ivaspa);
            formData.append("total", pscf_total);
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
        <?php if($lista == 'Clasificado'): ?>
            var controller = "C_Ppto";
        <?php else: ?>
            var controller = "C_Preorden";
        <?php endif; ?>
    
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
                $.post('<?= base_url() ?>Managerbudget/'+controller+'/DeleteDetail',{
                    id_detalle:id_detalle,
                    ppto:<?= $id ?>,
                    tipo:<?= $tipo ?>,
                    tabla: '<?= $tabla ?>'
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

