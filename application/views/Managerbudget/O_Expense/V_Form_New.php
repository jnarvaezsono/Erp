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
            <i class="fa fa-edit"></i> ORDEN DE GASTO
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Medios</a></li>
            <li><a href="<?= base_url() ?>Expense">Listar</a></li>
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
                                        <input type="text" class="form-control input-sm decimals" id="ordgas_desc" name="ordgas_desc" value="0" placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Iva</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input type="text" class="form-control input-sm decimals" id="ordgas_iva" name="ordgas_iva" value="19"  placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Valor</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control input-sm decimals" id="ordgas_valor" value="0" placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Descuento</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="ordgas_valordesc"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Iva</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" id="ordgas_valoriva"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm numerico" id="ordgas_total" name="ordgas_total" placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="button" class="btn btn-default btn-sm btn-sm" onclick="window.location.href = '<?= base_url() ?>Expense'">Cancelar</button>
                            <button type="button" class="btn btn-primary btn-sm pull-right" style="margin-left:5px" id="save"><i class="fa fa-save"></i> Guardar</button>
                            <button type="button" class="btn btn-primary btn-sm pull-right" style="margin-left:5px; display:none" id="update"><i class="fa fa-refresh"></i> Actualizar</button>
                            <button type="button" class="btn  btn-default btn-sm pull-right" style="display:none" id="add-detail"><i class="fa fa-plus"></i> Agregar Detalle</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Valores</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <form role="form" id="form" method="POST" enctype="multipart/form-data">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Proveedor</label>
                                        <select class="form-control input-sm info-required" id="pvcl_id" name="pvcl_id">
                                            <option value="">. . .</option>
                                            <?php foreach ($proveedores as $v) : ?>
                                                <option value="<?= $v->id_client ?>" ><?= $v->nombre ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Observación</label>
                                        <textarea type="text" class="form-control input-sm" rows="2" id="ordgas_observa" name="ordgas_observa" ></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <br />
                        <?= $detail ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modal-update">
    <div class="modal-dialog" style="width: 350px;">
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
                            <label>Valor</label>
                            <input type="text" class="form-control input-sm det-required decimals"  id="dordgas_valor" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Detalle</label>
                            <textarea type="text" class="form-control input-sm det-required" rows="2" id="dordgas_detalle" name="dordgas_detalle" ></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary pull-right" id="btn-create" ><i class="fa fa-save"></i> Crear</button>
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
        
        $('.select2').select2();

        CalcularTotal();

        $('#ordgas_desc, #ordgas_iva, #ordgas_valor').keyup(function () {
             CalcularTotal();
        });

        $('#save').click(function () {
            save();
        });

        $('#add-detail').click(function () {
            $('#dordgas_detalle').val('');
            $('#dordgas_valor').autoNumeric('set', 0);
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
        lock('0');
    });
    
    function lock(id_estado){
        if(id_estado != '1' && id_estado != '0'){
            $('.form-control').attr('disabled','disabled');
            $('#save ,#add-detail ').hide();
            $('.btn-danger ,.btn-info , .btn-flat').attr('disabled','disabled').removeAttr('onclick');
        }else if(id_estado == '0'){
            $('#add-detail ').hide();
        }
    }

    function CalcularTotal() {
        var porcDescuento = ($('#ordgas_desc').val() == '') ? 0 : $('#ordgas_desc').val().replace(/\./g, '').replace(/,/g, '.');
        var PorcIva = ($('#ordgas_iva').val() == '') ? 0 : $('#ordgas_iva').val().replace(/\./g, '').replace(/,/g, '.');
        var valBruto = $('#ordgas_valor').val().replace(/\./g, '').replace(/,/g, '.');

        var descuento = valBruto * (porcDescuento / 100);
        var iva = parseFloat((valBruto - descuento) * (PorcIva / 100));


        $('#ordgas_valordesc').autoNumeric('set', descuento);
        $('#ordgas_valoriva').autoNumeric('set', iva);

        var total = parseFloat((valBruto - descuento) + iva);

        $('#ordgas_total').autoNumeric('set', total);

    }
    
    function save() {
        if (validatefield('info-required')) {
            var ordgas_desc = ($('#ordgas_desc').val() == '') ? 0 : $('#ordgas_desc').val().replace(/\./g, '').replace(/,/g, '.');
            var ordgas_iva = ($('#ordgas_iva').val() == '') ? 0 : $('#ordgas_iva').val().replace(/\./g, '').replace(/,/g, '.');
            var ordgas_valor = $('#ordgas_valor').val().replace(/\./g, '').replace(/,/g, '.');
            var ordgas_total = $('#ordgas_total').val().replace(/\./g, '').replace(/,/g, '.');
            
            var formData = new FormData($('#form')[0]);
            formData.append("ordgas_desc", ordgas_desc);
            formData.append("ordgas_iva", ordgas_iva);
            formData.append("ordgas_valor", ordgas_valor);
            formData.append("ordgas_total", ordgas_total);
            formData.append("ordgas_usuariomod", '<?=$this->session->UserMedios?>');
            formData.append("usr_id", '<?=$this->session->UserMedios?>');
            formData.append("ordgas_fecha", '<?=date("Y-m-d")?>');
            $.ajax({
                url: "<?= base_url() ?>Managerbudget/O_Expense/C_Expense/InsertInfo",
                type: 'POST',
                data: formData,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        $('#update').show().attr('onclick','Update('+obj.id+')');
                        $('#save').hide();
                        $('#add-detail ').show();
                        $('#btn-create').attr('onclick','AddDetail('+obj.id+')');
                        $('#titulo').html('<i class="fa fa-edit"></i> ORDEN DE GASTO N°<small>'+obj.id+' Activo</small>');
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
            var ordgas_desc = ($('#ordgas_desc').val() == '') ? 0 : $('#ordgas_desc').val().replace(/\./g, '').replace(/,/g, '.');
            var ordgas_iva = ($('#ordgas_iva').val() == '') ? 0 : $('#ordgas_iva').val().replace(/\./g, '').replace(/,/g, '.');
            var ordgas_valor = $('#ordgas_valor').val().replace(/\./g, '').replace(/,/g, '.');
            var ordgas_total = $('#ordgas_total').val().replace(/\./g, '').replace(/,/g, '.');
            
            
            
            var formData = new FormData($('#form')[0]);
            formData.append("order", id);
            formData.append("ordgas_desc", ordgas_desc);
            formData.append("ordgas_iva", ordgas_iva);
            formData.append("ordgas_valor", ordgas_valor);
            formData.append("ordgas_total", ordgas_total);
            $.ajax({
                url: "<?= base_url() ?>Managerbudget/O_Expense/C_Expense/UpdateInfo",
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
    
    function AddDetail(id){
        if (validatefield('det-required')) {
            var valor = ($('#dordgas_valor').val() == '') ? 0 : $('#dordgas_valor').val().replace(/\./g, '').replace(/,/g, '.');
            $.post('<?= base_url() ?>Managerbudget/O_Expense/C_Expense/AddDetail',{
                ordgas_id:id,
                dordgas_valor:valor,
                dordgas_detalle:$('#dordgas_detalle').val()
            },function(data){
                if(data.res == 'OK'){
                    swal({title: 'OK!', text: '', type: 'success'});
                    window.location.replace('<?= base_url() ?>Expense/Edit/'+id);
                } else {
                    swal({title: 'Error!', text: obj.res, type: 'error'});
                }
            },'json');
        }else {
            alertify.error("DATOS INCOMPLETOS!");
        }
    }
    
</script>

