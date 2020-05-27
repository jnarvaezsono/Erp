<style>
    .swal2-modal .swal2-content {
        text-align: left;
    }
    .fc-time{
        display: none;
    }
    .fc-timeline-event{border-radius: 10px;}
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="row" >
            <div class="col-md-3"> 
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Cliente</label>
                            <select class="form-control select2 "  style="width: 100%;" id="cliente" >
                                <option value="All"> TODOS</option>
                                <?php foreach ($clientes as $v) : ?>
                                    <option value="<?= $v->pvcl_id ?>"><?= $v->pvcl_nombre ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Area</label>
                            <select class="form-control select2 " style="width: 100%;" id="area" onchange="cargarTipoArea(this.value)">
                                <option value="All"> TODAS</option>
                                <?php foreach ($areas as $v) : ?>
                                    <option value="<?= $v->id_area ?>"><?= $v->descripcion ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group div-rol" style="display:none">
                            <label>Cuenta</label>
                            <select class="form-control select2 " style="width: 100%;" id="rol" >
                                <option value="All"> TODAS</option>
                                <option value="3">OLIMPICA</option>
                                <option value="6">OTRAS</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Usuario</label>
                            <select class="form-control select2 " multiple style="width: 100%;" id="usuario" >
                                <option value="All"> TODOS</option>
                                <?php foreach ($usuarios as $v) : ?>
                                    <option value="<?= $v->id_users ?>"><?= $v->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="button" class="btn btn-primary pull-right" style="margin-left:5px" onclick="CreateCalendar()">Buscar</button>
                        <button type="button" class="btn btn-primary pull-right"  onclick="CreateXls()">Descargar</button>
                        <button type="button" class="btn btn-default " onclick="history.back()"> Atras</button>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-body no-padding">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(function () {
        $(".sidebar-toggle").click();
        CreateCalendar();
        setTimeout(function () {
            $(".fc-expander").click();
        }, 200);

        $(".select2").select2();
    });
    
    function cargarTipoArea(area){
        if(area == 1){
            $('.div-rol').show();
        }else{
            $('.div-rol').hide();
        }
    }

    function CreateXls() {
        $(".loader_ajax2").text("Creando Archivo");
        
        var str = '';
        $.each($("#usuario").val(), function (e, i) {
            if (str != '') {
                str += '-';
            }
            str += i;
        });

        if (str == '') {
            str = 'All';
        }
        
        $.post("<?= base_url() ?>OP/C_Trafic/CreateXls", {cliente:$("#cliente").val(),area:$("#area").val(),rol:$("#rol").val(), usuarios:str}, function (data) {
            if (data.result != 'ok') {
                alertify.error("Ha ocurrido un error al descargar el archivo");
                return false;
            } else {
                window.location.replace("<?= base_url() ?>OP/C_Trafic/CreateXls/" + data.archivo);
            }
        }, 'JSON');
    }

    function CreateCalendar() {
        $('#calendar').fullCalendar('destroy');

        var str = '';
        $.each($("#usuario").val(), function (e, i) {
            if (str != '') {
                str += '-';
            }
            str += i;
        });

        if (str == '') {
            str = 'All';
        }

        $('#calendar').fullCalendar({
            schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
            defaultView: 'timelineWeek',
            locale: 'es',
            height: 600,
            header: {
                left: 'prev,next',
                center: 'title',
                right: 'timelineDay,timelineWeek,timelineMonth,timelineYear'
            },
            defaultView: 'customWeek',
            views: {
                customWeek: {
                    type: 'timeline',
                    duration: { weeks: 1 },
                    slotDuration: {days: 1},
                    buttonText: 'Custom Week'
                }
            },
            resourceGroupField: 'building',
            resourceLabelText: 'Usuarios',
            resources: '<?= base_url() ?>OP/C_Trafic/ListTraficData/' + $("#cliente").val() + '/' + $("#area").val() + '/' + str + '/'+$("#rol").val(),
            events: '<?= base_url() ?>OP/C_Trafic/ListTraficTask/' + $("#cliente").val() + '/' + $("#area").val() + '/' + str + '/'+$("#rol").val(),
            eventClick: function (calEvent, jsEvent, view) {
                swal({
                    title: calEvent.estado,
                    html: 'Descripción OP: ' + calEvent.descripcion_op + '<br /><br />Descripción Tarea: <a href="<?= base_url() ?>OP/C_OP/Task/' + calEvent.id_tarea + '">' + calEvent.texto + '</a>',
                    type: 'warning'});
            }
        });

    }


</script>