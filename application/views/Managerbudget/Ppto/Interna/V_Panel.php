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
                <h3 class="box-title"><i class="fa fa-fw fa-table"></i> <?=$tittle?></h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12" id="content-table">
                        <table id="table_ppto" class="table table-bordered table-striped table-condensed ">
                            <thead>
                                <tr>
                                    <th style="text-align:center">Ppto</th>
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
<?php if($table == 4): ?>
    <div class="modal fade" id="modal-copy">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Duplicar Presupuestos</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Presupuestos</label>
                                <select class="form-control input-sm select2" multiple="" id="pptos" name="pptos" style="width:100%">
                                    <?php foreach ($pptos['result'] as $value) : ?>
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
<?php endif; ?>
<script>
    $(function () {
        Cargar_Tabla();
        <?php if(isset($BtnNewPpto)): ?>
            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="NewPpto()" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" ><span><i class="fa fa-user-plus"></i> Nuevo</span></a></label>');
        <?php endif; ?>
        <?php if($table == 4 && isset($BtnDupliPpto)): ?>
            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="OpenCopy()" class="btn btn-default btn-sm buttons-excel buttons-html5" ><span><i class="fa fa-copy"></i> Duplicar</span></a></label>');
        <?php endif; ?>
        
        $('#id_fecha').daterangepicker({format: 'YYYY-MM-DD'});
        $('.select2').select2({closeOnSelect: false});
    });

    function Filtrar() {
        $('#table_ppto').DataTable().destroy();
        $('#table_ppto > tbody').remove();
        Cargar_Tabla();
        <?php if(isset($BtnNewPpto)): ?>
            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="NewPpto()" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" ><span><i class="fa fa-user-plus"></i> Nuevo</span></a></label>');
        <?php endif; ?>
        <?php if($table == 4 && isset($BtnDupliPpto)): ?>
            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="OpenCopy()" class="btn btn-default btn-sm buttons-excel buttons-html5" ><span><i class="fa fa-copy"></i> Duplicar</span></a></label>');
        <?php endif; ?>
    }
    
    function OpenCopy(){
        $('.select2').val(null).trigger('change');
        $('#modal-copy').modal();
    }
    
    function CopyMasive(){
        var pptos = "";
        $.each($("#pptos").val(), function (e, i) {
            if (pptos != "") {
                pptos += ",";
            }
            pptos += i;
        });
        if(pptos != ''){
            $.post('<?= base_url() ?>Managerbudget/C_Ppto/CopyMasive',{pptos:pptos,tipo:<?= $table ?>},function(data){
                if(data.errors != ''){
                    swal({title: 'Error!', text: 'Los presupuestos '+data.errors+' no fueron duplicados por que el cliente excede su credito.', type: 'warning'}).then((result) => {
                        location.reload();
                    })
                }else if(data.res == 'OK'){
                    $('#modal-copy').modal('hide');
                    alertify.success('OK');
                    Filtrar();
                }else{
                    swal({title: 'Error!', text: data.res, type: 'error'});
                }
            },'json');
        }
    }
    
    function EditPpto(id,tipo){
        switch(tipo){
            case 1:
                window.location.replace("<?= base_url() ?>Prensa/Edit/" + id + "/<?= $table ?>");
                break;
            case 2:
                window.location.replace("<?= base_url() ?>Clasificado/Edit/" + id + "/<?= $table ?>");
                break;
            case 3:
                window.location.replace("<?= base_url() ?>Revista/Edit/" + id + "/<?= $table ?>");
                break;
            case 4:
                window.location.replace("<?= base_url() ?>Radio/Edit/" + id + "/<?= $table ?>");
                break;
            case 5:
                window.location.replace("<?= base_url() ?>Tv/Edit/" + id + "/<?= $table ?>");
                break;
            case 6:
                window.location.replace("<?= base_url() ?>Externa/Edit/" + id + "/<?= $table ?>");
                break;
            case 7:
                window.location.replace("<?= base_url() ?>Interna/Edit/" + id + "/<?= $table ?>");
                break;
            case 8:
                window.location.replace("<?= base_url() ?>Exterior/Edit/" + id + "/<?= $table ?>");
                break;
            case 9:
                window.location.replace("<?= base_url() ?>Impreso/Edit/" + id + "/<?= $table ?>");
                break;
            case 10:
                window.location.replace("<?= base_url() ?>Articulo/Edit/" + id + "/<?= $table ?>");
                break;
        }
    }
    
    function NewPpto(){
        switch(<?= $table ?>){
            case 1:
                window.location.replace("<?= base_url() ?>Prensa/New/<?= $table ?>");
                break;
            case 2:
                window.location.replace("<?= base_url() ?>Clasificado/New/<?= $table ?>");
                break;
            case 3:
                window.location.replace("<?= base_url() ?>Revista/New/<?= $table ?>");
                break;
            case 4:
                window.location.replace("<?= base_url() ?>Radio/New/<?= $table ?>");
                break;
            case 5:
                window.location.replace("<?= base_url() ?>Tv/New/<?= $table ?>");
                break;
            case 6:
                window.location.replace("<?= base_url() ?>Externa/New/<?= $table ?>");
                break;
            case 7:
                window.location.replace("<?= base_url() ?>Interna/New/<?= $table ?>");
                break;
            case 8:
                window.location.replace("<?= base_url() ?>Exterior/New/<?= $table ?>");
                break;
            case 9:
                window.location.replace("<?= base_url() ?>Impreso/New/<?= $table ?>");
                break;
            case 10:
                window.location.replace("<?= base_url() ?>Articulo/New/<?= $table ?>");
                break;
        }
        
    }
    
    function  addOrder(id){
        
        swal({
            title: 'Agregar Orden de servicio',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Agregar',
            showLoaderOnConfirm: true,
            preConfirm: (order) => {
            return fetch('<?= base_url() ?>Managerbudget/C_Ppto/AddOrder/'+id+'/<?= $table ?>/'+order)
              .then(response => {
                if (!response.ok) {
                  throw new Error(response.statusText)
                }
                $('.btnI'+id).attr('order',order);
                alertify.success('OK');
                return response.json()
              })
              .catch(error => {
                Swal.showValidationMessage(
                  `Request failed: ${error}`
                )
              })
          },
          allowOutsideClick: () => !Swal.isLoading()
        });
        
        $('.swal2-input').val($('.btnI'+id).attr('order'));
    }
    
    function Anule(id){
        swal({
            title: 'Confirma la anulación del presupuesto '+id+'?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar!',
            reverseButtons: true
        }).then((result) => {
            if (result) {
                $.post('<?= base_url() ?>Managerbudget/C_Ppto/Anule',{ppto:id,tipo:<?= $table ?>,status:'9999'},function(data){
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
    
    function copy(id, cliente, total){
        swal({
            title: 'Confirma duplicar presupuesto '+id+'?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar!',
            reverseButtons: true
        }).then((result) => {
            if (result) {
                $.post('<?= base_url() ?>Managerbudget/C_Ppto/Copy',{ppto:id,tipo:<?= $table ?>,cliente:cliente,total:total,status:'9999'},function(data){
                    if(data.res == 'OK'){
                        alertify.success('OK');
                        Filtrar();
                    }else if(data.res == "LOCKED"){
                        swal({title: 'Warning!', text: data.msg, type: 'warning'});
                    }else{
                        swal({title: 'Error!', text: data.res, type: 'error'});
                    }
                },'json');
            }
        }, function (dismiss) {
            
        }).catch(swal.noop)
    }
    
    function printPdf(id,print_order){
        window.open('<?= base_url() ?>Managerbudget/C_Ppto/PrintPpto/'+id+'/<?= $table ?>/'+print_order, '_blank');
    }
    
    function Cargar_Tabla() {
        
        var type = '<?= $table ?>';
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
                "url": "<?= base_url() ?>Managerbudget/C_Ppto/GetListTable/" + type + '/' + id+ '/' + fecha_ini + '/' + fecha_fin + '/'+proveedor,
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
                {className: "text-center ", targets: [0], width: '50px'},
                {className: "text-center ", targets: [1], width: '60px'},
                {className: "text-center", targets: [7]},
                {className: "text-center td-estado", targets: [6],width: '95px'}
            ],
        });
    

    }

    function OpenPrint(id, url) {
        window.open('<?=base_url()?>MEDIOS/views/' + url + id);
    }
</script>
