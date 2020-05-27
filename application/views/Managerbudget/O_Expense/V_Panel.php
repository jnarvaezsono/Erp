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
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-fw fa-table"></i> ORDENES DE GASTO</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="input-group" style="margin-right: 5px"><span class="input-group-addon">N&deg;</span><input type="text" id="id" class="form-control" onchange="Filtrar()" placeholder="Numero" ></div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="id_fecha" placeholder="FECHA" onchange="Filtrar()">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control select2 "  style="width: 100%;" id="proveedor" onchange="Filtrar()">
                                <option value="all"> PROVEEDOR</option>
                                <option value="all"> TODOS</option>
                                <?php foreach ($proveedores as $v) : ?>
                                    <option value="<?= $v->id_client ?>"><?= $v->nombre ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 ">
                        <button type="button" class="btn btn-block btn-default btn-sm" onclick="Filtrar()"><i class="fa fa-fw fa-search"></i> BUSCAR</button>
                    </div>
                    <div class="col-md-2 ">
                        <?php if(isset($BtnNewOrderGast)): ?>
                        <button type="button" class="btn btn-block btn-primary btn-sm" onclick="NewOrder()"><i class="fa fa-fw fa-plus"></i> NUEVO</button>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-12" id="content-table">
                        <table id="table_ppto" class="table table-bordered table-striped table-condensed ">
                            <thead>
                                <tr>
                                    <th style="text-align:center">N&deg;</th>
                                    <th style="text-align:center">Fecha</th>
                                    <th style="text-align:center">Proveedor</th>
                                    <!--<th style="text-align:center">Medio</th>-->
                                    <th style="text-align:center">Usuario</th>
                                    <th style="text-align:center;">Estado</th>
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
        $('#id_fecha').daterangepicker({format: 'YYYY-MM-DD'});
        $('.select2').select2();
    });
    
//    function openModal(id){
//        $('#observacion').val($('.btnI'+id).attr('obs'));
//        $('#add-obs').attr('onclick','addObservacion('+id+')');
//        $('#modal-obs').modal();
//    }
//
    function Filtrar() {
        $('#table_ppto').DataTable().destroy();
        $('#table_ppto > tbody').remove();
        Cargar_Tabla();
    }
    
    function EditOrder(id,tipo){
        window.location.replace("<?= base_url() ?>Expense/Edit/" + id);
    }
    
    function NewOrder(){
        window.location.replace("<?= base_url() ?>Expense/New");
    }
    
    function Anule(id){
        swal({
            title: 'Confirma la anulación de la orden '+id+'?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar!',
            reverseButtons: true
        }).then((result) => {
            if (result) {
                $.post('<?= base_url() ?>Managerbudget/O_Expense/C_Expense/Anule',{order:id,status:'9999'},function(data){
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
        window.open('<?= base_url() ?>Managerbudget/O_Expense/C_Expense/PrintOrder/'+id, '_blank');
    }

    function Cargar_Tabla() {

        var id = $("#id").val();
        var proveedor = $("#proveedor").val();
        
        if (id == "") {
            id = "all";
        }
        
        if ($("#id_fecha").val() == "") {
            var fecha_ini = "all";
            var fecha_fin = "all";
        } else {
            var result = $("#id_fecha").val().split(' - ');
            fecha_ini = result[0];
            fecha_fin = result[1];
        }
        
        var oTable = $('#table_ppto').dataTable({
            "searching": false,
            "processing": true,
            "serverSide": true,
            lengthChange:false,
            'autoWidth': false,
            fixedHeader: true,
            "pageLength": 50,
            sScrollX: true,
            scrollCollapse: true,
            "scrollY": "500px",
            "ordering": false,
            "ajax": {
                "url": "<?= base_url() ?>Managerbudget/O_Expense/C_Expense/GetListTable/" + id+ '/' + fecha_ini + '/' + fecha_fin + '/'+proveedor,
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
                {className: "text-center ", targets: [0, 1], width: '70px'},
//                {className: "text-center", targets: [5]},
                {className: "text-center td-estado", targets: [4],width: '120px'}
            ],
        });

    }

</script>
