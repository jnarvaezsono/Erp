<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?=$type?></h3>

            </div>
            <div class="box-body">
                <div class="col-md-12" id="content-table">
                    <table id="tabla_clientes" class="table table-bordered table-striped table-condensed ">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Documento</th>
                                <th>Ciudad</th>
                                <th>Dirección</th>
                                <th>Telefono</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="box-footer">

            </div>
        </div>
    </section>
</div>

<div id="menu_form"  class="modal fade" tabindex="-1" role="dialog"   >
    <div class="modal-dialog " style="width: 90%;">
        <div class="modal-content box" id="body-edit">

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div id="more_form"  class="modal fade" tabindex="-1" role="dialog"   >
    <div class="modal-dialog " >
        <div class="modal-content box" id="body-more">

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script>
    $(document).ready(function () {
        
        $('#menu_form').on('shown.bs.modal', function (e) {
            $(".select2").select2();
        });
        
        Cargar_Tabla();
        $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Create()" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-user-plus"></i> Crear</span></a></label>');
    });

    function Update(id_client) {
        $.post("<?= base_url() ?>Parameters/Client/C_Client/InfoClient", {id_client: id_client,type:'<?=$type?>'}, function (data) {
            $('#body-edit').html(data.modalEdit);
            $('input[type="checkbox"].minimal-red').iCheck({
                checkboxClass: 'icheckbox_minimal-red'
            });
            
            $("#menu_form").modal("show");
        }, 'json');

    }

    function Create() {
        $.post("<?= base_url() ?>Parameters/Client/C_Client/NewClient", {type:'<?=$type?>'}, function (data) {
            $('#body-edit').html(data.modalCreate);
            $('input[type="checkbox"].minimal-red').iCheck({
                checkboxClass: 'icheckbox_minimal-red'
            });
            
            $("#menu_form").modal("show");
        }, 'json');
    }

    function UpdateClient(id_client) {
        var error = false;
        $(".required").each(function () {
            if (!ValidateInput($(this).attr("id"))) {
                error = true;
            }
        });
        if (!error) {
            var formData = new FormData($('#form-edit')[0]);
            
            if($('#ck-cl').is(':checked')){
                formData.append("cliente", 1);
            }else{
                formData.append("cliente", 0);
            }
            if($('#ck-pv').is(':checked')){
                formData.append("proveedor", 1);
            }else{
                formData.append("proveedor", 0);
            }
            
            var obligaciones = "";
            $.each($("#obligaciones").val(), function (e, i) {
                if (obligaciones != "") {
                    obligaciones += ",";
                }
                obligaciones += i;
            });
            
            formData.append("obligaciones", obligaciones);
            formData.append("id_client", id_client);
            $.ajax({
                url: "<?= base_url() ?>Parameters/Client/C_Client/UpdateClient",
                type: 'POST',
                data: formData,
                async: false,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        swal({
                            title: 'Operacion Exitosa!',
                            text: "Registro Actualizado.",
                            type: 'success'
                        }).then((result) => {
                            $("#menu_form").modal("hide");
                            Cargar_Tabla();
                            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Create()" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-user-plus"></i> Crear</span></a></label>');
                        });
                    } else {
                        swal({title: 'Error!', text: obj.res, type: 'error'});
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    }

    function CreateClient() {
        var error = false;
        $(".required").each(function () {
            if (!ValidateInput($(this).attr("id"))) {
                error = true;
            }
        });
        if (!error) {
            var formData = new FormData($('#form-create')[0]);
            
            if($('#ck-cl').is(':checked')){
                formData.append("cliente", 1);
            }else{
                formData.append("cliente", 0);
            }
            if($('#ck-pv').is(':checked')){
                formData.append("proveedor", 1);
            }else{
                formData.append("proveedor", 0);
            }
            
            var obligaciones = "";
            $.each($("#obligaciones").val(), function (e, i) {
                if (obligaciones != "") {
                    obligaciones += ",";
                }
                obligaciones += i;
            });
            
            formData.append("obligaciones", obligaciones);
            
            $.ajax({
                url: "<?= base_url() ?>Parameters/Client/C_Client/CreateClient",
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
                            
                            $("#menu_form").modal("hide");
                            Cargar_Tabla();
                            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Create()" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-user-plus"></i> Crear</span></a></label>');

                        });
                    } else {
                        swal({title: 'Error!', text: obj.res, type: 'error'});
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    }

    function Delete(id_client, titulo) {
        swal({
            title: 'Esta seguro de eliminar el Cliente ' + titulo + '!',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar!'
        }).then((result) => {
            if (result) {
                $.post("<?= base_url() ?>Parameters/Client/C_Client/DeleteClient", {id_client: id_client}, function (data) {
                    if (data.res == "OK") {
                        swal('Operacion Exitosa!', 'El registro ha sido eliminado.', 'success').then((result) => {
                           Cargar_Tabla();
                            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Create()" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-user-plus"></i> Crear</span></a></label>');

                        });
                    } else {
                        swal({title: 'Error!', text: data, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    if (error.status == 200) {
                        RedirectLogin();
                    } else {
                        swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                    }
                });

            }
        }).catch(swal.noop)
    }
    
    function addmore(tipo,cliente){
    
        if(tipo == 1){
            var controller = 'ShowCampana';
            var title = 'Campaña';
        }else{
            var controller = 'ShowProducto';
            var title = 'Producto';
        }
    
        $.post("<?= base_url() ?>Parameters/Client/C_Client/"+controller, {cliente:cliente,title:title}, function (data) {
            $('#body-more').html(data.res);
            $("#more_form").modal("show");
        }, 'json');
    }
    
    function Cargar_Tabla() {
        if ($.fn.DataTable.isDataTable('#tabla_clientes')) {
            $('#tabla_clientes').DataTable().destroy();
        }
    
        var type = '<?= $type ?>';
        var oTable = $('#tabla_clientes').dataTable({
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
                "url": "<?= base_url() ?>Parameters/Client/C_Client/GetListTable/" + type,
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
            }
//            , columnDefs: [
//                {className: "text-center ", targets: [0], width: '50px'},
//                {className: "text-center ", targets: [1], width: '60px'},
//                {className: "text-center", targets: [7]},
//                {className: "text-center td-estado", targets: [6],width: '95px'}
//            ],
        });
    

    }

</script>