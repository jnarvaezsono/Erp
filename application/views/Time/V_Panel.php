<style>
    .selectedTr{
        background-color: #e4ff78;
    } 
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-clock-o "></i> Mi Tiempo</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4 col-lg-2 col-sm-4" id="content-table">
                        <table id="times" class="table  table-condensed">
                            <thead>
                                <tr>
                                    <th style="text-align:center;"></th>
                                    <th style="text-align:center;">Fecha</th>
                                    <th style="text-align:center;">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                
                                setlocale(LC_TIME, LOCALE);
                                $count = 0;
                                foreach ($times as $v) :
                                    
                                    if ($v->id_estado == 10) {
                                        $img = '<img style="width:15px;"  data-placement="top" title="Tiempo Incompleto" src="' . base_url() . 'dist/img/icon-image/rojo.png">';
                                    } else if ($v->id_estado == 9) {
                                        $img = '<img style="width:15px;" data-placement="top" title="Tiempo Completo" src="' . base_url() . 'dist/img/icon-image/verde.png">';
                                    }
                                    if($v->festivo == 1 || $v->num >= 6){
                                        $img = '<img style="width:15px;"  data-placement="top" title="Tiempo No Obligatorio" src="' . base_url() . 'dist/img/icon-image/amarillo.png">';
                                    }
                                    ?>
                                    <tr ondblclick="showDetail(this,<?= $v->id_time ?>, '<?= $v->fecha ?>', <?=$count++?>, <?=$v->id_estado?>)" style="cursor: pointer" >
                                        <td style="text-align:center;"><?php if($count <= 2 || $v->id_estado == 10){ ?><i class="fa fa-pencil"></i><?php } ?></td>
                                        <td style="text-align:left;"><?= strftime("%A, %d de %B", strtotime($v->fecha)) ?></td>
                                        <td style="text-align:center;" id="img-<?= $v->id_time ?>"><?= $img ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-8 col-lg-10 col-sm-8" id="content-button">
                        
                    </div>
                    <div class="col-md-12 col-lg-10" id="content-rows">

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modal-time">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h6 class="modal-title"><i class="fa fa-fw fa-tasks"></i> GESTIONAR TIEMPOS</h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Acción</label>
                            <select class="form-control input-sm required select2" id="accion" style="width: 100%;" onchange="showDiv(this.value)">
                                <option value=""></option>
                                <option value="Actividades">Actividades De La Empresa</option>
                                <option value="Permiso">Permiso</option>
                                <option value="Reunion">Reunión De Trabajo</option>
                                <option value="Tarea">Tarea OP</option>
                                <option value="Tarea Sin OP">Tarea Sin OP</option>
                                <option value="Texto">Otra</option>
                                <!--<option value="Vacaciones">Vacaciones</option>-->
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bootstrap-timepicker">
                            <div class="form-group">
                                <label>Tiempo:</label>
                                <div class="input-group">
                                    <input type="text" id="tiempo" class="form-control timepicker required" autocomplete="off">

                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 cont-no-op" style="display: none">
                        <div class="form-group">
                            <label>Cliente:</label>
                            <select class="form-control select2" id="cliente" style="width: 100%;" >
                                <option value=""></option>
                                <?php foreach ($clients as $v) :?>
                                    <option value="<?=$v->id_client?>"><?=$v->nombre?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 cont-no-op" style="display: none">
                        <div class="form-group">
                            <label>Solicitado Por:</label>
                            <input  class="form-control " rows="2" id="solicitante" />
                        </div>
                    </div>
                    <div class="col-md-12" id="cont-actividades" style="display: none">
                        <div class="form-group">
                            <label>Actividad</label>
                            <select class="form-control select2" id="actividad" style="width: 100%;" >
                                <option value="">. . .</option>
                                <option value="Capacitacion">Capacitación</option>
                                <option value="Cumpleaños">Cumpleaños</option>
                                <option value="Simulacro">Simulacro</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-12" id="cont-tarea" style="display: none">
                        <div class="form-group">
                            <label>Tarea</label>
                            <select class="form-control select2" id="tarea" style="width: 100%;" >
                                <option value=""></option>
                                <?php foreach ($task as $v) :?>
                                    <option value="<?=$v->id_tarea?>"><?=$v->descripcion_op.' ('.strip_tags($v->descripcion).')'?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Describe Tu Actividad:</label>
                            <textarea type="text" class="form-control required" rows="2" id="texto" ></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="save" ><i class="fa fa-fw fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('.select2').select2();
        
        $('.timepicker').timepicker({
            showInputs: false,
            showMeridian: false,
            defaultTime: '00:00:00'
        });
    });
    
    function AddDetail(id_time,fecha){
        $('#texto, #solicitante').val('');
        $('#tiempo').val('00:00:00');
        $('#accion,#tarea, #cliente, #actividad').val('').trigger('change');
        $('#cont-tarea, .cont-no-op, #cont-actividades').hide();
        $('#save').attr('onclick','SaveDetail('+id_time+',"'+fecha+'","create",0)');
        $('#modal-time').modal();
    }
    
    function RemoveDetail(id_time,fecha){
        var detail = $('input:radio[name=select]:checked').val();
        if (detail !== undefined){
            swal({
                title: 'Esta seguro de eliminar el Registro?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar!'
            }).then((result) => {
                if (result) {
                    $.post("<?= base_url() ?>Time/C_Time/Save", {id_time: id_time,fecha:fecha,detail:detail,option:'delete'}, function (data) {
                        if (data.res == "OK") {
                            $("#content-rows").html(data.table);
                        
                            $('input[type="radio"].minimal').iCheck({
                                radioClass   : 'iradio_minimal-red'
                            });

                            if(data.sw == 1){
                                $('#img-'+id_time).html('<img style="width:15px;" data-placement="top" title="Tiempo Completo" src="<?=base_url()?>dist/img/icon-image/verde.png">');
                            }else{
                                $('#img-'+id_time).html('<img style="width:15px;" data-placement="top" title="Tiempo Incompleto" src="<?=base_url()?>dist/img/icon-image/rojo.png">');
                            }
                            alertify.success('OK');
                        } else {
                            alertify.error('Error '+data);
                        }
                    },'json');
                }
            }).catch(swal.noop)
        }else{
            alertify.error('SEECCIONE UN REGISTRO ');
        }
    }
    
    function EditDetail(id_time,fecha){
        var detail = $('input:radio[name=select]:checked').val();
        if (detail !== undefined){
            $.post("<?= base_url() ?>Time/C_Time/LoadDetail", {id_time:id_time,detail:detail}, function (data) {
                $('#accion').val(data.detail.type).trigger('change');
                console.log(data.detail.text);
                $('#texto').val(data.detail.text);
                $('#tiempo').val(data.detail.time);
                $('#cliente').val(data.detail.cliente).trigger('change');
                $('#solicitante').val(data.detail.solicitante);
                $('#actividad').val(data.detail.actividad).trigger('change');
                $('#tarea').val(data.detail.task).trigger('change');
                $('#save').attr('onclick','SaveDetail('+id_time+',"'+fecha+'","update",'+detail+')');
                showDiv(data.detail.type);
                $('#modal-time').modal();
            },'json');
        }else{
            alertify.error('SEECCIONE UN REGISTRO ');
        }
    }
    
    function showDiv(valor){
        
        $('#cliente, #solicitante, #actividad, #tarea').removeClass('required');
        
        if(valor == 'Texto' || valor == 'Permiso' || valor == 'Reunion'){
            $('#tarea, #cliente').val('').trigger('change');
            $('#solicitante, #actividad').val('');
            $('.cont-no-op, #cont-tarea, #cont-actividades').hide();
        }else if(valor == 'Tarea'){
            $('#cliente').val('').trigger('change');
            $('#texto, #solicitante, #actividad').val('');
            $('.cont-no-op, #cont-actividades ').hide();
            $('#cont-tarea').show();
            $('#tarea').addClass('required');
        }else if(valor == 'Tarea Sin OP'){
            $('#tarea').val('').trigger('change');
            $('#actividad').val('');
            $('.cont-no-op').show();
            $('#cont-tarea, #cont-actividades').hide();
            $('#cliente, #solicitante').addClass('required');
        }else if(valor == 'Actividades'){
            $('#tarea, #cliente').val('').trigger('change');
            $('#solicitante').val('');
            $('#cont-actividades').show();
            $('#cont-tarea, .cont-no-op').hide();
            $('#actividad').addClass('required');
        }else{
            $('#cont-tarea, .cont-no-op, #cont-actividades').hide();
            $('#tarea').removeClass('required');
        }
    }

    function showDetail(tr, id_time, fecha, count, estado) {
        $('.selectedTr').removeClass('selectedTr');
        $(tr).addClass('selectedTr');
        $.post('<?= base_url() ?>Time/C_Time/ShowDetail', {id_time: id_time, fecha: fecha}, function (data) {
            
            $("#content-rows").html(data.table);
            if(count <= 1 || estado == 10){
                $("#content-button").html(data.button);
            }else{
                $("#content-button").html('');
            }
            $('input[type="radio"].minimal').iCheck({
                radioClass   : 'iradio_minimal-red'
            })
            
        }, 'json');
    }
    
    function SaveDetail(id_time,fecha,option,detail){
        if(validatefield('required')){
            if($('#tiempo').val() != '00:00:00' && $('#tiempo').val() != '00:00'){
                var texto = $('#texto').val();
                if($('#accion').val() == 'Tarea'){
                    texto = $('#texto').val()+ ' ' +$('#tarea option:selected').text();
                }
                
                var cliente = $('#cliente').val();
                var nombre_cliente = $('#cliente option:selected').text();
                var solicitante = $('#solicitante').val();
                var actividad = $('#actividad').val();
                        
                        
                $.post('<?=base_url()?>Time/C_Time/Save',{fecha:fecha,id_time:id_time,detail:detail,type:$('#accion').val(),time:$('#tiempo').val(),task:$('#tarea').val(),text:texto,option:option,cliente:cliente,nombre_cliente:nombre_cliente,solicitante:solicitante,actividad:actividad},function(data){
                    if(data.res == 'OK'){
                        $("#content-rows").html(data.table);
                        
                        $('input[type="radio"].minimal').iCheck({
                            radioClass   : 'iradio_minimal-red'
                        });
                        
                        if(data.sw == 1){
                            $('#img-'+id_time).html('<img style="width:15px;" data-placement="top" title="Tiempo Completo" src="<?=base_url()?>dist/img/icon-image/verde.png">');
                        }else{
                            $('#img-'+id_time).html('<img style="width:15px;" data-placement="top" title="Tiempo InCompleto" src="<?=base_url()?>dist/img/icon-image/rojo.png">');
                        }
                        $('#modal-time').modal('hide');
                        alertify.success('OK');
                    }else{
                        alertify.error('ERROR '+data);
                    }
                },'json');
            }else{
                $("#tiempo").parents(".form-group").addClass("has-error").removeClass("has-success");
            }
        }
    }    
</script>    