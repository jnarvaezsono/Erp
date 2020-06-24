<style>
    .td-estado{
        padding: 0 !important;
        vertical-align: middle !important;
    }
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-fw fa-table"></i> Notas Crédito</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Factura</label>
                            <input type="number" class="form-control" id="id_factura" onchange="Filtrar()">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Presupuesto</label>
                            <input type="number" class="form-control" id="ppto" onchange="Filtrar()">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Fecha</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="id_fecha" onchange="Filtrar()">
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                    <div class="col-md-12" id="content-table">
                        <?= $table ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modal-create">
    <div class="modal-dialog" style="width: 99%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body" id="modal-content">
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary pull-right" id="btn-create" >Crear</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        Cargar_Tabla();
  
        $(".select2").select2();
        $('#id_fecha').daterangepicker({format: 'YYYY-MM-DD'});
       
        
    });
   
    function Filtrar() {
        $('#table_note').DataTable().destroy();
        $('#table_note > tbody').remove();
        Cargar_Tabla();
    }
    
    function OpenPdf(id_nota_credito,factura){
        window.open('<?= base_url() ?>Billing/C_Credit_Notes/PrintNote/'+id_nota_credito+'/'+factura, '_blank');
    }


    function Cargar_Tabla() {

        var id_factura = $("#id_factura").val();
        var ppto = $("#ppto").val();
        
        if (ppto == "") {
            ppto = "all";
        }
        
        if (id_factura == "") {
            id_factura = "all";
        }
        
        if ($("#id_fecha").val() == "") {
            var fecha_ini = "all";
            var fecha_fin = "all";
        }else{
            var result = $("#id_fecha").val().split(' - ');
            fecha_ini = result[0];
            fecha_fin = result[1];
        }


        var oTable = $('#table_note').dataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 50,
            "scrollY": "370px",
            "lengthChange": false, //"lengthMenu": [[50, 100, 150, -1], [50, 100, 150, "All"]],
            "searching": false,
//            dom: 'Bfrtip',
            "order": [[ 1, 'desc' ]], 
//            buttons: [
//                'copyHtml5',
//                'excelHtml5',
//                'csvHtml5',
//                'pdfHtml5'
//            ],
            "ajax": {
                "url": "<?= base_url() ?>Billing/C_Credit_Notes/ListNote/" + id_factura + '/' + ppto+ '/' + fecha_ini+ '/' + fecha_fin,
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
                { "orderable": false, targets: [0,2,3,4,5,6,7] },
                {className: "text-center", targets: [0,1,2,3,4,5,6,7]},
                {className: "text-center td-estado", targets: [0], width: '130px'},
            ],
        });
    
    }
    
    function OpenXml(note,bill){
        window.open('<?= base_url() ?>Billing/C_Credit_Notes/GenerateXml/'+note+'/'+bill+'/NC', '_blank');
    }
    
    function PrintXml(note,bill){
        $(".loader_ajax2").text("Enviado Nota");
        $.post('<?= base_url() ?>Billing/C_Credit_Notes/GenerateXml/'+note+'/'+bill+'/NC/1',{},function(data){
            if(data.res == 'OK'){
                $('.label-'+note).removeClass('label-primary').addClass('label-warning').html('Enviada CEN');
                swal({title: 'Enviado!', text: '', type: 'success'});
            }
        },'json').always(function() {
            swal({title: 'Enviado!', text: '', type: 'success'});
        });
    }
    
    function approved(note){
        $.post('<?= base_url() ?>Billing/C_Credit_Notes/Approved',{note:note},function(data){
            if(data.res == '1'){
                $('.btn1-'+note).removeClass('btn-success').addClass('btn-warning').html('Aprobada');
                swal({title: 'Aprobado!', text: '', type: 'success'});
            }
        },'json');
    }
    
    function PrintXmlPrueba(note,bill){
        $(".loader_ajax2").text("Enviado Nota");
        $.post('<?= base_url() ?>Billing/C_Credit_Notes/GenerateXmlPrueba/'+note+'/'+bill+'/NC/1',{},function(data){
            if(data.res == 'OK'){
                $('.label-'+note).removeClass('label-primary').addClass('label-warning').html('Enviada CEN');
                swal({title: 'Enviado!', text: '', type: 'success'});
            }
        },'json').always(function() {
            swal({title: 'Enviado!', text: '', type: 'success'});
        });
    }
    
    function OpenXmlPrueba(note,bill){
        window.open('<?= base_url() ?>Billing/C_Credit_Notes/GenerateXmlPrueba/'+note+'/'+bill+'/NC', '_blank');
    }
</script>