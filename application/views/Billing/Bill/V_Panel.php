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
                <h3 class="box-title"><i class="fa fa-fw fa-table"></i> Facturación</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control select2 input-sm" id="id_cliente" onchange="Filtrar()">
                                <option value="all">CLIENTES</option>
                                <option value="all">TODOS</option>
                                <?php foreach ($clientes as $v) : ?>
                                    <option value="<?= $v->id_client ?>"><?= $v->nombre ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="number" class="form-control" id="id_factura" onchange="Filtrar()" placeholder="Factura">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="id_fecha" onchange="Filtrar()">
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                    <div class="col-md-2 ">
                        <?php if(isset($BtnNewBill)): ?>
                        <button type="button" class="btn btn-block btn-default btn-sm" onclick="NewBill()"><i class="fa fa-fw fa-plus"></i> Agregar pre-factura</button>
                        <?php endif; ?>
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
                <h4 class="modal-title">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"> Fecha</i>
                                </div>
                                <input type="text" class="form-control pull-right" id="datepicker">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                     Observación
                                </div>
                                <textarea class="form-control input-task " rows="1" id="observacion" name="observacion" placeholder="Enter ..."></textarea>
                            </div>
                        </div>
                    </div>
                </h4>
            </div>
            <div class="modal-body"  id="modal-content">

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
    
    function OpenModal(factura) {
        $.post('<?= base_url() ?>Billing/C_Bill/ListaDetailBill', {factura: factura}, function (data) {
            $('#btn-create').attr('onclick', 'GenerateNote(' + factura + ')');
            $("#modal-content").html(data.table);
            $('#modal-create').modal('show');
            $('.numerico, .decimals').autoNumeric('init', {
                mDec: 2,
                aDec: ',',
                aSep: '.'
            });
            $('#datepicker').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });
            $('input[type="checkbox"].minimal-red').iCheck({
                checkboxClass: 'icheckbox_minimal-red'
            }).on('ifChanged', function (e) {
                var isChecked = e.currentTarget.checked;
                var ppto = $(this).attr("id").substring(3);
                if (isChecked == true) {
                    var enable = true;
                    if ($('.nota-' + ppto).text() == 'SI') {
                        swal({
                            title: 'Este presupuesto tiene nota credito deseas agregar otra?',
                            text: "",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Aceptar!',
                            reverseButtons: true
                        }).then((result) => {
                            if (result) {
                                enable = true;
                            }
                        }, function (dismiss) {
                            if (dismiss === 'cancel') {
                                $('#ck-' + ppto).iCheck('uncheck')
                            }
                        }).catch(swal.noop)
                    }
                    if (enable) {
                        $('.vlr_bruto_' + ppto).attr('disabled', false);
                        $('.vlr_desc_' + ppto).attr('disabled', false);
                        $('.vlr_iva_' + ppto).attr('disabled', false);
                        $('.vlr_spa_' + ppto).attr('disabled', false);
                        $('.vlr_ivaspa_' + ppto).attr('disabled', false);
                    }

                } else {
                    $('.vlr_bruto_' + ppto).attr('disabled', true);
                    $('.vlr_desc_' + ppto).attr('disabled', true);
                    $('.vlr_iva_' + ppto).attr('disabled', true);
                    $('.vlr_spa_' + ppto).attr('disabled', true);
                    $('.vlr_ivaspa_' + ppto).attr('disabled', true);
                }
            });
        }, 'json');

    }

    function SumaTotal(Control, ppto) {
        var vlr_bruto = ($('.vlr_bruto_' + ppto).val() == '') ? 0 : $('.vlr_bruto_' + ppto).val().replace(/\./g, '').replace(/,/g, '.');
        var vlr_desc = ($('.vlr_desc_' + ppto).val() == '') ? 0 : $('.vlr_desc_' + ppto).val().replace(/\./g, '').replace(/,/g, '.');
        var vlr_iva = ($('.vlr_iva_' + ppto).val() == '') ? 0 : $('.vlr_iva_' + ppto).val().replace(/\./g, '').replace(/,/g, '.');
        var vlr_spa = ($('.vlr_spa_' + ppto).val() == '') ? 0 : $('.vlr_spa_' + ppto).val().replace(/\./g, '').replace(/,/g, '.');
        var vlr_ivaspa = ($('.vlr_ivaspa_' + ppto).val() == '') ? 0 : $('.vlr_ivaspa_' + ppto).val().replace(/\./g, '').replace(/,/g, '.');

        var total = 0;
        var subtotal = parseFloat(Number(vlr_bruto) - Number(vlr_desc));
        var spa = parseFloat(Number(vlr_spa) + Number(vlr_ivaspa));
        total = parseFloat(Number(vlr_iva) + spa + subtotal);
       
        $('.vlr_total_' + ppto).autoNumeric('set', total);
    }

    function GenerateNote(factura) {
        if ($('#datepicker').val() != '') {
            var array_body = [];
            $("#table-ppto tbody tr").each(function () {

                var ppto = $(this).attr("id").substring(3);
                var type = $(this).attr("type");
                var detalle = $(this).attr("detalle");

                if ($('#ck-' + ppto).is(':checked')) {
                    var array_body_hijo = [];

                    array_body_hijo.push(ppto);
                    array_body_hijo.push(type);
                    array_body_hijo.push(detalle);
                    array_body_hijo.push(($('.vlr_bruto_' + ppto).val() == '') ? 0 : $('.vlr_bruto_' + ppto).val().replace(/\./g, '').replace(/,/g, '.'));
                    array_body_hijo.push(($('.vlr_desc_' + ppto).val() == '') ? 0 : $('.vlr_desc_' + ppto).val().replace(/\./g, '').replace(/,/g, '.'));
                    array_body_hijo.push(($('.vlr_iva_' + ppto).val() == '') ? 0 : $('.vlr_iva_' + ppto).val().replace(/\./g, '').replace(/,/g, '.'));
                    array_body_hijo.push(($('.vlr_spa_' + ppto).val() == '') ? 0 : $('.vlr_spa_' + ppto).val().replace(/\./g, '').replace(/,/g, '.'));
                    array_body_hijo.push(($('.vlr_ivaspa_' + ppto).val() == '') ? 0 : $('.vlr_ivaspa_' + ppto).val().replace(/\./g, '').replace(/,/g, '.'));
                    array_body_hijo.push(($('.vlr_total_' + ppto).val() == '') ? 0 : $('.vlr_total_' + ppto).val().replace(/\./g, '').replace(/,/g, '.'));
                    
                    array_body.push(array_body_hijo);
                }
            });

            if (array_body.length > 0) {
                $.post('<?= base_url() ?>Billing/C_Bill/GenerateNote', {factura: factura, array_body: array_body, fecha: $('#datepicker').val(),observacion: $('#observacion').val()}, function (data) {
                    if (data.res == 'OK') {
                        $('#modal-create').modal('hide');
                        swal({title: 'OK!', text: '', type: 'success'});
                    }
                }, 'json');
            } else {
                swal({title: 'Error!', text: 'No ha seleccionado ningun presupuesto', type: 'error'});
            }
        } else {
            swal({title: 'Atención!', text: 'Debe seleccionar una fecha', type: 'warning'});
        }
    }
    
    function OpenXmlProductivo(bill){
        window.open('<?= base_url() ?>Billing/C_Bill/GenerateXml/'+bill, '_blank');
    }
    
    function OpenXmlPrueba(bill){
        window.open('<?= base_url() ?>Billing/C_Bill/GenerateXmlPrueba/'+bill, '_blank');
    }

    function Filtrar() {
        $('#table_bill').DataTable().destroy();
        $('#table_bill > tbody').remove();
        Cargar_Tabla();
    }
    
    function Approve(factura_id,status){
        $.post('<?= base_url() ?>Billing/C_Bill/UpdateInfo',{factura_id:factura_id,est_id:status},function(data){
            if(data.res == 'OK'){
                if(status == 45){
                    $('.btn1-'+factura_id).removeClass('btn-warning').addClass('btn-success').html('Aprobada CEN');
                }else{
                    $('.btn1-'+factura_id).removeClass('btn-warning').addClass('btn-danger').html('Rechazada CEN');
                }
                $('.u-'+factura_id).html('<li onclick="printPdf('+factura_id+',0)"><a href="#"><i class="fa fa-fw fa-print" ></i> Ver Factura</a></li>');
                swal({title: 'OK!', text: '', type: 'success'});
            }
        },'json');
    }
    
    function PrintXmlProductivo(bill){
        $(".loader_ajax2").text("Enviado Factura");
        $.post('<?= base_url() ?>Billing/C_Bill/GenerateXml/'+bill+'/1',{},function(data){
            if(data.res == 'OK'){
                $('.btn1-'+bill).removeClass('btn-warning').addClass('btn-green').html('Enviada CEN');
                swal({title: 'Enviado!', text: '', type: 'success'});
            }
        },'json').always(function() {
            swal({title: 'Enviado!', text: '', type: 'success'});
        });
    }
    
    function PrintXmlPrueba(bill){
        $(".loader_ajax2").text("Enviado Factura");
        $.post('<?= base_url() ?>Billing/C_Bill/GenerateXmlPrueba/'+bill+'/1',{},function(data){
            if(data.res == 'OK'){
                $('.btn1-'+bill).removeClass('btn-info').addClass('btn-warning').html('Enviada CEN');
                swal({title: 'Enviado!', text: '', type: 'success'});
            }
        },'json').always(function() {
            swal({title: 'Enviado!', text: '', type: 'success'});
        });
    }


    function Cargar_Tabla() {

        var id_factura = $("#id_factura").val();
        var tarea = $("#id_tarea").val();
        var id_cliente = $("#id_cliente").val();

        if (id_factura == "") {
            id_factura = "all";
        }

        if ($("#id_fecha").val() == "") {
            var fecha_ini = "all";
            var fecha_fin = "all";
        } else {
            var result = $("#id_fecha").val().split(' - ');
            fecha_ini = result[0];
            fecha_fin = result[1];
        }


        var oTable = $('#table_bill').dataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 50,
            "scrollY": "370px",
            "lengthChange": false, //"lengthMenu": [[50, 100, 150, -1], [50, 100, 150, "All"]],
            "searching": false,
//            dom: 'Bfrtip',
            "order": [[1, 'desc']],
//            buttons: [
//                'copyHtml5',
//                'excelHtml5',
//                'csvHtml5',
//                'pdfHtml5'
//            ],
            "ajax": {
                "url": "<?= base_url() ?>Billing/C_Bill/ListBill/" + id_factura + '/' + id_cliente + '/' + fecha_ini + '/' + fecha_fin,
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
                {"orderable": false, targets: [2,3, 4, 5]},
                {className: "text-center td-estado", targets: [0], width: '130px'},
                {className: "text-center td-estado", targets: [1,2], width: '70px'}
            ],
        });

    }
    
    function EditBill(bill){
        window.location.replace("<?= base_url() ?>Billing/Edit/" + bill);
    }
    
    function getAttach(bill){
        window.location.replace("<?= base_url() ?>Billing/Attach/" + bill);
    }
    
    function NewBill(){
        window.location.replace("<?= base_url() ?>Billing/New");
    }
    
    function printPdf(bill,op){
        window.open('http://10.16.0.94/MEDIOS/views/facturar/factura_pdf.php?factura_id='+bill, '_blank');
    }
</script>