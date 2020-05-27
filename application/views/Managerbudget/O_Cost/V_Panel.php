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
                <h3 class="box-title"><i class="fa fa-fw fa-table"></i> ORDENES DE COSTO</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2 ">
                        <?php if(isset($BtnNewOrderCost)): ?>
                        <button type="button" class="btn btn-block btn-default btn-sm" onclick="OpenCopy()"><i class="fa fa-fw fa-copy"></i> Duplicar</button>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-2 ">
                        <?php if(isset($BtnNewOrderCost)): ?>
                        <button type="button" class="btn btn-block btn-default btn-sm" onclick="NewOrder()"><i class="fa fa-fw fa-plus"></i> Nuevo</button>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-12" id="content-table">
                        <table id="table_ppto" class="table table-bordered table-striped table-condensed ">
                            <thead>
                                <tr>
                                    <th style="text-align:center">N&deg;</th>
                                    <th style="text-align:center">Fecha</th>
                                    <th style="text-align:center">Cliente</th>
                                    <th style="text-align:center">Proveedor</th>
                                    <th style="text-align:center">Campaña</th>
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

<div class="modal fade" id="modal-obs">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Observación</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <textarea type="text" class="form-control input-sm " rows="2" id="observacion" name="observacion" ></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary pull-right" id="add-obs" ><i class="fa fa-save"></i> Agregar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-copy">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Duplicar Orden</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Orden Costo</label>
                            <select class="form-control input-sm select2" multiple="" id="ordenes" name="ordenes" style="width:100%">
                                <?php foreach ($orders as $value) : ?>
                                    <option value="<?=$value->id?>"><?=$value->id?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary pull-right" onclick="CopyMasive()"><i class="fa fa-save"></i> Duplicar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        Cargar_Tabla();
        $('#id_fecha').daterangepicker({format: 'YYYY-MM-DD'});
        $('.select2').select2();
    });
    
    function openModal(id){
        $('#observacion').val($('.btnI'+id).attr('obs'));
        $('#add-obs').attr('onclick','addObservacion('+id+')');
        $('#modal-obs').modal();
    }

    function Filtrar() {
        $('#table_ppto').DataTable().destroy();
        $('#table_ppto > tbody').remove();
        Cargar_Tabla();
    }
    
    function EditOrder(id,tipo){
        window.location.replace("<?= base_url() ?>OrderC/Edit/" + id);
    }
    
    function NewOrder(){
        window.location.replace("<?= base_url() ?>OrderC/New");
    }
    
    function OpenCopy(){
        $('#ordenes').val(null).trigger('change');
        $('#modal-copy').modal();
    }
    
    function  addObservacion(id){
        var obs = $('#observacion').val();
        $.post('<?= base_url() ?>Managerbudget/O_Cost/C_Order_Cost/AddObs',{id:id,obs:obs},function(data){
            if(data.res == 'OK'){
                $('.btnI'+id).attr('obs',obs);
                $('#modal-obs').modal('hide');
                alertify.success('OK');
            }else{
                swal({title: 'Error!', text: data.res, type: 'error'});
            }
        },'json');
    }
    
    function CopyMasive(){
        var orders = "";
        $.each($("#ordenes").val(), function (e, i) {
            if (orders != "") {
                orders += ",";
            }
            orders += i;
        });
        if(orders != ''){
            $.post('<?= base_url() ?>Managerbudget/O_Cost/C_Order_Cost/CopyMasive',{orders:orders},function(data){
                if(data.res == 'OK'){
                    $('#modal-copy').modal('hide');
                    alertify.success('OK');
                    Filtrar();
                }else{
                    swal({title: 'Error!', text: data.res, type: 'error'});
                }
            },'json');
        }
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
                $.post('<?= base_url() ?>Managerbudget/O_Cost/C_Order_Cost/Anule',{order:id,status:'9999'},function(data){
                    if(data.res == 'OK'){
                        $('.btn1-'+id).attr('class','btn btn-danger btn-xs btn-left').html('Anulado');
                        $('.btn2-'+id).attr('class','btn btn-danger btn-xs dropdown-toggle');
                        $('.u-'+id).html('<li onclick="printPdf('+id+',0)"><a href="#"><i class="fa fa-fw fa-print" ></i> Imprimir</a></li>');
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
        window.open('<?= base_url() ?>Managerbudget/O_Cost/C_Order_Cost/PrintOrder/'+id, '_blank');
    }
    
    function Download(id){
//        window.open('<?= base_url() ?>OrderC/Download/'+id);
        window.open('<?= base_url() ?>OrderC/Download/'+id, 'width=800,height=600,left=100,top=50,toolbar=yes');
    }

    function Cargar_Tabla() {

        var id = "all";
        var fecha_ini = "all";
        var fecha_fin = "all";
        var proveedor = "all";
        
        var oTable = $('#table_ppto').dataTable({
            "searching": true,
            dom: 'Bfrtip',
            "processing": true,
            "serverSide": true,
            lengthChange:false,
            'autoWidth': false,
            fixedHeader: true,
            "pageLength": 10,
            sScrollX: true,
            scrollCollapse: true,
            "scrollY": "400px",
            "ordering": false,
            "buttons": [],
            "ajax": {
                "url": "<?= base_url() ?>Managerbudget/O_Cost/C_Order_Cost/GetListTable/" + id+ '/' + fecha_ini + '/' + fecha_fin + '/'+proveedor,
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
                {className: "text-center", targets: [7]},
                {className: "text-center td-estado", targets: [6],width: '90px'}
            ],
        });

    }

</script>
