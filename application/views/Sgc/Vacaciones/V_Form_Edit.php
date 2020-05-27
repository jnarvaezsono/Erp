<style>
    .nav-tabs-custom>.nav-tabs>li.active {
        border-top-color: #d2d6de;
    }
    .form-horizontal .control-label {
        text-align: left;
    }
    .box-title {
        font-size: 12px !important;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1 id="titulo">
            <i class="fa fa-edit"></i>Solictud Vacaciones N° <?= $id ?>
            <small id="status"> <?= $row->estado ?> </small>
        </h1>
        <ol class="breadcrumb">
            <li onclick="back()"><a href="#" style="text-decoration: underline;color:orange;font-size: large;"><i class="fa fa-backward"></i> ATRAS</a></li>
        </ol>
    </section>
    <section class="content">
        <form id="form">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h4 class="box-title">1. DATOS DE SOLICITUD </h4>
                </div>
                <div class="box-body">
                    <div class="col-md-4">
                        <label>Fecha Inicio</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control  input-sm date"  required id="fecha_inicio" value="<?=$row->fecha_inicio?>" name="fecha_inicio" autocomplete="new-name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Fecha Fin</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control  input-sm date"  required id="fecha_fin" value="<?=$row->fecha_fin?>" name="fecha_fin" autocomplete="new-name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Total Días Habiles Tomados</label>
                        <input type="text" class="form-control  input-sm date"  required id="total_dias" name="total_dias" value="<?=$row->total_dias?>" readonly>
                    </div>
                    <div class="col-md-4">
                        <label>Solicitar a:</label>
                         <select class="form-control input-sm  "  required id="" name="solicitado_a" >
                            <option value="" selected>. . .</option>
                            <option value="70" <?=($row->solicitado_a == '70')?'selected':''?>>Gerencia Administrativa</option>
                            <option value="41,42" <?=($row->solicitado_a == '41,42')?'selected':''?>>Gerencia Creativa</option>
                            <option value="46" <?=($row->solicitado_a == '46')?'selected':''?>>Gerencia Cuentas</option>
                            <option value="63,62" <?=($row->solicitado_a == '63,62')?'selected':''?>>Gerencia Medios</option> 
                        </select>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Observaciones</label>
                            <textarea type="text" class="form-control input-sm"   rows="5" id="" name="observaciones" ><?=$row->observaciones?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="button" class="btn btn-default " onclick="back()"> Atras</button>
        </form>
    </section>
</div>

<script>
    $(function () {
        $('#fecha_inicio, #fecha_fin').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight : true,
        }).on('changeDate', function (e) {
            if($('#fecha_inicio').val() != '' && $('#fecha_fin').val() != ''){
                if($('#fecha_inicio').val() >= $('#fecha_fin').val() ){
                    swal({title: 'Error!', text: 'La fecha inicial debe ser menor a la fecha final', type: 'error'});
                }else{
                    $.post('<?= base_url() ?>Sgc/C_Sgc/ShowDay',{inicio:$('#fecha_inicio').val(),fin:$('#fecha_fin').val()},function(data){
                        $('#total_dias').val(data.num);
                    },'json');
                }
            }
        });
            
        $("#form ").submit(function (event) {
            event.preventDefault();
            save();
        });
    });
    
    function back(){
        location.href = "<?= base_url() ?>Sgc/Edit/<?= $id ?>/<?= $tipo ?>";
    }

    function save() {
    
        if($('#fecha_inicio').val() >= $('#fecha_fin').val() ){
            swal({title: 'Error!', text: 'La fecha inicial debe ser menor a la fecha final', type: 'error'});
            return false;
        }

        var formData = new FormData($('#form')[0]);
        formData.append("tipo", <?= $tipo ?>);
        formData.append("id_solicitud", <?= $id ?>);
        
        $.ajax({
            url: "<?= base_url() ?>Sgc/C_Sgc/UpdateInfo",
            type: 'POST',
            data: formData,
            success: function (data) {
                var obj = jQuery.parseJSON(data);
                if (obj.res == "OK") {
                    swal({title: 'OK!', text: '', type: 'success'}).then((result) => {
                        if (result) {
                             $('html, body').animate({scrollTop:0}, 1250);
                        }
                    })
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
</script>

