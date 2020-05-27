<style>
    .text-yellow{
        margin-left: 4px;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Helpdesk
            <small>sonovista</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <a  class="btn btn-primary btn-block margin-bottom" id="add">Crear Ticket</a>
                <div class="box box-solid" id="left">                    
                    <?= $left ?>
                </div>
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Estados</h3>
                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked">
                            <li><a ><i class="fa fa-circle" style="color: #b5bbc8;"></i> Anulado</a></li>
                            <li><a ><i class="fa fa-circle" style="color: #f39c12;"></i> Pendiente</a></li>
                            <li><a ><i class="fa fa-circle" style="color: #269e3a;"></i> Resuelto</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Ticket List</h3>

                        <div class="btn-group pull-right">
                            <button type="button" class="btn btn-default btn-sm" onclick="deleteOption()" title="Anular Ticket"><i class="fa fa-trash-o"></i></button>
                            <?php if (isset($BtnFinTicket)): ?>
                                <button type="button" class="btn btn-default btn-sm" onclick="EndTicket()" title="Finalizar Ticket"><i class="fa fa-thumbs-o-up"></i></button>
                            <?php else: ?>
                                <button type="button" class="btn btn-default btn-sm" disabled title="Finalizar Ticket"><i class="fa fa-thumbs-o-up"></i></button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <div class="table-responsive mailbox-messages">
                            <?= $right ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modal-new">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nuevo Ticket</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form role="form" id="form" method="POST" enctype="multipart/form-data">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tipo Servicio</label>
                                <select class="form-control input-sm select2 input-new"  name="tipo" style="width:100%">
                                    <option value="">. . .</option>
                                    <option value="CONEXION DE RED">CONEXION DE RED</option>
                                    <option value="EMAIL">EMAIL</option>
                                    <option value="IMPRESORA">IMPRESORA</option>
                                    <option value="HARDWARE">HARDWARE</option>
                                    <option value="SOFTWARE">SOFTWARE</option>
                                    <option value="OTRO">OTRO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Area</label>
                                <select class="form-control input-sm select2 input-new"  name="id_area" style="width:100%">
                                    <option value="">. . .</option>
                                    <?php foreach ($areas as $v) : ?>
                                        <option value="<?=$v->id_area?>"><?=$v->descripcion?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Prioridad</label>
                                <select class="form-control input-sm select2"  name="prioridad" style="width:100%">
                                    <option value="3">ALTA</option>
                                    <option value="2">MEDIA</option>
                                    <option value="1" selected>BAJA</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Breve Descripción</label>
                                <textarea type="text" class="form-control input-sm input-new" rows="2"  name="descripcion" ></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary pull-right" onclick="saveNew()" id="create"><i class="fa fa-save"></i> Crear</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-update">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="title-ticket"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form role="form" id="form-update" method="POST" enctype="multipart/form-data">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tipo Servivio</label>
                                <select class="form-control input-sm select2 input-update"  id="tipo" name="tipo" style="width:100%" onchange="loadDetaill(this.value,false)">
                                    <option value="">. . .</option>
                                    <option value="CONEXION DE RED">CONEXION DE RED</option>
                                    <option value="EMAIL">EMAIL</option>
                                    <option value="IMPRESORA">IMPRESORA</option>
                                    <option value="HARDWARE">HARDWARE</option>
                                    <option value="SOFTWARE">SOFTWARE</option>
                                    <option value="OTRO">OTRO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Area</label>
                                <select class="form-control input-sm select2 input-update" id="id_area" name="id_area" style="width:100%">
                                    <option value="">. . .</option>
                                    <?php foreach ($areas as $v) : ?>
                                        <option value="<?=$v->id_area?>"><?=$v->descripcion?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Prioridad</label>
                                <select class="form-control input-sm select2 input-update" id="prioridad" name="prioridad" style="width:100%">
                                    <option value="3">ALTA</option>
                                    <option value="2">MEDIA</option>
                                    <option value="1" selected>BAJA</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Breve Descripción</label>
                                <textarea type="text" class="form-control input-sm input-update" rows="5" id="descripcion" name="descripcion" ></textarea>
                            </div>
                        </div>
                        <?php if(groupSystem($this->session->IdRol)): ?>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Detalle De Servivio</label>
                                    <select class="form-control input-sm select2 input-update"  id="subservicio" name="subservicio" style="width:100%">
                                        <option value="">. . .</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Observación</label>
                                    <textarea type="text" class="form-control input-sm input-update" rows="6" id="observacion" name="observacion" ></textarea>
                                </div>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        
        Cargar_Tabla();
        $('#add').click(function () {
                $.post('<?= base_url() ?>Help/C_Help/GetTicketNotQualified',{},function(data){
                    if(data.res > 0){
                        swal({title: 'Atención!', text: 'Aún tienes Tickets por calificar', type: 'warning'});
                    }else{
                        $('#modal-new').modal();
                    }
                },'json');
            });
    });
    
    function loadDetaill(servicio, sub){
        $.post('<?= base_url() ?>Help/C_Help/Loadsubservices',{servicio:servicio},function(data){
            var option = '<option>. . .</option>';
            $.each(data.res,function(e,i){
                option += '<option value="'+i.descripcion+'">'+i.descripcion+'</option>';
            });
            $('#subservicio').html(option);
            
            if(sub){
                $('#subservicio').val(sub);
            }
        },'json');
    }
    
    function EndTicket(){
        var array_ck = [];
        $("input:checked").each(function() {
            array_ck.push($(this).val());
        });
        if(array_ck.length > 0){
            $.post('<?= base_url() ?>Help/C_Help/CancelAndAprobe',{tickets:array_ck,field:'id_estado',valor:26},function(data){
                if(data.res == 1){
                    alertify.success('OK');
                    Cargar_Tabla();
                    $('#left').html(data.indicator);
                }else{
                    alertify.error('ERROR '.data.res);
                }
            },'json');
        }else{
            alertify.error('DEBE SELECCIONAR UN TICKET');
        }
    }
    
    function qualify(num,id,a){
        if(id == 0){
            swal({title: 'Atención!', text: 'Solo puedes calificar tareas propias', type: 'warning'});
        }else{
            $.post('<?= base_url() ?>Help/C_Help/qualify',{id:id,field:'calificacion',valor:num},function(data){
                if(data.res == 1){
                    alertify.success('OK');
                    var stars = '';
                    for (var i = 1; i <= num; i++) {
                        stars += '<a href="#"><i class="fa fa-star text-yellow"></i></a>';
                    }
                    var rse = 5 - num;
                    for (var i = 1; i <= rse; i++) {
                        stars += '<a href="#"><i class="fa fa-star-o text-yellow"></i></a>';
                    }
                        
                    $(a).parent('td').html(stars);
                    $('#left').html(data.indicator);
                }else{
                    alertify.error('ERROR '.data.res);
                }
            },'json');
        }
    }
    
    function deleteOption(){
        var array_ck = [];
        $("input:checked").each(function() {
            array_ck.push($(this).val());
        });
        if(array_ck.length > 0){
            $.post('<?= base_url() ?>Help/C_Help/CancelAndAprobe',{tickets:array_ck,field:'id_estado',valor:4},function(data){
                if(data.res == 1){
                    alertify.success('OK');
                    Cargar_Tabla();
                    $('#left').html(data.indicator);
                }else{
                    alertify.error('ERROR '.data.res);
                }
            },'json');
        }else{
            alertify.error('DEBE SELECCIONAR UN TICKET');
        }
    }
    
    function openDetail(id,estado){
        $.post('<?= base_url() ?>Help/C_Help/openDetail',{id:id},function(data){
            if(data.num > 0){
                loadDetaill(data.row.tipo,data.row.subservicio);
                $('#title-ticket').html('Ticket N&deg; '+id);
                
                $('#tipo').val(data.row.tipo);
                $('#prioridad').val(data.row.prioridad);
                $('#id_area').val(data.row.id_area);
                $('#descripcion').val(data.row.descripcion);
                $('#observacion').val(data.row.observacion);
                
                
                if(estado == 25){
                    $('.input-update').attr('disabled',false);
                    $('.input-update').attr('onchange','Update('+id+',this)');
                }else{
                    $('.input-update').attr('disabled',true);
                    <?php if(groupSystem($this->session->IdRol)): ?>
                        $('#tipo').attr('disabled',false);
                    <?PHP endif; ?>
                }
                
                $('#tipo').attr('onchange','Update('+id+',this);loadDetaill(this.value,false)');
                
                $('#subservicio, #observacion').attr('disabled',false);
                $('#subservicio, #observacion').attr('onchange','Update('+id+',this)');
                
                $('#modal-update').modal();
            }
        },'json');
    }
    
    function Update(id,input){
        var field = $(input).attr('id');
        var valor = $(input).val();
        
        $.post('<?= base_url() ?>Help/C_Help/Update',{id:id,field:field,valor:valor},function(data){
            if(data.res == 1){
                if(field == 'subservicio'){
                    $('#war-'+id).hide();
                }
                alertify.success('OK');
            }else{
                alertify.error('ERROR');
            }
        },'json');
    }

    function saveNew() {
        if (validatefield('input-new')) {
            var formData = new FormData($('#form')[0]);
            formData.append("id_user", '<?=$this->session->IdUser?>');
            formData.append("id_user_mod", '<?=$this->session->IdUser?>');
            formData.append("id_estado", '25');
            $.ajax({
                url: "<?= base_url() ?>Help/C_Help/NewT",
                type: 'POST',
                data: formData,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        Cargar_Tabla();
                        $('#left').html(obj.indicator);
                        $('#modal-new').modal('hide');
                        $('#form')[0].reset();
                        swal({title: 'OK!', text: '', type: 'success'});
                    } else {
                        swal({title: 'Error!', text: obj.res, type: 'error'});
                    }
                },
                global: true,
                cache: false,
                contentType: false,
                processData: false
            });
        }
    }

    function Cargar_Tabla() {
    
        if ($.fn.DataTable.isDataTable('#table-ticket')) {
            $('#table-ticket').DataTable().destroy();
        }

        var oTable = $('#table-ticket').dataTable({
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
                "url": "<?= base_url() ?>Help/C_Help/GetListTable",
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
                {className: "text-center ", targets: [0], width: '30px'},
//                {className: "text-center ", targets: [1], width: '60px'},
//                {className: "text-center", targets: [7]},
//                {className: "text-center td-estado", targets: [6],width: '95px'}
            ],
        });

    }
</script>