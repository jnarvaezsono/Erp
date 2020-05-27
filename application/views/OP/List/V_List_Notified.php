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
                <h3 class="box-title"><i class="fa fa-fw fa-table"></i><?=$title?></h3><div class="pull-right"><button type="button" class="btn btn-default btn-sm" onclick="history.back()"><i  class="fa fa-fw fa-backward"></i> Atras</button> </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="input-group" style="margin-right: 5px"><span class="input-group-addon">OP</span><input type="text" id="id_op" class="form-control input-sm" onchange="Filtrar()" ></div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group" style="margin-right: 5px"><span class="input-group-addon">TAREA</span><input type="text" id="id_tarea" class="form-control input-sm" onchange="Filtrar()" ></div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <!--<label for="">Cliente</label>-->
                            <select class="form-control input-sm  select2" id="id_estado" onchange="Filtrar()" >
                                <option value="all">   ESTADO   </option>
                                <option value="PENDIENTE">PENDIENTE POR COBRAR</option>
                                <option value="VENCIDA">VENCIDAS</option>
                                <?php foreach ($estados as $v) : ?>
                                    <option value="<?= $v->id_status ?>"><?= $v->description ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <?php if($maestro == 'TRUE' ): ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <!--<label for="">Cliente</label>-->
                                <select class="form-control input-sm  select2" id="id_usuario" onchange="Filtrar()" >
                                    <option value="all">   RESPONSABLE   </option>
                                    <?php foreach ($usuarios as $v) : ?>
                                        <option value="<?= $v->id_users ?>"><?= $v->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php ENDIF; ?>
                    <div class="col-md-12" id="content-table">
                        <?= $table ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modal-time">
    <div class="modal-dialog" style="width: 281px;">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #3c8dbc; color: #fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">TIEMPO ESTIMADO INVERTIDO</h4>
            </div>
            <div class="modal-body">
                <div class="bootstrap-timepicker">
                    <div class="form-group">
                        <label>Horas</label>
                        <div class="input-group">
                            <input type="number" class="form-control timepicker " id="tiempo1" name="tiempo1" value="0">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bootstrap-timepicker">
                    <div class="form-group">
                        <label>Minutos</label>
                        <div class="input-group">
                            <input type="number" class="form-control timepicker " id="tiempo2" name="tiempo2" value="0">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default " data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary pull-right" id="addtime">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        Cargar_Tabla();
        $('.select2').select2();
    });
    
    function OpenModal(task){
        $("#modal-time").modal('show');
        $("#addtime").attr('onclick','AddTime('+task+')');
    }
    
    function AddTime(task){
        if(validatefield('timepicker')){
            
            var hora = $('#tiempo1').val()+':'+$('#tiempo2').val();
            
            $.post('<?= base_url()?>OP/C_OP/AddTime',{id_tarea:task,hora:hora},function(data){
                if(data.res == 'OK'){
                    $('#time-'+task).html(' '+hora).removeAttr('onclick');
                    $("#modal-time").modal('hide');
                }
            },'json');
        }
    }

    function OpenTask(tarea) {
        window.location.href = '<?= base_url() ?>OP/C_OP/Task/' + tarea
    }

    function Filtrar() {
        $('#table_task').DataTable().destroy();
        $('#table_task > tbody').remove();
        Cargar_Tabla();
    }

    function Cargar_Tabla() {

        var op = $("#id_op").val();
        var tarea = $("#id_tarea").val();
        var estado = $("#id_estado").val();
        var usuario = $("#id_usuario").val();
        
        if (usuario  == null){
            usuario = "all";
        }
        
        if (op == "") {
            op = "all";
        }
        if (tarea == "") {
            tarea = "all";
        }
        if (usuario == "") {
            usuario = "all";
        }

        var maestro = '<?=$maestro?>';
        var oTable = $('#table_task').dataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 100,
            "scrollY": "400px",
            "lengthChange": false,
            "searching": false,
            "ajax": {
                "url": "<?= base_url() ?>OP/C_OP/ListarTasksFilterNotified/" + op + '/' + tarea + '/' + estado + '/'+ usuario+'/'+maestro,
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
                {className: "text-center idtask", targets: [3]},
                {targets: 10,render: function ( data, type, row ) {return data.substr( 0, 50 )}}
            ],
            "initComplete": function () {
                var api = this.api();
                api.$('tr').dblclick( function () {
                    window.location = "<?= base_url() ?>OP/C_OP/Task/" + $(this).find('.idtask').text();
                } );
            }
        });
    }
</script>