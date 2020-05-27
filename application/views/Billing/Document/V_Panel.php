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
    .table-condensed>tbody>tr>td {
        font-size: 15px !important;
    }
    .td-estado{
        min-width: 102px !important;
    }
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-fw fa-table"></i> Documento Equivalente</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12" id="content-table">
                        <table id="table_ppto" class="table table-bordered table-striped table-condensed ">
                            <thead>
                                <tr>
                                    <th style="text-align:center;"></th>
                                    <th style="text-align:center">#</th>
                                    <th style="text-align:center">Fecha</th>
                                    <th style="text-align:center">Tipo</th>
                                    <th style="text-align:center">Documento</th>
                                    <th style="text-align:center">Usuario</th>
                                    <th style="text-align:center">Total</th>
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
//        var column = [{"sWidth": "35%"}, {"sWidth": "26%"}, {"sWidth": "14%"}, {"sWidth": "10%"}, {"sWidth": "15%"}, {"sWidth": "15%"}, {"sWidth": "15%"}];
//        CreateDataTable("table_ppto", false, false, true, true, true, column);
        <?php if(isset($BtnNewDoc)): ?>
            $("#table_ppto_filter").append('<label style="margin-left: 5px;"><a onclick="NewPpto()" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" ><span><i class="fa fa-user-plus"></i> Nuevo</span></a></label>');
        <?php endif; ?>
        <?php if(isset($BtnCloseDoc)): ?>
            $("#table_ppto_filter").append('<label style="margin-left: 5px;"><a onclick="closeMonth()" class="btn btn-warning btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" ><span><i class="fa fa-lock"></i> Cerrar</span></a></label>');
        <?php endif; ?>
    });

    function EditPpto(id){
        window.location.replace("<?= base_url() ?>Document/Edit/" + id );
    }
    
    function NewPpto(){
        window.location.replace("<?= base_url() ?>Document/New"); 
    }
    
    function closeMonth(){
        $.post('<?= base_url() ?>Billing/C_Document/GetMonthClose',{},function(data){
            swal({
                title: 'Cerrar el periodo '+data.periodo_new+'?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                reverseButtons: true
            }).then((result) => {
                if (result) {
                    $.post('<?= base_url() ?>Billing/C_Document/Close',{periodo_new:data.periodo_new,periodo_old:data.periodo_old},function(op){
                        if(op.res == 'OK'){
                            
                            alertify.success('OK');
                        }else if(op.res =='WARNING'){
                            swal({title: 'Atención!', text: op.msg, type: 'warning'});
                        }else{
                            swal({title: 'Error!', text: op.res, type: 'error'});
                        }
                    },'json');
                }
            }, function (dismiss) {

            }).catch(swal.noop)
        },'json');
    }
    
    function Anule(id,tpo_doc,id_doc){
        swal({
            title: 'Confirma la anulación del documento '+id+'?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar!',
            reverseButtons: true
        }).then((result) => {
            if (result) {
                $.post('<?= base_url() ?>Billing/C_Document/Anule',{id:id,status:'9999',tpo_doc:tpo_doc,id_doc:id_doc},function(data){
                    if(data.res == 'OK'){
                        $('.btn1-'+id).attr('class','btn btn-danger btn-xs btn-left').html('Anulado');
                        $('.btn2-'+id).attr('class','btn btn-danger btn-xs dropdown-toggle');
                        $('.u-'+id).html('<li onclick="printPdf('+id+')"><a href="#"><i class="fa fa-fw fa-print" ></i> Imprimir</a></li>');
                        alertify.success('OK');
                    }else{
                        swal({title: 'Error!', text: data.res, type: 'error'});
                    }
                },'json');
            }
        }, function (dismiss) {
            
        }).catch(swal.noop)
    }
    
    function printPdf(id){
        window.open('<?= base_url() ?>Billing/C_Document/PrintDoc/'+id, '_blank');
    }
    
    function Cargar_Tabla() {

        var tabla = $('#table_ppto').DataTable({
            "searching": true,
            "processing": true,
            "serverSide": true,
            "lengthChange":true,
            'autoWidth': false,
            "fixedHeader": true,
            "pageLength": 10,
            "ajax": {
                "url": "<?= base_url() ?>Billing/C_Document/GetListTable/",
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
                {className: "text-center ", targets: [1], width: '50px'},
                {className: "text-center ", targets: [2], width: '60px'},
                {className: "text-center td-estado", targets: [0],width: '95px'}
            ],
        });
    
    tabla.buttons().container()
            .appendTo($('.col-sm-6:eq(0)', tabla.table().container()));
       

    }

</script>
