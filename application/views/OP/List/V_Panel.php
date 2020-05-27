<style>
    .td-estado{
        padding: 0 !important;
        vertical-align: middle !important;
    }
    #table_op > tbody > tr {
        cursor: pointer;
    }
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-fw fa-table"></i> Consultar OP</h3><div class="pull-right"><button type="button" class="btn btn-default btn-sm" onclick="history.back()"><i  class="fa fa-fw fa-backward"></i> Atras</button> </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="input-group" style="margin-right: 5px"><span class="input-group-addon">OP</span><input type="text" id="id_op" class="form-control" onchange="Filtrar()" ></div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <!--<label for="">Cliente</label>-->
                            <select class="form-control   select2" id="id_cliente" onchange="Filtrar()" >
                                <option value="all">   CLIENTES   </option>
                                <?php foreach ($clientes as $v) : ?>
                                    <option value="<?= $v->pvcl_id ?>"><?= $v->pvcl_nombre ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <!--<label for="">Cliente</label>-->
                            <select class="form-control   select2" id="id_estado" onchange="Filtrar()" >
                                <option value="all">   ESTADO   </option>
                                <?php foreach ($estados as $v) : ?>
                                    <option value="<?= $v->id_status ?>" <?= ($v->id_status == 1) ? 'selected' : '' ?> ><?= $v->description ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <!--<label for="">Cliente</label>-->
                            <select class="form-control   select2" id="id_user" onchange="Filtrar()" >
                                <option value="all">   CREADOR   </option>
                                <?php foreach ($creadores as $v) : ?>
                                    <option value="<?= $v->id_users ?>" ><?= $v->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" id="desripcion" class="form-control " onchange="Filtrar()" placeholder="Descripción">
                        </div>
                    </div>
                    <div class="col-md-7 ">
                        <!--table-bordered table-striped table-condensed display-->
                    </div>
                    <div class="col-md-12" id="content-table">
                        <table id="table_op" class="table table table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th style="text-align:center">OP</th>
                                    <th >CLIENTE</th>
                                    <th >CAMPANA</th>
                                    <th >PRODUCTO</th>
                                    <th >CREADOR</th>
                                    <th style="text-align:center;">FEC.CREACIÓN</th>
                                    <th style="text-align:center;">FEC.CIERRE</th>
                                    <th>DESCRIPCIÓN</th>
                                    <th style="text-align:center;">ESTADO</th>
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

    });


    function Filtrar() {
        $('#table_op').DataTable().destroy();
        $('#table_op > tbody').remove();
        Cargar_Tabla();
    }

    function Cargar_Tabla() {

        var op = $("#id_op").val();
        var cliente = $("#id_cliente").val();
        var estado = $("#id_estado").val();
        var creador = $("#id_user").val();
        var descripcion = $("#desripcion").val();

        if (op == "") {
            op = "all";
        }
        
        if (descripcion == "") {
            descripcion = "all";
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

        var oTable = $('#table_op').dataTable({
            "searching": false,
            dom: 'Bfrtip',
            'autoWidth': false,
            fixedHeader: true,
            sScrollX: true,
            scrollCollapse: true,
            "scrollY": "300px",
            "ordering": false,
            buttons: [
                $.extend(true, {}, {}, {
                    extend: 'copyHtml5'
                }),
                $.extend(true, {}, {}, {
                    extend: 'excelHtml5'
                })
            ],
            "ajax": {
                "url": "<?= base_url() ?>OP/C_OP/ListarOrden/" + op + '/' + cliente + '/' + estado + '/' + creador + '/' + descripcion,
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
                {targets: [7], width: '30%'},
                {className: "text-center", targets: [8]},
                {className: "text-center tdop", targets: [0]}
            ],
            "initComplete": function () {
                var api = this.api();
                api.$('tr').dblclick( function () {
                    window.location = "<?= base_url() ?>OP/C_OP/Info/" + $(this).find('.tdop').text();
                } );
            }
        });
        $(".dt-buttons").append('<label ><a onclick="window.location.href = \'<?= base_url() ?>OP/C_OP\'" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span> Crear</span></a></label>');
    }
</script>
