<style>
    .td-estado{
        padding: 0 !important;
        vertical-align: middle !important;
    }
    #table_task > tbody > tr {
        cursor: pointer;
    }
    .truncate {
        max-width:300px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-fw fa-table"></i><?= $title ?></h3><div class="pull-right"><button type="button" class="btn btn-default btn-sm" onclick="history.back()"><i  class="fa fa-fw fa-backward"></i> Atras</button> </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="desripcion">Descripción</label>
                            <input type="text" id="desripcion" class="form-control " onchange="Filtrar()" >
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="id_cliente">Cliente</label>
                            <select class="form-control  select2" id="id_cliente" onchange="Filtrar()" >
                                <option value="all">Todos</option>
                                <?php foreach ($clientes as $v) : ?>
                                    <option value="<?= $v->pvcl_id ?>"><?= $v->pvcl_nombre ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="id_estado">Estado</label>
                            <select class="form-control  select2" id="id_estado" onchange="Filtrar()" >
                                <option value="all">Todos</option>
                                <option value="PENDIENTE">PENDIENTE POR COBRAR</option>
                                <option value="COBRADAS">COBRADAS</option>
                                <option value="VENCIDA">VENCIDAS</option>
                                <?php foreach ($estados as $v) : ?>
                                    <option value="<?= $v->id_status ?>" <?=($v->id_status == 1)?'selected':''?>><?= $v->description ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <?php if ($maestro == 'TRUE'): ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="id_area">Area</label>
                            <select class="form-control  select2" id="id_area" onchange="Filtrar()" >
                                <option value="all">Todos</option>
                                <?php foreach ($areas as $v) : ?>
                                    <option value="<?= $v->id_area ?>" ><?= $v->descripcion ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if ($maestro == 'TRUE'): ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="id_usuario">Responsable</label>
                                <select class="form-control  select2" id="id_usuario" onchange="Filtrar()" >
                                    <option value="all">Todo</option>
                                    <?php foreach ($usuarios as $v) : ?>
                                        <option value="<?= $v->id_users ?>"><?= $v->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="modalidad">Modalidad</label>
                            <select class="form-control  select2" id="modalidad" onchange="Filtrar()" >
                                <option value="all">Todo</option>
                                <?php foreach ($modalidad as $v) : ?>
                                    <option value="<?= $v->descripcion ?>"><?= $v->descripcion ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="id_op">Op</label>
                            <input type="text" id="id_op" class="form-control " onchange="Filtrar()" >
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="id_tarea">Tarea</label>
                            <input type="text" id="id_tarea" class="form-control " onchange="Filtrar()" >
                        </div>
                    </div>
                    <div class="col-md-12" id="content-table">
                        <table id="table_task" class="table table-bordered table-striped table-condensed display" style="width:1500px;">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Estado</th>
                                    <th style="text-align:center;"></th>
                                    <th style="text-align:center">Op.</th>
                                    <th style="text-align:center">No.</th>
                                    <th style="text-align:center">Categoria</th>
                                    <th style="text-align:center">Cliente</th>
                                    <th >Creador</th>
                                    <th >Creación</th>
                                    <th >Entrega</th>
                                    <th >Cierre</th>
                                    <th style="text-align:center;">Descripción</th>
                                    <th style="text-align:center;">Responsable</th>
                                    <th style="text-align:center;">Ppto</th>
                                    <!--<th style="text-align:center;">TIEMPO</th>-->
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modal-time">
    <div class="modal-dialog" style="width: 281px;">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #3c8dbc; color: #fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">TIEMPO ESTIMADO INVERTIDO</h4>
            </div>
            <div class="modal-body">
                <div class="bootstrap-timepicker">
                    <div class="form-group">
                        <label>Horas</label>
                        <div class="input-group">
                            <input type="number" class="form-control timepicker " id="tiempo1" name="tiempo1" value="0">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bootstrap-timepicker">
                    <div class="form-group">
                        <label>Minutos</label>
                        <div class="input-group">
                            <input type="number" class="form-control timepicker " id="tiempo2" name="tiempo2" value="0">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default " data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary pull-right" id="addtime">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        Cargar_Tabla();
        $('.select2').select2();
    });

    function OpenModal(task) {
        $("#modal-time").modal('show');
        $("#addtime").attr('onclick', 'AddTime(' + task + ')');
    }

    function AddTime(task) {
        if (validatefield('timepicker')) {

            var hora = $('#tiempo1').val() + ':' + $('#tiempo2').val();

            $.post('<?= base_url() ?>OP/C_OP/AddTime', {id_tarea: task, hora: hora}, function (data) {
                if (data.res == 'OK') {
                    $('#time-' + task).html(' ' + hora).removeAttr('onclick');
                    $("#modal-time").modal('hide');
                }
            }, 'json');
        }
    }


    function Filtrar() {
        $('#table_task').DataTable().destroy();
        $('#table_task > tbody').remove();
        Cargar_Tabla();
    }

    function Cargar_Tabla() {

        var op = $("#id_op").val();
        var tarea = $("#id_tarea").val();
        var estado = $("#id_estado").val();
        var usuario = $("#id_usuario").val();
        var cliente = $("#id_cliente").val();
        var area = $("#id_area").val();
        var modalidad = $("#modalidad").val();
        var desripcion = $("#desripcion").val();

        if (usuario == null) {
            usuario = "all";
        }
        
        if (area == null) {
            area = "all";
        }

        if (op == "") {
            op = "all";
        }

        if (desripcion == "") {
            desripcion = "all";
        }
        if (tarea == "") {
            tarea = "all";
        }
        if (usuario == "") {
            usuario = "all";
        }

        var buttonCommon = {
            exportOptions: {
                format: {
                    body: function (data, row, column, node) {
                        // Strip $ from salary column to make it numeric
                        return column === 5 ? data.replace(/[$,]/g, '') : data;
                    }
                }
            }
        };

        var maestro = '<?= $maestro ?>';
        var oTable = $('#table_task').dataTable({
            "searching": false,
            dom: 'Bfrtip',
            'autoWidth': false,
            fixedHeader: true,
            sScrollX: true,
            scrollCollapse: true,
            "scrollY": "300px",
            'ordering': false,
            buttons: [
                $.extend(true, {}, buttonCommon, {
                    extend: 'copyHtml5'
                }),
                $.extend(true, {}, {}, {
                    extend: 'excelHtml5'
                })
            ],
            "ajax": {
                "url": "<?= base_url() ?>OP/C_OP/ListarTasksFilter/" + cliente + '/' + op + '/' + tarea + '/' + estado + '/' + usuario + '/'+area+'/'+ maestro+'/'+modalidad+'/'+desripcion,
                "dataSrc": "datos"
            },
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
                {className: "text-center idtask", targets: [3]},
                {className:"truncate" ,targets: 10}
//                {targets: 10,render: function ( data, type, row ) {return data.substr( 0, 50 )}}
            ],
            "initComplete": function () {
                var api = this.api();
                api.$('tr').dblclick( function () {
                    window.location = "<?= base_url() ?>OP/C_OP/Task/" + $(this).find('.idtask').text();
                } );
            }
        });
    }
</script>