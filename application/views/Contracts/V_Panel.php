<style>
    .td-estado{
        padding: 0 !important;
        vertical-align: middle !important;
    }
    .dataTables_scrollBody{
        min-height: 400px;
    }
    .table-condensed>tbody>tr>td {
        font-size: 11px !important;
    }
    .trdbl{cursor:pointer}
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
                <h3 class="box-title"><i class="fa fa-fw fa-table"></i> CONTRATOS </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12" id="content-table">
                        <table id="tbl-contratos" class="table table-bordered table-striped table-condensed ">
                            <thead>
                                <tr>
                                    <th style="text-align:center">Número</th>
                                    <th style="text-align:center">Creador</th>
                                    <th style="text-align:center">Vencimiento</th>
                                    <th style="text-align:center">Tipo</th>
                                    <th style="text-align:center">Contra Parte</th>
                                    <th style="text-align:center">Responsable</th>
                                    <th style="text-align:center">Valor</th>
                                    <th style="text-align:center">Otros Si</th>
                                    <th style="text-align:center;">Estado</th>
                                    <th style="text-align:center;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rows as $v) : ?>
                                <tr class="trdbl" id="<?=$v->id ?>">
                                    <td><?=$v->numero ?></td>
                                    <td><?=$v->name ?></td>
                                    <td><?=$v->fecha_vencimiento ?></td>
                                    <td><?=$v->tipo ?></td>
                                    <td><?=$v->contra_parte ?></td>
                                    <td><?=$v->responsable ?></td>
                                    <td>$ <?=  number_format($v->valor,0,',','.') ?></td>
                                    <td><b><?=$v->otros ?></b></td>
                                    <td><span style="width:100%" class="label label-4 label-<?=$v->color ?>"><?=$v->estado ?></span></td>
                                    <td class="details-control"></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
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
        $('#id_fecha').daterangepicker({format: 'YYYY-MM-DD'});
    });

    function Filtrar() {
        $('#tbl-contratos').DataTable().destroy();
        $('#tbl-contratos > tbody').remove();
        Cargar_Tabla();
    }

    function Cargar_Tabla() {

        var oTable = $('#tbl-contratos').DataTable({
            fixedHeader: true,
            "pageLength": 50,
            sScrollX: true,
            scrollCollapse: true,
            "scrollY": "500px",
            "ordering": false,
            'autoWidth': false,
            dom: 'Bfrtip',
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
                {className: "text-center ", targets: [0, 2], width: '70px'},
                {className: "text-center", targets: [7]},
                {className: "text-center td-estado", targets: [8], width: '70px'},
            ],
            "initComplete": function () {
                var api = this.api();
                api.$('tr').dblclick( function () {
                    window.location = "<?= base_url() ?>InfoContract/" + $(this).attr('id');
                } );
            }
        });
        
        $('#tbl-contratos tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            console.log(tr);
            var row = oTable.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                $.post("<?= base_url() ?>Contracts/C_Contracts/ShowContracts", {id: tr.attr('id')}, function (data) {
                    row.child(data.table).show();
                    tr.addClass('shown');
                }, 'json');
            }
        });

    }

</script>
