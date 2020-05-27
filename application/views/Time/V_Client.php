<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>150</h3>
                        <p>New Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>53<sup style="font-size: 20px">%</sup></h3>

                        <p>Bounce Rate</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>44</h3>

                        <p>User Registrations</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>65</h3>

                        <p>Unique Visitors</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <section class="col-lg-8 connectedSortable">
                <div class="box box-info">
                    <div class="box-header">
                        <i class="fa fa-bar-chart-o"></i>

                        <h3 class="box-title" id="title-hclient">Horas por cliente. Periodo <?= date('Y-m') ?></h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-primary btn-sm  pull-right" id="hclient"><i class="fa fa-calendar"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div id="bar-example"></div>
                    </div>
                    <div class="box-footer clearfix">

                    </div>
                </div>

                <div class="box box-info">
                    <div class="box-header">
                        <i class="fa fa-bar-chart-o"></i>

                        <h3 class="box-title" id="title-hclient-range">Horas por cliente. Periodo <?= date('Y-m') ?></h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-primary btn-sm  pull-right" id="hclient-range"><i class="fa fa-calendar"></i></button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <div class="box-body">
                        <div id="bar-range"></div>
                    </div>
                    <div class="box-footer clearfix">

                    </div>
                </div>

                <div class="box box-info">
                    <div class="box-header">
                        <i class="fa fa-area-chart"></i>

                        <h3 class="box-title">Horas por usuario en OP</h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-primary btn-sm daterange pull-right" style="margin: 3px;" id="range-user" data-toggle="tooltip" title="" data-original-title="Date range"><i class="fa fa-calendar"></i></button>
                            <div class="form-group pull-right">
                                <select class="form-control select2" style="min-width: 200px;" id="users" onchange="SendRange()">
                                    <?php foreach ($users as $v) : ?>
                                        <option value="<?= $v->id_users ?>" <?= ($v->id_users == 1) ? 'selected' : '' ?>><?= $v->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <div class="box-body">
                        <div class="chart" id="revenue-chart" style="position: relative; height: 300px;"></div>
                    </div>
                    <div class="box-footer clearfix">

                    </div>
                </div>


            </section>
            <!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-4 connectedSortable">

                <div class="box box-info">
                    <div class="box-header">
                        <i class="fa fa-envelope"></i>

                        <h3 class="box-title" id="title-hclient" ></h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-primary btn-sm daterange pull-right" ><i class="fa fa-calendar"></i></button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <div class="box-body">
                        <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div>
                    </div>
                    <div class="box-footer clearfix">

                    </div>
                </div>

            </section>

        </div>
    </section>
</div>
<script>
    $(function () {

        $('.select2').select2();

//        $('.connectedSortable').sortable({
//            placeholder: 'sort-highlight',
//            connectWith: '.connectedSortable',
//            handle: '.box-header, .nav-tabs',
//            forcePlaceholderSize: true,
//            zIndex: 999999
//        });
//        $('.connectedSortable .box-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move');

        $('#hclient').datepicker({
            autoclose: true,
            format: "yyyy-mm",
            viewMode: "months",
            minViewMode: "months",
            orientation: 'bottom'
        }).on('changeDate', function (e) {
            var date = new Date(e.date);
            var month = (date.getMonth() + 1);
            var per = date.getFullYear() + '' + ((month < 10) ? '0' + month : month);
            LoadTimesClients(per);
            $('#title-hclient').html('Horas por cliente. Periodo ' + per);
        });

        $('#hclient-range').datepicker({
            autoclose: true,
            format: "yyyy-mm",
            viewMode: "months",
            minViewMode: "months",
            orientation: 'bottom'
        }).on('changeDate', function (e) {
            var date = new Date(e.date);
            var month = (date.getMonth() + 1);
            var per = date.getFullYear() + '' + ((month < 10) ? '0' + month : month);

            date.setMonth(date.getMonth() - 1);
            var month = (date.getMonth() + 1);
            var perOld = date.getFullYear() + '' + ((month < 10) ? '0' + month : month);


            LoadTimesClientsRange(per, perOld);
            $('#title-hclient-range').html('Horas por cliente. Periodo ' + perOld + ' - ' + per);
        });

        var date = new Date();
        var month = (date.getMonth() + 1);
        var per = date.getFullYear() + '' + ((month < 10) ? '0' + month : month);

        date.setMonth(date.getMonth() - 1);
        var month = (date.getMonth() + 1);
        var perOld = date.getFullYear() + '' + ((month < 10) ? '0' + month : month);

        $('#title-hclient').html('Horas por cliente. Periodo ' + per);
        $('#title-hclient-range').html('Horas por cliente. Periodo ' + perOld + ' - ' + per);
        LoadTimesClients(per);
        LoadTimesClientsRange(per, perOld);
        
        var date = new Date();
        var inicio = new Date(date.setDate(date.getDate() - 6));
        var mm = inicio.getMonth() + 1; 
        LoadrangeUser(inicio.getFullYear() + '-' + ((mm < 10) ? '0' + mm : mm) + '-' + inicio.getDate(), ShowDateJS())


        $('#range-user').daterangepicker({
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
            LoadrangeUser(start.format('YYYY-MM-D'), end.format('YYYY-MM-D'));
        });

        // Donut Chart
        var donut = new Morris.Donut({
            element: 'sales-chart',
            resize: true,
            colors: ['#3c8dbc', '#f56954', '#00a65a'],
            data: [
                {label: 'Download Sales', value: 12},
                {label: 'In-Store Sales', value: 30},
                {label: 'Mail-Order Sales', value: 20}
            ],
            hideHover: 'auto'
        });


    });
    
    function SendRange(){
        var date = new Date();
        var inicio = new Date(date.setDate(date.getDate() - 6));
        var mm = inicio.getMonth() + 1; 
        LoadrangeUser(inicio.getFullYear() + '-' + ((mm < 10) ? '0' + mm : mm) + '-' + inicio.getDate(), ShowDateJS());
    }

    function LoadTimesClientsRange(per, perOld) {
        $.post('<?= base_url() ?>Time/C_TimeClient/LoadTimesClientsRange', {periodo: per, old: perOld}, function (data) {
            $("#bar-range").empty();
            if (data.clients.length > 0) {
                Morris.Bar({
                    element: 'bar-range',
                    data: data.clients,
                    xkey: 'y',
                    ykeys: ['a', 'b'],
                    labels: ['Horas Mes Anterior', 'Horas Mes Seleccionado']
                });
            }
        }, 'json');
    }

    function LoadTimesClients(periodo) {
        $.post('<?= base_url() ?>Time/C_TimeClient/LoadTimesClients', {periodo: periodo}, function (data) {
            var datos = [];
            $.each(data.clients, function (e, i) {
                datos.push({y: i.nombre, b: i.sumtime});
            });
            $("#bar-example").empty();
            if (datos.length > 0) {
                Morris.Bar({
                    element: 'bar-example',
                    data: datos,
                    xkey: 'y',
                    ykeys: ['b'],
                    labels: ['Horas Trabajadas']
                });
            }
        }, 'json');
    }

    function LoadrangeUser(inicio, fin) {
        $.post('<?= base_url() ?>Time/C_TimeClient/LoadrangeUser', {user:$('#users').val(),ini: inicio, fin: fin}, function (data) {

            $("#revenue-chart").empty();
            if (data.clients.length > 0) {
                var area = new Morris.Line({
                    element: 'revenue-chart',
                    resize: true,
                    data: data.clients,
                    xkey: 'y',
                    ykeys: ['item1'],
                    labels: ['Horas Trabajadas'],
                    lineColors: ['#3c8dbc'],
                    hideHover: 'auto'
                });
            }
        }, 'json');
    }



</script>