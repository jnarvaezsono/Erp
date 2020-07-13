<?php setlocale(LC_TIME, LOCALE); ?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <section class="col-md-12 connectedSortable">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Informe detallado por usuario</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form id="form-buscar" class="form-horizontal">
                        <div class="box-body">
                            <div class="form-group">
                                <label  class="col-sm-2 control-label">Usuarios</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2 " required id="users">
                                        <option value="ALL"> TODOS </option>
                                        <option value="DIGITAL"> EQUIPO DIGITAL </option>
                                        <option value="OLIMPICA"> EQUIPO OLIMPICA </option>
                                        <option value="OTRAS"> EQUIPO OTRAS CTAS </option>
                                        <?php foreach ($users as $v) : ?>
                                            <option value="<?= $v->id_users ?>"><?= $v->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Fecha</label>

                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" required id="id_fecha" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right">Descargar</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </section>
            <section class="col-lg-8 col-md-8 connectedSortable">
                <div class="box box-primary">
                    <div class="box-header">
                        <i class="fa fa-bar-chart-o"></i>

                        <h3 class="box-title title-one">Cantidad de horas por actividad. Ultimnos 7 días </h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <!--<button type="button" class="btn btn-primary btn-sm  pull-right" id="hclient-range"><i class="fa fa-calendar"></i></button>-->
                            <button type="button" class="btn btn-primary btn-sm daterange pull-right" style="margin: 3px;" id="range-grafone" data-toggle="tooltip" title="" data-original-title="Date range"><i class="fa fa-calendar"></i></button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <div class="box-body">
                        <div id="bar-one"></div>
                    </div>
                    <div class="box-footer clearfix">

                    </div>
                </div>
                <div class="box box-success">
                    <div class="box-header">
                        <i class="fa fa-bar-chart-o"></i>

                        <h3 class="box-title title-two">Cantidad de horas por cliente. Ultimnos 7 días</h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <!--<button type="button" class="btn btn-primary btn-sm  pull-right" id="hclient-range"><i class="fa fa-calendar"></i></button>-->
                            <button type="button" class="btn btn-success btn-sm daterange pull-right" style="margin: 3px;" id="range-graftwo" data-toggle="tooltip" title="" data-original-title="Date range"><i class="fa fa-calendar"></i></button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <div class="box-body">
                        <div id="bar-two"></div>
                    </div>
                    <div class="box-footer clearfix">

                    </div>
                </div>
            </section>
            <section class="col-lg-4 col-md-4 connectedSortable">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title title-one">Cantidad de horas por actividad. Ultimnos 7 días </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-condensed" id="table-grafone">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Acción</th>
                                    <th>Cantidad</th>
                                    <th>Progress</th>
                                    <th style="width: 40px">Label</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title title-two">Cantidad de horas por cliente. Ultimnos 7 días </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-condensed" id="table-graftwo">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Acción</th>
                                    <th>Cantidad</th>
                                    <th>Progress</th>
                                    <th style="width: 40px">Label</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

            </section>
            
            <section class="col-lg-4 col-md-4 connectedSortable">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title title-two">Dias por completar </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-condensed" id="table-tree">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Usuario</th>
                                    <th>Días Faltantes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $count = 1; foreach ($table as $v) :  ?>
                                    <tr>
                                        <td style="widtd: 10px"><?=$count++?></td>
                                        <td><?=$v->name?></td>
                                        <td><span class="badge bg-red"><?=$v->dias?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

        </div>
    </section>
</div>
<script>
    $(function () {

        $(".select2").select2();
        $('#id_fecha').daterangepicker({locale: {format: 'YYYY-MM-DD'}});

        $("#form-buscar").submit(function (event) {
            event.preventDefault();
            downloadExcel();
        });

        var date = new Date();
        var month = (date.getMonth() + 1);
        var per = date.getFullYear() + '-' + ((month < 10) ? '0' + month : month) + '-01';

        date.setMonth(date.getMonth() - 1);
        var month = (date.getMonth() + 1);
        var perOld = date.getFullYear() + '' + ((month < 10) ? '0' + month : month);

        grafOne(per, ShowDateJS(), true);
        grafTwo(per, ShowDateJS(), true);

        $('#range-grafone').daterangepicker({
            ranges: {
                'Hoy': [moment(), moment()],
                'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Ultimos 7 Dias': [moment().subtract(6, 'days'), moment()],
                'Ultimos 30 Dias': [moment().subtract(29, 'days'), moment()],
                'Mes Actual': [moment().startOf('month'), moment().endOf('month')],
                'Mes Anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(6, 'days'),
            endDate: moment()
        }, function (start, end) {
            grafOne(start.format('YYYY-MM-D'), end.format('YYYY-MM-D'), false);
        });

        $('#range-graftwo').daterangepicker({
            ranges: {
                'Hoy': [moment(), moment()],
                'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Ultimos 7 Dias': [moment().subtract(6, 'days'), moment()],
                'Ultimos 30 Dias': [moment().subtract(29, 'days'), moment()],
                'Mes Actual': [moment().startOf('month'), moment().endOf('month')],
                'Mes Anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(6, 'days'),
            endDate: moment()
        }, function (start, end) {
            grafTwo(start.format('YYYY-MM-D'), end.format('YYYY-MM-D'), false);
        });


    });

    function downloadExcel() {
        var result = $("#id_fecha").val().split(' - ');
        var fecha_ini = result[0];
        var fecha_fin = result[1];


        $(".loader_ajax2").text("Creando Archivo");
        $.post("<?= base_url() ?>Time/C_TimeClient/downloadExcel", {fecha_fin: fecha_fin, fecha_ini: fecha_ini, usuario: $('#users').val()}, function (data) {
                    if (data.result != 'ok') {
                        alertify.error("Ha ocurrido un error al descargar el archivo");
                        return false;
                    } else {
                        window.location.replace("<?= base_url() ?>Time/C_TimeClient/downloadExcel/" + data.archivo);
                    }
                }, 'JSON');
            }

            function grafOne(per, perOld, sw) {
                $.post('<?= base_url() ?>Time/C_TimeClient/getGrafOne', {ini: per, fin: perOld}, function (data) {
                    $("#bar-one").empty();
                    $('#table-grafone > tbody').html('<tr><td colspan="4">Sin datos</td></tr>');
                    if (!sw) {
                        $(".title-one").html('Cantidad de horas por actividad. ' + data.title);
                    }
                    if (data.data.length > 0) {
                        Morris.Bar({
                            element: 'bar-one',
                            data: data.data,
                            xkey: 'y',
                            ykeys: ['a'],
                            resize: true,
                            labels: ['Horas Trabajadas']
                        });

                        $('#table-grafone > tbody').html(data.table);

                    }
                }, 'json');
            }

            function grafTwo(per, perOld, sw) {
                $.post('<?= base_url() ?>Time/C_TimeClient/getGrafTwo', {ini: per, fin: perOld}, function (data) {
                    $("#bar-two").empty();
                    if (!sw) {
                        $(".title-two").html('Cantidad de horas por cliente.. ' + data.title);
                    }
                    $('#table-graftwo > tbody').html('<tr><td colspan="4">Sin datos</td></tr>');
                    if (data.data.length > 0) {
                        Morris.Bar({
                            element: 'bar-two',
                            data: data.data,
                            barColors: ['#00a65a', '#f56954'],
                            xkey: 'y',
                            ykeys: ['a'],
                            resize: true,
                            labels: ['Horas Por Cliente']
                        });

                        $('#table-graftwo > tbody').html(data.table);

                    }
                }, 'json');
            }

</script>