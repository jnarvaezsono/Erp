<style>
    .td-estado{
        padding: 0 !important;
        vertical-align: middle !important;
    }
    td.details-control {
        background: url('<?= base_url() ?>/dist/img/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('<?= base_url() ?>/dist/img/details_close.png') no-repeat center center;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-dashboard"></i> Panel de control
            <small>Indicadores</small>
        </h1>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <?php
                    if (isDirGroup($this->session->IdRol) || isDirMedios($this->session->IdRol)):
                        foreach ($group as $name => $i) {
                            ?>
                            <div class="col-md-12" id="content-table">
                                <div class="box">
                                    <div class="box-header">
                                        <h3 class="box-title">Resumen tareas de <?= $name ?></h3>

                                    </div>
                                    <div class="box-body table-responsive no-padding">
                                        <table  class="table table table-hover table_all_dir">
                                            <thead>
                                                <tr>
                                                    <th>Categoria</th>
                                                    <th style="text-align:center">Cantidad</th>
                                                    <th style="text-align:center;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($group[$name]['task']['data'] as $v) : ?>
                                                    <tr>
                                                        <td style="width:60%"><?= $v->description ?></td>
                                                        <td style="text-align:center; width:30%"><span data-toggle="tooltip" title="" class="badge " style="background-color:<?= $v->hex ?>" ><?= $v->cant ?></span></td>
                                                        <td style="text-align:center;width:10%" user="<?= $group[$name]['id_User'] ?>" status="<?= $v->id_status ?>"></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                     <?php } endif; ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <?php
                    if (isDirMedios($this->session->IdRol)):
                        foreach ($group as $name => $i) {
                            ?>
                            <div class="col-md-12" id="content-table">
                                <div class="box">
                                    <div class="box-header">
                                        <h3 class="box-title">Otros Estados de <?= $name ?></h3>

                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body table-responsive no-padding">
                                        <table class="table table table-hover table_task_other">
                                            <thead>
                                                <tr>
                                                    <th>Categoria</th>
                                                    <th style="text-align:center">Cantidad</th>
                                                    <th style="text-align:center;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($group[$name]['task']['indicatorsPendiente'] as $v) : ?>
                                                    <tr>
                                                        <td style="width:60%"><?= $v->description ?></td>
                                                        <td style="text-align:center; width:30%"><span data-toggle="tooltip" title="" class="badge " style="background-color:#ff5200" ><?= $v->cant ?></span></td>
                                                        <td style="text-align:center;width:10%" user="<?= $group[$name]['id_User'] ?>" status="PENDIENTE"></td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                    <?php foreach ($group[$name]['task']['indicatorsVencida'] as $v) : ?>
                                                    <tr>
                                                        <td style="width:60%"><?= $v->description ?></td>
                                                        <td style="text-align:center; width:30%"><span data-toggle="tooltip" title="" class="badge " style="background-color:#ff002f" ><?= $v->cant ?></span></td>
                                                        <td style="text-align:center;width:10%" user="<?= $group[$name]['id_User'] ?>" status="VENCIDA"></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                    <?php } endif; ?>
                </div>   
            </div>   
        </div>   

        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <?php if (isCreator($this->session->IdRol)): ?> 
                        <div class="col-md-12" id="content-table">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Resumen Mis Tareas</h3>

                                </div>
                                <!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                    <table id="table_task" class="table table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Categoria</th>
                                                <th style="text-align:center">Cantidad</th>
                                                <th style="text-align:center;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($indicatorsMy as $v) : ?>
                                                <tr>
                                                    <td style="width:60%"><?= $v->description ?></td>
                                                    <td style="text-align:center; width:30%"><span data-toggle="tooltip" title="" class="badge " style="background-color:<?= $v->hex ?>" ><?= $v->cant ?></span></td>
                                                    <td style="text-align:center;width:10%" user="<?= $this->session->IdUser ?>" status="<?= $v->id_status ?>"></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (isResponsable($this->session->IdRol)): ?> 
                        <div class="col-md-12" id="content-table">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Resumen Mis Tareas Asignadas</h3>

                                </div>
                                <!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                    <table id="table_task_asig" class="table table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Categoria</th>
                                                <th style="text-align:center">Cantidad</th>
                                                <th style="text-align:center;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($indicatorsRes as $v) : ?>
                                                <tr>
                                                    <td style="width:60%"><?= $v->description ?></td>
                                                    <td style="text-align:center; width:30%"><span data-toggle="tooltip" title="" class="badge " style="background-color:<?= $v->hex ?>" ><?= $v->cant ?></span></td>
                                                    <td style="text-align:center;width:10%" user="<?= $this->session->IdUser ?>" status="<?= $v->id_status ?>"></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" id="content-table">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Otros Estados</h3>

                                </div>
                                <!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table table-hover table_task_other">
                                        <thead>
                                            <tr>
                                                <th>Categoria</th>
                                                <th style="text-align:center">Cantidad</th>
                                                <th style="text-align:center;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($indicatorsPendiente as $v) : ?>
                                                <tr>
                                                    <td style="width:60%"><?= $v->description ?></td>
                                                    <td style="text-align:center; width:30%"><span data-toggle="tooltip" title="" class="badge " style="background-color:#ff5200" ><?= $v->cant ?></span></td>
                                                    <td style="text-align:center;width:10%" user="<?= $this->session->IdUser ?>" status="PENDIENTE"></td>
                                                </tr>
                                                <?php endforeach; ?>
                                                <?php foreach ($indicatorsVencida as $v) : ?>
                                                <tr>
                                                    <td style="width:60%"><?= $v->description ?></td>
                                                    <td style="text-align:center; width:30%"><span data-toggle="tooltip" title="" class="badge " style="background-color:#ff002f" ><?= $v->cant ?></span></td>
                                                    <td style="text-align:center;width:10%" user="<?= $this->session->IdUser ?>" status="VENCIDA"></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>


                    <?php
                    if (isExecutive($this->session->IdRol) || isViewTeam($this->session->IdRol)):
                        foreach ($group as $name => $data['task']['data']) {
                            ?>
                            <div class="col-md-12" id="content-table">
                                <div class="box">
                                    <div class="box-header">
                                        <h3 class="box-title">Resumen tareas de <?= $name ?></h3>

                                    </div>
                                    <div class="box-body table-responsive no-padding">
                                        <table  class="table table table-hover table_all_executive">
                                            <thead>
                                                <tr>
                                                    <th>Categoria</th>
                                                    <th style="text-align:center">Cantidad</th>
                                                    <th style="text-align:center;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($group[$name]['task']['data'] as $v) : ?>
                                                    <tr>
                                                        <td style="width:60%"><?= $v->description ?></td>
                                                        <td style="text-align:center; width:30%"><span data-toggle="tooltip" title="" class="badge " style="background-color:<?= $v->hex ?>" ><?= $v->cant ?></span></td>
                                                        <td style="text-align:center;width:10%" user="<?= $group[$name]['id_User'] ?>" status="<?= $v->id_status ?>"></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }

                    endif;
                    ?>

                    <?php if (isResponsable($this->session->IdRol) && count($tareas) > 0): ?> 
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Mis Tareas</h3>
                                </div>
                                <div class="box-body no-padding">
                                    <div class="table-responsive mailbox-messages" style="height: 200px;">
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Tarea</th>
                                                    <th>Descripción</th>
                                                    <th>Fec.entrega</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($tareas as $v) : ?>
                                                    <tr>
                                                        <td style="width: 75px" class="mailbox-name"><i class="fa fa-star text-yellow"></i> <a href="<?= base_url() ?>OP/C_OP/Task/<?= $v->id_tarea ?>"><?= $v->id_tarea ?></a></td>
                                                        <td class="mailbox-subject"><b><?= $v->name ?></b> - <?= $v->descripcion ?></td>
                                                        <td class="mailbox-date" style="width: 81px;"><?= $v->fecha_entrega ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <?php if (isCreator($this->session->IdRol)): ?> 
                        <div class="col-md-12" id="content-table">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Resumen Mis OP</h3>

                                </div>
                                <!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                    <table id="table_op" class="table table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Categoria</th>
                                                <th style="text-align:center">Cantidad</th>
                                                <th style="text-align:center;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($indicatorsOPMy as $v) : ?>
                                                <tr>
                                                    <td style="width:60%"><?= $v->description ?></td>
                                                    <td style="text-align:center; width:30%"><span data-toggle="tooltip" title="" class="badge " style="background-color:<?= $v->hex ?>" ><?= $v->cant ?></span></td>
                                                    <td style="text-align:center;width:10%" user="<?= $this->session->IdUser ?>" status="<?= $v->id_status ?>"></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php
                    if (isExecutive($this->session->IdRol) || isViewTeam($this->session->IdRol)):
                        foreach ($group as $name => $data['op']['data']) {
                            ?>
                            <div class="col-md-12" id="content-table">
                                <div class="box">
                                    <div class="box-header">
                                        <h3 class="box-title">Resumen Ops de <?= $name ?></h3>

                                    </div>
                                    <div class="box-body table-responsive no-padding">
                                        <table  class="table table table-hover table_op_all_executive">
                                            <thead>
                                                <tr>
                                                    <th>Categoria</th>
                                                    <th style="text-align:center">Cantidad</th>
                                                    <th style="text-align:center;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($group[$name]['op']['data'] as $v) : ?>
                                                    <tr>
                                                        <td style="width:60%"><?= $v->description ?></td>
                                                        <td style="text-align:center; width:30%"><span data-toggle="tooltip" title="" class="badge " style="background-color:<?= $v->hex ?>" ><?= $v->cant ?></span></td>
                                                        <td style="text-align:center;width:10%" user="<?= $group[$name]['id_User'] ?>" status="<?= $v->id_status ?>"></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php }endif;?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <?php if (count($comentarios) > 0): ?> 
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Mis Notificaciones</h3>
                                </div>
                                <div class="box-body no-padding">
                                    <div class="table-responsive mailbox-messages" style="height: 200px;">
                                        <table class="table table-hover ">
                                            <thead>
                                                <tr>
                                                    <th>Tarea</th>
                                                    <th>Descripción</th>
                                                    <th>Tipo</th>
                                                    <th>Comentario</th>
                                                    <th>Realizado Por</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($comentarios as $v) : ?>
                                                <tr  ondblclick="nav(<?= $v->id_tarea ?>, 'task')" style="cursor:pointer">
                                                        <td style="width: 75px;"><i class="fa fa-star text-yellow"></i> <a href="<?= base_url() ?>OP/C_OP/Task/<?= $v->id_tarea ?>"></a></td>
                                                        <td ><b><?= $v->name ?></b> - <?= $v->descripcion ?></td>
                                                        <td ><?= $v->tipo ?></td>
                                                        <td ><?= ($v->tipo == 'TEXTO') ? $v->texto : "<a download='" . $v->adjunto . "' target='_blank' href='" . base_url() . "Adjuntos/COMMENT/" . $v->id_tarea . "/" . $v->adjunto . " ><i class='fa fa-paperclip'>" . $v->adjunto . "</a>" ?></td>
                                                        <td ><?= $v->comentarista ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>


    </section>
</div>
<script>
    $(document).ready(function () {
        <?php if (isCreator($this->session->IdRol)): ?>
                    Cargar_Tabla('#table_task', 'ShowTask');
                    Cargar_Tabla('#table_op', 'ShowOp');
        <?php endif; ?>

        <?php if (isResponsable($this->session->IdRol)): ?>
                    Cargar_Tabla('#table_task_asig', 'ShowTask/Responsable');
                    Cargar_Tabla('.table_task_other', 'ShowTaskOther/Responsable');
        <?php endif; ?>

        <?php if (isExecutive($this->session->IdRol) || isViewTeam($this->session->IdRol)): ?>
                    Cargar_Tabla('.table_all_executive', 'ShowTaskAllExecutive/Responsable');
                    Cargar_Tabla('.table_op_all_executive', 'ShowOpkAllExecutive/Responsable');
        <?php endif; ?>

        <?php if (isDirGroup($this->session->IdRol) || isDirMedios($this->session->IdRol)): ?>
                    Cargar_Tabla('.table_all_dir', 'ShowTaskAllDir');
        <?php endif; ?>

        <?php if (isDirMedios($this->session->IdRol)): ?>
                    Cargar_Tabla('.table_task_other', 'ShowTaskOther/Responsable');
        <?php endif; ?>
    });

    function nav(id, opc) {
        if (opc == 'op') {
            window.location = "<?= base_url() ?>OP/C_OP/Info/" + id;
        } else {
            window.location = "<?= base_url() ?>OP/C_OP/Task/" + id;
        }
    }

    function Cargar_Tabla(id, funcion) {

        var oTable = $('' + id).DataTable({
            "searching": false,
            dom: 'Bfrtip',
            'autoWidth': true,
            'paging': false,
            'ordering': false,
            buttons: [
                $.extend(true, {}, {}, {
                    extend: 'copyHtml5'
                }),
                $.extend(true, {}, {}, {
                    extend: 'excelHtml5'
                })
            ],
            "language": {
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                }
            }, columnDefs: [
                {targets: [0], width: '60%'},
                {className: "details-control", targets: [2], "data": null, "defaultContent": ''},
            ],
        });

        $('' + id + ' tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = oTable.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {

                $.post("<?= base_url() ?>OP/C_Control/" + funcion, {id_estado: $(this).attr('status'), user: $(this).attr('user'), funcion:funcion}, function (data) {
                    row.child(data.table).show();
                    tr.addClass('shown');
                    var touchtime = 0;
//                    $("."+funcion).on("click", function() {
//                        if (touchtime == 0) {
//                            // set first click
//                            touchtime = new Date().getTime();
//                        } else {
//                            // compare first click to this click and see if they occurred within double click threshold
//                            if (((new Date().getTime()) - touchtime) < 800) {
//                                // double click occurred
//                                alert("double clicked");
//                                touchtime = 0;
//                            } else {
//                                // not a double click so set as a new first click
//                                touchtime = new Date().getTime();
//                            }
//                        }
//                    });
                }, 'json');
            }
        });


    }
</script>