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
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-fw fa-table"></i> Asignar Factura</h3>
                <div class="pull-right">
                    <button type="button" class="btn btn-default " id="updatePpto" title="Actualizar Facturas VS Presupuestos" >
                        <i class="fa fa-gear"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Cliente</label>
                            <select class="form-control select2 " id="id_cliente" onchange="Filtrar()">
                                <option value="all">Todos</option>
                                <?php foreach ($clientes as $v) : ?>
                                    <option value="<?= $v->pvcl_id ?>"><?= $v->pvcl_nombre ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Op</label>
                            <input type="number" class="form-control " id="id_op" onchange="Filtrar()">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Tarea</label>
                            <input type="number" class="form-control " id="id_tarea" onchange="Filtrar()">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Fecha Tarea</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right " id="id_fecha" onchange="Filtrar()">
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Estado</label>
                            <select class="form-control select2 " id="id_estado" onchange="Filtrar()">
                                <option value="Facturado">Facturado</option>
                                <option value="Pendientes" selected>Pendientes Facturar</option>
                                <option value="SinPresupuesto" >Sin Presupuesto</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12" id="content-table">
                        <table id="table_task" class="table table-bordered table-striped table-condensed ">
                            <thead>
                                <tr>
                                    <th style="text-align:center">OP.</th>
                                    <th style="text-align:center">No.</th>
                                    <th style="text-align:center">CLIENTE</th>
                                    <th style="text-align:center">CAMPAÑA</th>
                                    <th style="text-align:center">F.CREACIÓN</th>
                                    <th style="text-align:center">F.CIERRE</th>
                                    <th style="text-align:center;">DESCRIPCIÓN</th>
                                    <th style="text-align:center;">ESTADO</th>
                                    <th style="text-align:center;"></th>
                                    <th style="text-align:center;"></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function () {
        Cargar_Tabla();
        $(".select2").select2();
        $('#id_fecha').daterangepicker({format: 'YYYY-MM-DD'});
        
        $('#updatePpto').click(function(){
            $.post("<?= base_url() ?>OP/C_Assign/AsignPpto", {}, function (data) {
                if(data == 'OK'){
                    location.reload();
                }else{
                    swal({title: '', text: data, type: 'error'});
                }
            });
        });
        
    });
    
    function OpenTask(tarea) {
        window.location.href = '<?= base_url() ?>OP/C_Assign/Task/' + tarea
    }

    function Filtrar() {
        $('#table_task').DataTable().destroy();
        $('#table_task > tbody').remove();
        Cargar_Tabla();
    }

    function Billing(id_tarea, ppto, modulo, td) {
        $.post("<?= base_url() ?>OP/C_Assign/GetInvoice", {id_tarea: id_tarea, ppto: ppto, modulo: modulo}, function (data) {
            if (data.num > 0) {
                $(td).parent('td').html(data.result.factura_id);
            } else {
                swal({title: '', text: "NO EXISTE FACTURA PARA ESTE PRESUPUESTO", type: 'warning'});
            }
        }, 'json');
    }

    function Cargar_Tabla() {

        var op = $("#id_op").val();
        var tarea = $("#id_tarea").val();
        var id_cliente = $("#id_cliente").val();
        var id_estado = $("#id_estado").val();

        if (op == "") {
            op = "all";
        }
        if (tarea == "") {
            tarea = "all";
        }
        if ($("#id_fecha").val() == "") {
            var fecha_ini = "all";
            var fecha_fin = "all";
        } else {
            var result = $("#id_fecha").val().split(' - ');
            fecha_ini = result[0];
            fecha_fin = result[1];
        }
        

        var oTable = $('#table_task').DataTable({
            "searching": false,
            dom: 'Bfrtip',
            buttons: [
                $.extend(true, {}, {}, {
                    extend: 'copyHtml5'
                }),
                $.extend(true, {}, {}, {
                    extend: 'excelHtml5'
                })
            ],
            "ajax": {
                "url": "<?= base_url() ?>OP/C_Assign/ListarTasksFilter/" + op + '/' + tarea + '/' + id_cliente + '/' + fecha_ini + '/' + fecha_fin + '/' + id_estado,
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
                {className: "text-center", targets: [0, 1], width: '20px'},
                {className: "details-control", targets: [9], "data": null, "defaultContent": ''},
            ],
        });

        $('#table_task tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = oTable.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                $.post("<?= base_url() ?>OP/C_Assign/ShowPpto", {id_tarea: row.data()[1]}, function (data) {
                    row.child(data.table).show();
                    tr.addClass('shown');
                }, 'json');
            }
        });


    }
</script>