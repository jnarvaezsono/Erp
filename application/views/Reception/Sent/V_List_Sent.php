<style>
    .table-bordered>thead>tr>th {
        text-align: center !important;
    }
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Enviados</h3>

            </div>
            <div class="box-body">
                <div class="row"> 
                    <div class="col-md-12" id="content-table">
                        <?= $table ?>
                    </div>
                </div>
            </div>
            <div class="box-footer">

            </div>
        </div>
    </section>
</div>
<div id="menu_form"  class="modal fade" tabindex="-1" role="dialog"   >
    <div class="modal-dialog modal-lg">
        <div class="modal-content box">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Datos</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form role="form" id="form" method="POST" enctype="multipart/form-data">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date_sent">Fecha Envio</label>
                                    <input type="text" name="date_sent" class="form-control required picker" id="date_sent" value="<?=date('Y-m-d')?>"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bootstrap-timepicker">
                                    <div class="form-group">
                                        <label>Hora Envio</label>
                                        <input type="text" class="form-control timepicker " id="hour" name="hour">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group register">
                                    <label for="type">Tipo</label>
                                    <select name="type" class="form-control required" id="type">
                                        <option value="">. . .</option>
                                        <option value="CARTA">CARTA</option>
                                        <option value="CONTRATO">CONTRATO</option>
                                        <option value="CUADERNILLO">CUADERNILLO</option>
                                        <option value="FACTURA">FACTURA</option>
                                        <option value="INFORME">INFORME</option>
                                        <option value="LIBRO">LIBRO</option>
                                        <option value="POLIZA">POLIZA</option>
                                        <option value="OTRO">OTRO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                 <div class="form-group register">
                                    <label for="company">Empresa</label>
                                    <input type="text" name="company" class="form-control " id="company"   />
                                </div>
                            </div>
                            <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="addressee">Destinatario</label>
                                    <input type="text" name="addressee" class="form-control required" id="addressee"   />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label for="shipping_by">Modo Envio</label>
                                    <select name="shipping_by" class="form-control required" id="shipping_by">
                                        <option value="">. . .</option>
                                        <option value="COORDINADORA">COORDINADORA</option>
                                        <option value="MENSAJERO">MENSAJERO</option>
                                        <option value="SERVIENTREGA">SERVIENTREGA</option>
                                        <option value="ENVIA">ENVIA</option>
                                    </select>
                                </div>
                            </div> 
                             <div class="col-md-4">
                                 <div class="form-group register">
                                    <label for="response">En Respuesta a(Consecutivo)</label>
                                    <input type="number" name="response" class="form-control " id="response"   />
                                </div>
                            </div>
                            <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="description_register">Decripcion</label>
                                    <textarea type="text" name="description_register" class="form-control " id="description_register"   ></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">CANCELAR</button>
                <button type="button" class="btn btn-primary create" onclick="CreateRegister()">CREAR</button>
                <button type="button" class="btn btn-primary update" >ACTUALIZAR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    $(function () {
        CreateTable();
        $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Create()" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla" href="#"><span><i class="fa fa-file"></i> Crear</span></a></label>');
        $('.picker').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
        });
        $('.picker').datepicker('setDate',today);
        $('.timepicker').timepicker({
            showInputs: false
        });
    });
    
    function printTicket(consecutive,fecha){
        window.open('<?= base_url() ?>Reception/C_Sent/PrintLabel/'+consecutive+'/'+fecha, '_blank');
    }
    
    function Update(consecutive) {
        $("#form")[0].reset();
        $("#date_sent").val($("#date_sent" + consecutive).text());
        $("#hour").val($("#id" + consecutive).attr('hour'));
        $("#shipping_by").val($("#shipping_by" + consecutive).text());
        $("#addressee").val($("#addressee" + consecutive).text());
        $("#company").val($("#company" + consecutive).text());
        $("#description_register").val($("#id" + consecutive).attr('desc'));
        $("#response").val($("#id" + consecutive).attr('response'));
        $("#type").val($("#type" + consecutive).text());
       
        $(".update").show();
        $(".create").hide();
        $("#menu_form").modal("show");
        $(".update").attr("onclick", "UpdateSent(" + consecutive + ")");
    }

    function Create() {
        $("#form")[0].reset();
        $(".update").hide();
        $(".create").show();
        $("#menu_form").modal("show");
    }

    function UpdateSent(consecutive) {
        var error = false;
        $(".required").each(function () {
            if (!ValidateInput($(this).attr("id"))) {
                error = true;
            }
        });
        if (!error) {
            
            var formData = new FormData($('#form')[0]);
            formData.append("consecutive", consecutive);
            $.ajax({
                url: "<?= base_url() ?>Reception/C_Sent/UpdateSent",
                type: 'POST',
                data: formData,
                async: false,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        $("#date_sent"+ consecutive).text($("#date_sent").val());
                        $("#id" + consecutive).attr('desc',$("#description_register").val());
                        $("#type" + consecutive).text($("#type").val());
                        $("#id" + consecutive).attr('hour',$("#hour").val());
                        $("#shipping_by" + consecutive).text($("#shipping_by").val());
                        $("#addressee" + consecutive).text($("#addressee").val());
                        $("#company" + consecutive).text($("#company").val());
                        $("#id" + consecutive).attr('response',$("#response").val());
                        $("#menu_form").modal("hide");
                        swal({
                            title: 'Operacion Exitosa!',
                            text: "El registro ha sido actualizado.",
                            type: 'success'
                        }).then((result) => {
                            
                        });
                    } else {
                        swal({title: 'Error!', text: obj.res, type: 'error'});
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            }).fail(function (error) {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            });
        }
    }

    function CreateRegister() {
        var error = false;
        $(".required").each(function () {
            if (!ValidateInput($(this).attr("id"))) {
                error = true;
            }
        });
        if (!error) {
            
            var formData = new FormData($('#form')[0]);
            $.ajax({
                url: "<?= base_url() ?>Reception/C_Sent/CreateRegister",
                type: 'POST',
                data: formData,
                async: false,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        swal({
                            title: 'Operacion Exitosa!',
                            text: "El registro ha sido creado.",
                            type: 'success'
                        }).then((result) => {
                            $("#content-table").html(obj.tabla);
                            var table = CreateTable("tabla", false, false, true, false, true);
                            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Create()" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla" href="#"><span><i class="fa fa-user-plus"></i> Crear</span></a></label>');
                            $("#menu_form").modal("hide");
                        });
                    } else {
                        swal({title: 'Error!', text: obj.res, type: 'error'});
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            }).fail(function (error) {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            });
        }
    }

    function Anule(consecutive) {
        swal({
            title: 'Esta seguro de anular el registro ',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Anular!'
        }).then((result) => {
            if (result) {
                $.post("<?= base_url() ?>Reception/C_Sent/AnuleUser", {consecutive: consecutive}, function (data) {
                    if (data.res == "OK") {
                        swal('Operacion Exitosa!', 'El registro ha sido anulado.', 'success').then((result) => {});
                        $('.label-'+consecutive).removeClass('label-success').addClass('label-default').html('ANULADO');
                    } else {
                        swal({title: 'Error!', text: data, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            }
        }).catch(swal.noop)
    }
    
    function CreateTable(){
        var oTable = $('#tabla').dataTable({
            "searching": false,
            dom: 'Bfrtip',
            'autoWidth': false,
            fixedHeader: true,
            sScrollX: false,
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
            }
        });
    }

</script>