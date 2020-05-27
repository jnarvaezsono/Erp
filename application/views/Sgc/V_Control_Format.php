<style>
    .td-estado{
        padding: 0 !important;
        vertical-align: middle !important;
    }
    .dataTables_scrollBody{
        min-height: 400px;
    }
    .btn-left{
        min-width: 62px;
    }
    .td-estado{
        min-width: 102px !important;
    }
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-fw fa-table"></i> <?= $title ?></h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12" id="content-table">
                        <table id="table_format" class="table table-bordered table-striped table-condensed ">
                            <thead>
                                <tr>
                                    <th style="text-align:center">Solicitud</th>
                                    <th style="text-align:center">Fecha</th>
                                    <th style="text-align:center">Solicitante</th>
                                    <th style="text-align:center">Tipo</th>
                                    <th style="text-align:center"></th>
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
    $(function () {
        Cargar_Tabla();
        <?php if(isset($BtnNewReqFormat)): ?>
            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="NewRequest()" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" ><span>Solicitar</span></a></label>');
        <?php endif; ?>
    });
    
    function NewRequest(){
        location.href = "<?= base_url() ?>Sgc/New/<?= $type ?>";
    }
    
    function ViewRequest(id){
        location.href = "<?= base_url() ?>Sgc/Edit/"+id+"/<?= $type ?>";
    }

    function Cargar_Tabla() {

        var type = '<?= $type ?>';

        var oTable = $('#table_format').dataTable({
            "searching": true,
            dom: 'Bfrtip',
            "processing": true,
            "serverSide": true,
            lengthChange: false,
            'autoWidth': false,
            fixedHeader: true,
            "pageLength": 10,
            sScrollX: true,
            scrollCollapse: true,
            "scrollY": "400px",
            "ordering": false,
            "buttons": [],
            "ajax": {
                "url": "<?= base_url() ?>Sgc/C_Sgc/GetListTable/" + type,
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
            },
            columnDefs: [
                {className: "text-center ", targets: [0], width: '50px'},
                {className: "text-center ", targets: [1,2,3], width: '60px'},
                {className: "text-center td-estado", targets: [4],width: '95px'}
            ],
        });


    }
</script>