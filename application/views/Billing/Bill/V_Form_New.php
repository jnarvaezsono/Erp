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
        <h1 id="title">
            <i class="fa fa-edit"></i> Nueva Factura
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Medios</a></li>
            <li><a href="<?= base_url() ?>Billing">Listar</a></li>
            <li class="active">Crear</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Valores</h3>
                    </div>
                    <form class="form-horizontal">
                        <div class="box-body">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Valor</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control input-sm decimals" style="width: 90%;" id="valor" value="0" placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Total Descuento</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" style="width: 90%;" id="valordesc" value="0"  placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Total Iva</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" style="width: 90%;" id="valoriva" value="0"   placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Total Spa</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" style="width: 90%;" id="totalspa"  value="0" placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Total Iva Spa</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm no-send numerico" style="width: 90%;" id="valorivaspa" value="0" placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Total Factura</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">$.</span>
                                        <input readonly type="text" class="form-control  input-sm numerico" style="width: 90%;" id="total" name="total" value="0" placeholder="$ 0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="button" class="btn btn-default btn-sm" onclick="window.location.href = '<?= base_url() ?>Billing'">Cancelar</button>
                            <button type="button" class="btn btn-primary  btn-sm" id="save"><i class="fa fa-save"></i> Guardar</button>
                            <button type="button" class="btn btn-primary btn-sm " style="display:none" id="update"><i class="fa fa-refresh"></i> Actualizar</button>
                            <?php if(isset($BtnAproveBill)): ?><button type="button" style="display:none" class="btn btn-success btn-sm" id="btn-Aprobar"><i class="fa fa-check"></i> Facturar</button><?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs nav-default">
                        <li class="active"><a href="#tab_1" data-toggle="tab">Info</a></li>
                        <li><a href="#tab_2" data-toggle="tab">Detalle</a></li>
                        <li><a href="#tab_3" data-toggle="tab">Adjuntos</a></li>
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
                                                <select class="form-control input-sm info-required" id="pvcl_id" name="pvcl_id">
                                                    <option value="">. . .</option>
                                                    <?php foreach ($clientes as $v) : ?>
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
                                                <label>Fecha Generación</label>
                                                <input readonly type="text" class="form-control  input-sm info-required"  id="factura_fechagen" name="factura_fechagen" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Fecha Impresión</label>
                                                <input readonly type="text" class="form-control  input-sm info-required"  id="factura_impresion" name="factura_impresion" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Retención</label>
                                                <select class="form-control input-sm info-required" id="rete_id" name="rete_id" onchange="copyRete(this)">
                                                    <option value="">. . .</option>
                                                    <?php foreach ($retenciones as $v) : ?>
                                                        <option value="<?= $v->rete_id ?>" ret="<?= $v->rete_tarifa ?>" <?=($v->est_id == 0)?' style="background-color:#c1bcbc;" disabled':''?> ><?= $v->rete_denominacion ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Retención</label>
                                                <input readonly type="number" class="form-control input-sm"  id="factura_retefuente" name="factura_retefuente" value="" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Forma Pago</label>
                                                <input type="text" class="form-control input-sm" id="factura_formapago" name="factura_formapago" value="" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Orden Servicio</label>
                                                <input type="text" class="form-control input-sm" id="orden_servicio" name="orden_servicio" value="" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Detalle</label>
                                                <textarea type="text" class="form-control input-sm" rows="2" id="factura_detalle" name="factura_detalle" ></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="tab_2">
                            <br /><button type="button" class="btn  btn-default btn-sm " id="add-detail"><i class="fa fa-plus"></i> Agregar Detalle</button> 
                            <br /><br />
                            <div id="cont-bill">
                                <?= $detail ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_3">
                            <br /><button type="button" class="btn  btn-default btn-sm " id="import-detail" ><i class="fa fa-upload"></i> Importar</button>  
                            <br /><br />
                            <div class="row">
                                <div class="col-md-5">
                                    <form role="form" id="form-import" method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <input class="" type="file" name="files[]" id="import" >
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-12">
                                    <ul class="mailbox-attachments clearfix" id="cont-adjuntos">
                                        <?=$adjuntos?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modal-update">
    <div class="modal-dialog">
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
                            <div class="form-group">
                                <label>Tipo Presupuesto</label>
                                <select class="form-control input-sm" id="type" name="type" onchange="LoadPpto(this.value)">
                                    <option value="">. . .</option>
                                    <?php foreach ($category as $v) : ?>
                                    <option value="<?= $v->tabla ?>"><?= $v->descripcion ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" >
                            <table id="table_type" class="table table-bordered table-striped table-condensed display">
                                <thead>
                                    <tr>
                                        <th style="text-align:center">N&deg;</th>
                                        <th >CLIENTE</th>
                                        <th >CAMPAÑA</th>
                                        <th >FECHA</th>
                                        <th >TOTAL</th>
                                        <th >ESTADO</th>
                                        <th ></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    var factura = 0;
    $(function () {
        var sw = false;
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        
        $('.numerico, .decimals').autoNumeric('init', {
            mDec: 2,
            aDec: ',',
            aSep: '.'
        });
        
        $('#import').filer({
            showThumbs: true,
            addMore: false,
            allowDuplicates: false,
            limit: 1,
            maxSize:2,
            templates: {
                box: '<ul class="jFiler-items-list jFiler-items-default"></ul>',
                item: '<li class="jFiler-item"><div class="jFiler-item-container"><div class="jFiler-item-inner"><div class="jFiler-item-icon pull-left">{{fi-icon}}</div><div class="jFiler-item-info pull-left"><div class="jFiler-item-title" title="{{fi-name}}">{{fi-name | limitTo:30}}</div><div class="jFiler-item-others"><span>size: {{fi-size2}}</span><span>type: {{fi-extension}}</span><span class="jFiler-item-status">{{fi-progressBar}}</span></div><div class="jFiler-item-assets"><ul class="list-inline"><li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li></ul></div></div></div></div></li>',
                itemAppend: '<li class="jFiler-item"><div class="jFiler-item-container"><div class="jFiler-item-inner"><div class="jFiler-item-icon pull-left">{{fi-icon}}</div><div class="jFiler-item-info pull-left"><div class="jFiler-item-title">{{fi-name | limitTo:35}}</div><div class="jFiler-item-others"><span>size: {{fi-size2}}</span><span>type: {{fi-extension}}</span><span class="jFiler-item-status"></span></div><div class="jFiler-item-assets"><ul class="list-inline"><li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li></ul></div></div></div></div></li>',
                progressBar: '<div class="bar"></div>',
                itemAppendToEnd: false,
                removeConfirmation: false,
                canvasImage: true,
                _selectors: {
                    list: '.jFiler-items-list',
                    item: '.jFiler-item',
                    progressBar: '.bar',
                    remove: '.jFiler-item-trash-action'
                }
            },
        });
        
        $('#factura_fechagen,#factura_impresion').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight : true
        });

        $('#save').click(function () {
            save();
        });

        $('#add-detail').click(function () {
            $('#form-detail')[0].reset();
            $('#table_type > tbody').html('');
            $('#modal-update').modal();
        });
        
        $('#pvcl_id').change(function () {
            if ($(this).val() != '') {
                $.post('<?= base_url() ?>Managerbudget/C_Ppto/LoadSelect', {cliente: $(this).val()}, function (data) {
                    var option = '<option value="">. . .</option>';
                    $.each(data.campanas, function (e, i) {
                        option += '<option value="' + i.camp_id + '">' + i.camp_nombre + '</option>';
                    });
                    $('#camp_id').html(option);
                }, 'json');
            }
        });
        
        
        lock('0');
    });
    
    function copyRete(){
        $('#factura_retefuente').val($('#rete_id option:selected ').attr('ret'));
    }
    
    function lock(id_estado){
        if(id_estado != '1' && id_estado != '0'){
            $('.form-control').attr('disabled','disabled');
            $('#save ,#add-detail ,#btn-Aprobar').hide();
            $('.btn-danger ,.btn-info').attr('disabled','disabled').removeAttr('onclick');
            $('#orden_servicio').prop('disabled',false);
            $('#factura_detalle').prop('disabled',false);
        }else if(id_estado == '0'){
            $('#add-detail').hide();
            $('#import-detail').hide();
            $('#btn-Aprobar').hide();
        }
    }
    
    function LoadPpto(type){
        if($("#type").val() != ''){
            var type = $("#type").val();
            $.post('<?= base_url() ?>Billing/C_Bill/GetListTable',{category:type,client:$('#pvcl_id').val(),campain:$('#camp_id').val()},function(data){
                var tbody = '';
                $.each(data.result,function(e,i){
                    tbody += '<tr>';
                        tbody += '<td>'+i.id+'</td>';
                        tbody += '<td>'+i.client+'</td>';
                        tbody += '<td>'+i.campain+'</td>';
                        tbody += '<td>'+i.date+'</td>';
                        tbody += '<td><input disabled type="text" class="num" value="'+i.total+'" style="border:none;background-color: transparent;"></td>';
                        tbody += '<td>'+i.status+'</td>';
                        tbody += '<td><button type="button" class="btn btn-primary btn-xs btns-'+i.id+'" onclick="AddDetail('+i.id+',\''+type+'\')"><i class="fa fa-plus"></i></button></td>';
                    tbody += '</tr>';
                });
                $('#table_type > tbody').html(tbody);
                $('.num').autoNumeric('init', {
                    mDec: 2,
                    aDec: ',',
                    aSep: '.'
                });
            },'json');
        }else{
            $('#table_type > tbody').html('');
        }
    }
    
    function save() {
        if (validatefield('info-required')) {
            
            var formData = new FormData($('#form')[0]);
            
            formData.append("est_id", 1);
            formData.append("usr_mod", '<?=$this->session->UserMedios?>');
            formData.append("usr_id", '<?=$this->session->UserMedios?>');
            formData.append("factura_fecha", '<?=date("Y-m-d")?>');
            formData.append("factura_hora", '<?=date("H:i:s")?>');
            formData.append("resol_id", 2);
           
            $.ajax({
                url: "<?= base_url() ?>Billing/C_Bill/InsertInfo",
                type: 'POST',
                data: formData,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        factura = obj.id;
                        $('#update').show().attr('onclick','Update('+factura+')');
                        $('#btn-Aprobar').show().attr('onclick','Aprove('+factura+')');
                        $('#import-detail').show().attr('onclick','Upexcelfile('+factura+')');
                        $('#save').hide();
                        $('#add-detail ,#import-detail').show();
                        $('#title').html('<i class="fa fa-edit"></i> Factura N°<small>'+factura+' Activo</small>');
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
            
            var formData = new FormData($('#form')[0]);
           
            formData.append("factura_id", id);
            $.ajax({
                url: "<?= base_url() ?>Billing/C_Bill/UpdateInfo",
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
    
    function getType(type){
        switch(type){
            case 'presup_avisos':
                type = 1;
                break;
            case 'presup_clasificados':
                type = 2;
                break;
            case 'presup_revis':
                type = 3;
                break;
            case 'presup_radio':
                type = 4;
                break;
            case 'presup_tv':
                type = 5;
                break;
            case 'presup_prode':
                type = 6;
                break;
            case 'presup_prodi':
                type = 7;
                break;
            case 'publicidad_exterior':
                type = 8;
                break;
            case 'impresos':
                type = 9;
                break;
            case 'art_publi':
                type = 10;
                break;
        }
        return type;
    }
    
    function AddDetail(ppto,table){
        var type = getType(table);
        $('#modal-update').modal('hide');
        $.post('<?= base_url() ?>Billing/C_Bill/AddDetail',{ppto:ppto,tipo:type,table:table,factura_id:factura},function(data){
            if (data.res == "OK") {
                alertify.success("OK!");
                window.location.replace('<?= base_url() ?>Billing/Edit/'+factura);
            } else {
                swal({title: 'Error!', text: data.res, type: 'error'});
            }
        },'json');
    }
    
    function Upexcelfile(id){
        if($("#import").val() != ''){
            var formData = new FormData($('#form-import')[0]);
            formData.append('factura_id',id);

            $.ajax({
                url: "<?= base_url() ?>Billing/C_Bill/UpAttach",
                type: 'POST',
                data: formData,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        $('.jFiler-item-trash-action').click();
                        $('#cont-adjuntos').html(obj.table);
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
    
    function deleteAdjunto(id,ruta){
        swal({
            title: 'Confirmar!',
            text: "Eliminar Adjunto",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar!',
            reverseButtons: true
        }).then((result) => {
            if (result) {
                $.post('<?= base_url() ?>Billing/C_Bill/deleteAdjunto',{
                    id:id,
                    ruta:ruta,
                },function(data){
                    if(data.res == 'OK'){
                        $('.adj-'+id).remove();
                        alertify.success("OK!");
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

