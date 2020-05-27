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
                <h3 class="box-title"><i class="fa fa-fw fa-table"></i> Consultar Orden-Presupuesto</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="input-group" style="margin-right: 5px"><span class="input-group-addon">N&deg;</span><input type="text" id="id" class="form-control" onchange=""  ></div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <!--<label for="">Cliente</label>-->
                            <select class="form-control  required select2" id="type"  >
                                <option value="">   CATEGORIA   </option>
                                <!--<option value="all">. . .</option>-->
                                <option value="orden">ORDEN PROVEEDOR</option>
                                <?php foreach ($type as $v) : ?>
                                    <option value="<?= $v->tabla ?>"><?= $v->descripcion ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 ">
                        <button type="button" class="btn btn-block btn-primary btn-sm" onclick="Filtrar()"><i class="fa fa-fw fa-search"></i> BUSCAR</button>
                    </div>
                    <div class="col-md-12" id="content-table">
                        <?= $table ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function () {


        $(".select2").select2();

    });

    function Filtrar() {
        if (ValidateInput('type')) {
            $('#table_type').DataTable().destroy();
            $('#table_type > tbody').remove();
            Cargar_Tabla();
        } else {
            alertify.error("SELECCIONE UNA CATEGORIA");
        }
    }

    function enable(table, id, field_id,field_status) {
        swal({
            title: 'Atención?',
            text: "Confirma la Activación del registro",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3c8dbc',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar!'
        }).then((result) => {
            if (result) {
                $.post("<?= base_url() ?>Managerbudget/C_Manager/EnableRow", {status: 1, table: table, id: id, field_id:field_id,field_status:field_status}, function (data) {
                    if (data.res == "OK") {
                        alertify.success("OK");
                        $("#btn-"+id).attr("class","fa fa-lock text-red")
                                .attr("onclick","disable('"+table+"', "+id+", '"+field_id+"','"+field_status+"')")
                                .attr("title","ACTIVAR");
                        $(".label-"+id).html('Activo').attr("class","label label-"+id+" label-primary");
                    } else {
                        alertify.error(data.res);
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            }
        }).catch(swal.noop)
    }

    function disable(table, id, field_id,field_status) {
        swal({
            title: 'Atención?',
            text: "Confirma la Anulación del registro",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3c8dbc',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar!'
        }).then((result) => {
            if (result) {
                $.post("<?= base_url() ?>Managerbudget/C_Manager/DisableRow", {status: 9999, table: table, id: id, field_id:field_id,field_status:field_status}, function (data) {
                    if (data.res == "OK") {
                        alertify.success("OK");
                        $("#btn-"+id).attr("class","fa fa-unlock text-aqua")
                                .attr("onclick","enable('"+table+"', "+id+", '"+field_id+"','"+field_status+"')")
                                .attr("title","ANULAR");
                        $(".label-"+id).html('Anulado').attr("class","label label-"+id+" label-danger");;
                    } else {
                        alertify.error(data.res);
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            }
        }).catch(swal.noop)
    }

    function Cargar_Tabla() {

        var id = $("#id").val();
        var table = $("#type").val();

        if (id == "") {
            id = "all";
        }


        var oTable = $('#table_type').dataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 50,
            "scrollY": "380px",
            "lengthChange": false,
            "searching": false,
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            "ajax": {
                "url": "<?= base_url() ?>Managerbudget/C_Manager/GetListTable/" + table + '/' + id,
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
                {className: "text-center ", targets: [0, 1, 4], width: '70px'},
                {className: "text-center", targets: [6]},
                {className: "text-center td-estado", targets: [5]}
            ],
        });

    }
    
    function OpenPrint(id,table,print_order){
        window.open('<?= base_url() ?>Managerbudget/C_Ppto/PrintPpto/'+id+'/'+table+'/'+print_order+'/'+0, '_blank');
    }
    
</script>
