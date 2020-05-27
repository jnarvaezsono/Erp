<style>
    #table-task > tbody > tr{
        cursor: pointer;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Producción No <spam id="num-op"><?=$id_op?><div class="pull-right" id="div-status"> | <?=$info->description?></div></spam>
        </h1>
        
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-fw fa-user"></i> Información del cliente</h3>
            </div>
            <div class="box-body">
                <form role="form" id="form-op" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <?= $form ?>
                    </div>
                </form>
            </div>
        </div>
        <div class="row" id="content-table">
            <?= $tabla_tareas ?>
        </div>
    </section>
</div>
<?= $modal ?>

<div class="modal fade" id="modal-import">
    <div class="modal-dialog" style="    width: 233px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" >Importar Archivo</h4>
            </div>
            <div class="modal-body">
                
                    <form role="form" id="form-import" method="POST" enctype="multipart/form-data">
                        <div class="form-group " style="width: 200px;">
                            <label>Importar Excel</label>
                            <input class="" type="file" name="files[]" id="inport" >
                        </div>
                    </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn  btn-primary pull-right"  id="btn-up"  >Cargar</button>
            </div>
        </div>
    </div>
</div>

<script>
    var sw = false;
    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    
    $(function () {
        CKEDITOR.replace( 'descripcion', {
            filebrowserUploadUrl: '<?=base_url()?>C_Service/Upload',
            filebrowserBrowseUrl: '<?=base_url()?>C_Service/ShowFiles',
            filebrowserWindowWidth: '1000',
            filebrowserWindowHeight: '600'
        });
        
        if(<?=$info->id_estado?> != 1 && <?=$info->id_estado?> != 15){
            Lock();
            if(<?=$info->id_estado?> == 4){
                $(".icon-edit").attr("onclick","");
            }
        }
        
        $(".select2").select2();
        
        $('#inport').filer({
            showThumbs: true,
            addMore: false,
            allowDuplicates: false,
            extensions: ['gif','jpeg','jpg','png','xls','xlsx','csv','pdf','pptx','docx','pptx','zip','rar','7z','doc'],
        });
        
        $('#modal-task').on('shown.bs.modal', function (e) {
            $(".select-modal").select2();
            $(".responsable option:selected").prop("selected", false);
            $(".responsable").trigger('change');
            
            if(!sw){
                $('#filer_input').filer({
                    showThumbs: true,
                    addMore: true,
                    allowDuplicates: false,
                    extensions: ['gif','jpeg','jpg','png','xls','xlsx','csv','pdf','pptx','docx','pptx','zip','rar','7z','doc'],
                });
            }
            
            CKEDITOR.instances['descripcion'].destroy();
            $("#descripcion").val('');
            CKEDITOR.replace('descripcion', {
                startupFocus : true, 
                allowedContent: true,
                filebrowserUploadUrl: '<?=base_url()?>C_Service/Upload',
                filebrowserBrowseUrl: '<?=base_url()?>C_Service/ShowFiles',
                filebrowserWindowWidth: '1000',
                filebrowserWindowHeight: '600'
            });
            
            //CKEDITOR.instances['descripcion'].setData('');
            $('#filer_input').trigger("filer.reset");
            
            sw = true;
        });
      

        $('.picker').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
        $('.picker').datepicker('setDate',today);
        
        $(".trTask").dblclick(function() {
            window.location = "<?= base_url() ?>OP/C_OP/Task/" + $(this).attr('id');
        });
  
        $("#add-task").click(function () {
            $("#modal-task").modal("show");
            $(".task-required").val("").trigger('change');
            $(".notificados option:selected").prop("selected", false);
            $(".notificados").attr("name", "notificados[]").trigger('change');
            $("#btn-save-task").show();
            $('#content-area').html('');
            
        });

        $("#btn-save, #btn-update").click(function () {
            if (validatefield('required')) {
                var funcion = $(this).attr("name");
                var formData = new FormData($('#form-op')[0]);
                $.ajax({
                    url: "<?= base_url() ?>OP/C_OP/" + funcion,
                    type: 'POST',
                    data: formData,
                    async: false,
                    success: function (data) {
                        var obj = jQuery.parseJSON(data);
                        if (obj.res == "OK") {
                            swal({title: '', text: "", type: 'success'});
                            if (funcion == "CrearOp") {
                                $("#btn-save").hide();
                                $("#btn-update").attr("name", "ActualizarOp/" + obj.id);
                                $("#close").attr("onclick", "CloseOP(" + obj.id + ")");
                                $("#closeM").attr("onclick", "CloseOPMasiv(" + obj.id + ")");
                                $("#btn-import").attr("onclick", "openImport(" + obj.id + ")");
                                $("#anule").attr("onclick", "AnuleOP(" + obj.id + ")");
                                $("#btn-save-task").attr("onclick", "SaveTask(" + obj.id + ")");
                                $("#btn-update, #add-task, #close, #closeM, #anule, #btn-import").show();
                                $("#content-table").html(obj.tabla_tareas);
                                $("#num-op").html(obj.id);
                            }
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
            }else{
                alertify.error("DEBE LLENAR LOS CAMPOS EN ROJO");
            }
        });
    });
    
    function openImport(id_op){
        $('#modal-import').modal();
        $('#btn-up').attr('onclick','Upexcelfile('+id_op+')');
    }
    
    function Upexcelfile(id_op){
        $('#modal-import').modal('hide');
        var formData = new FormData($('#form-import')[0]);
        formData.append('id_op',id_op);
        $.ajax({
            url: "<?= base_url() ?>OP/C_OP/Upexcelfile",
            type: 'POST',
            data: formData,
            async: false,
            success: function (data) {
                var obj = jQuery.parseJSON(data);
                if (obj.res == "OK") {
                    if(obj.opcion[1] == 0){
                        if(obj.opcion[0].length <= 0 ){
                            swal({title: 'Atención!', text: 'El archivo esta vacio', type: 'warning'});
                        }else{
                            var texto ='';
                            $.each(obj.opcion[0],function(e,i){
                                texto += i+' - ';
                            });
                            swal({title: 'Atención!', text: texto, type: 'warning'});
                        }
                    }else{
                        location.href = "<?= base_url()?>OP/C_OP/Info/"+id_op;
                    }
                } else {
                    swal({title: 'Error!', text: obj.res, type: 'error'});
                }
            },
            global: true,
            cache: false,
            contentType: false,
            processData: false
        }).fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
            
    }
    
    function AnuleOP(id_op){
        swal({
            title: 'Confirma la anulación de la OP?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3c8dbc',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar!'
        }).then((result) => {
            if (result) {
                $(".loader_ajax2").text("Enviado Notificación");
                $.post("<?= base_url() ?>OP/C_OP/AnuleOP", {id_op:id_op}, function (data) {
                    if (data.res == "OK") {
                        Lock();
                        $("#div-status").html('| ANULADA');
                        $(".icon-edit").attr("onclick","");
                        swal({title: '', text: '', type: 'success'});
                    } else if(data.res == "TASK-ACTIVE") {
                        swal({title: 'Error!', text: "Aún existen tareas de la OP que no han sido finalizadas", type: 'error'});
                    } else if(data.res == "TASK-CLOSE") {
                        swal({title: 'Error!', text: "Esta OP tiene tareas ya finalizadas por lo tanto no se puede anular esta orden", type: 'error'});
                    } else {
                        swal({title: 'Error!', text: data, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            }
        }).catch(swal.noop)
    }
    
    function CloseOPMasiv(id_op){
        swal({
            title: 'Confirma el cierre de la OP?',
            text: "Al realizar un cierre masivo se finalizan todas las tareas que tenga la orden de producción",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3c8dbc',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar!'
        }).then((result) => {
            if (result) {
                $(".loader_ajax2").text("Enviado Notificación");
                $.post("<?= base_url() ?>OP/C_OP/CloseOPMasiv", {id_op:id_op}, function (data) {
                    if (data.res == "OK") {
                        Lock();
                        $("#div-status").html('| CERRADA');
                        swal({title: '', text: '', type: 'success'});
                    } else if(data.res == "TASK-TV") {
                        swal({title: 'Error!', text: "Esta opción solo esta habilitada para op de tv", type: 'error'});
                    } else {
                        swal({title: 'Error!', text: data, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            }
        }).catch(swal.noop)
    }
    
    function CloseOP(id_op){
        swal({
            title: 'Confirma el cierre de la OP?',
            text: "Al cerrar la OP, esta no podra ser modificada y se dara por finalizada",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3c8dbc',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar!'
        }).then((result) => {
            if (result) {
                $(".loader_ajax2").text("Enviado Notificación");
                $.post("<?= base_url() ?>OP/C_OP/CloseOP", {id_op:id_op}, function (data) {
                    if (data.res == "OK") {
                        Lock();
                        $("#div-status").html('| CERRADA');
                        swal({title: '', text: '', type: 'success'});
                    } else if(data.res == "TASK-ACTIVE") {
                        swal({title: 'Error!', text: "Aún existen tareas de la OP que no han sido finalizadas", type: 'error'});
                    } else {
                        swal({title: 'Error!', text: data, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            }
        }).catch(swal.noop)
    }
    
    function Lock() {
        $(".btn-default").attr("disabled", true);
        $(".form-control").attr("disabled", true);
    }

    function LoadForm(categoria) {
        var form = $("#id_categoria option:selected ").attr('form');
        if (categoria != '' && categoria != 16) {
            $.post("<?= base_url() ?>OP/C_OP/CargarFormulario", {form: form, id_categoria: categoria, option:"create"}, function (data) {
                $("#content-form").html(data.form);
                $(".select-modal-form").select2();
                $('.picker-task').datepicker({
                    autoclose: true,
                    format: 'yyyy-mm-dd'
                });
                $('.picker-task').datepicker('setDate',today);
                $('.timepicker').timepicker({
                    showInputs: false
                });
            }, 'json');
        } else {
            $("#content-form").html('');
        }
    }
    
    function ShowCampana(valor){
        $("#new_campana").val('');
        if(valor == "NEW"){
            $("#new_campana").addClass('required');
            $("#group-campana").show();
        }else{
            $("#new_campana").removeClass('required');
            $("#group-campana").hide().removeClass('required');
        }
    }
    
    function ShowProducto(valor){
        $("#new_producto").val('');
        if(valor == "NEW"){
            $("#new_producto").addClass('required');
            $("#group-producto").show();
        }else{
            $("#new_producto").removeClass('required');
            $("#group-producto").hide().removeClass('required');
        }
    }

    function ListarDatosForm(cliente) {
        $.post("<?= base_url() ?>OP/C_OP/ListarDatosForm", {id_cliente: cliente}, function (data) {

            var option = '<option value="" >. . .</option>';
            option += '<option value="NEW"> CREAR NUEVA</option>';
            $.each(data.campanas, function (e, i) {
                option += '<option value="' + i.camp_id + '">' + i.camp_nombre + '</option>';
            });
            $("#campana").html(option).trigger('change');

            var option = '<option value="">. . .</option>';
            if(cliente != 1339){
                option += '<option value="NEW"> CREAR NUEVO</option>';
            }
            $.each(data.rubros, function (e, i) {
                option += '<option value="' + i.pdcl_id + '">' + i.pdcl_nombre + '</option>';
            });
            $("#rubro").html(option).trigger('change');

           
        }, 'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }
    
    function copydescription(){
        CKEDITOR.instances['descripcion'].setData(localStorage.getItem('descripcion'));
        //$('#id_categoria').val(localStorage.getItem('id_categoria')).trigger('change');
        
    }

    function SaveTask(id_op) {
        if (validatefield('task-required')) {
            
            if(CKEDITOR.instances['descripcion'].getData() == '') {
                $("#descripcion").parents(".form-group").addClass("has-error").removeClass("has-success");
                return false;
            }else{
                $("#descripcion").parents(".form-group").removeClass("has-error");
            }
            
            if($('#id_categoria').val() == 16 && $('#filer_input').val() == ''){
                swal({title: 'Alert!', text: 'Debes Adjuntar un Brief para fotografia', type: 'error'});
                return false;
            }
        
            $(".overlay_ajax").show();
            $(".loader_ajax2").text("Enviado Notificación");
            
            var arrayTask = [];
            
            
            var arrayChild = [];
            var txtresponsable = '';

            arrayChild.push($('#unidad').val()); //unidad 0
            arrayChild.push($('#fecha_entrega').val()); // 1  fecha
            arrayChild.push($('#modalidad_cobro').val()); // 2  modalidad
            arrayChild.push($('#area_responsable').val()); // 3  area
            arrayChild.push(CKEDITOR.instances['descripcion'].getData()); // 4  descripcion

            $.each($('#t_responsable').val(), function (e, i) {
                if (txtresponsable != "") {
                    txtresponsable += ",";
                }
                txtresponsable += i;
            });

            arrayChild.push(txtresponsable); // 5

            var notificados = "";
            $.each($("#notificados").val(), function (e, i) {
                if (notificados != "") {
                    notificados += ",";
                }
                notificados += i;
            });
            arrayChild.push(notificados); // 6
            
            if($('#id_categoria').val() == 15 || $('#id_categoria').val() == 17 || $('#id_categoria').val() == 14){
                var servicios = '';
                $.each($('#id_tarifa_servicio').val(), function (e, i) {
                    if (servicios != "") {
                        servicios += ",";
                    }
                    servicios += i;
                });
                 arrayChild.push(servicios); // 7
            }
            
            arrayTask.push(arrayChild);
            
            
            
            var myJSONText = JSON.stringify( arrayTask );
            
            
            var formData = new FormData();

            for (var i = 1; i < document.forms.length; i++) {
                var form = document.forms[i];
                if (form.className == "form-task" || form.className == "form-attach"){
                    var data = new FormData(form);
                    var formValues = data.entries()
                    while (!(ent = formValues.next()).done) {
                        localStorage.setItem(`${ent.value[0]}`, ent.value[1]);
                        formData.append(`${ent.value[0]}`, ent.value[1])
                    }
                }
            }
            
            formData.append("id_op", id_op);
            formData.append("arrayTask", myJSONText);
            $.ajax({
                url: "<?= base_url() ?>OP/C_OP/SaveTask",
                type: 'POST',
                data: formData,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    var error = '';
                   
                    var idtask = '';

                    $.each(obj,function(e,i){
                       if (obj[e].res == "OK") {
                            $('#modal-task').animate({
                                scrollTop: 0
                            }, 800);
                            if(idtask == ''){
                                idtask = obj[e].id;
                            }
                            $("#btn-save-task").hide();
                            $('.icon-jfi-trash').prop('disabled',true);
                            $('#table-task > tbody').append('<tr class="trTask" id="'+idtask+'"><td>' + obj[e].fecha_entrega + '</td><td>' + obj[e].creativo + '</td><td>' + obj[e].area + '</td><td style="text-align:left">' + obj[e].descripcion + '...</td><td style="padding: 0px;vertical-align: middle;"><img style="width:30px;margin-left:5px" src="<?=base_url()?>dist/img/icon-image/lima.png" /></td><td style="padding: 0px;vertical-align: middle;"><span class="label label-' + obj[e].id + ' label-success">ACTIVO(A)</span></td></tr>');
                            
                            $("#"+idtask).dblclick(function() {
                                window.location = "<?= base_url() ?>OP/C_OP/Task/" + idtask;
                            });
                            
                            $('#modal-task').modal('hide');
                            
                            localStorage.setItem('descripcion', CKEDITOR.instances['descripcion'].getData());
                            
                            
                        } else {
                            var error = obj[e].res;
                        } 
                    });
                    
                    if(error != ''){
                        swal({title: 'Error!', text: error, type: 'error'});
                    }else{
                        swal({title: '', text: "", type: 'success'});
                    }
                },
                global: true,
                cache: false,
                contentType: false,
                processData: false
            }).fail(function (error) {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            });
        }else{
            alertify.error("DEBE LLENAR LOS CAMPOS EN ROJO");
        }
    }
    
    function LoadCategoria(valor){
        var option = '<option value="">. . .</option>';
        
        if(valor != ""){
            
            $.post("<?= base_url() ?>OP/C_OP/LoadCategoria", {valor:valor}, function (data) {
               
                $.each(data.datos, function (e, i) {
                    option += '<option value="' + i.id_categoria + '">' + i.descripcion + '</option>';
                });

                $("#categoria").html(option).trigger('change');

            },'json');
        }else{
            $("#categoria").html(option).trigger('change');
        }
    }
    
    function LoadSelect(id,valor,complemento = false){
        var option = '<option value="">. . .</option>';
        
        if(id == 't_responsable'){
            valor = $('#unidad'+complemento+' option:selected ').attr('area');
            $('#area_responsable'+complemento).val(valor);
        }
        
        if(valor != ""){
            $.post("<?= base_url() ?>OP/C_OP/LoadSelect", {select: id,valor:valor}, function (data) {

                switch (id) {
                    case 't_programa':
                        $.each(data.datos, function (e, i) {
                            option += '<option value="' + i.progr_id + '">' + i.progr_nombre + '</option>';
                        });
                        break;
                    case 't_responsable':
                        $.each(data.datos, function (e, i) {
                            option += '<option value="' + i.id_users + '">' + i.name + '</option>';
                        });
                        break;

                    default:

                        break;
                }
                if(complemento){
                    $("#"+id+complemento).html(option).trigger('change');
                }else{
                    $("#"+id).html(option).trigger('change');
                }
                
            },'json');
        }else{
            $("#"+id).html(option).trigger('change');
        }
    }
    
    function ShowNewPieza(valor){
        if(valor == 'new'){
            $('#content-new-pieza').show();
            $('#tarifa_new').addClass('task-required');
        }else{
            $('#content-new-pieza').hide();
            $('#tarifa_new').removeClass('task-required');
        }
    }
    
    function ChargeCategory(valor){
        if(valor == '5' || valor == '4'){
            $("#id_categoria").val(15).trigger('change');
        }else if(valor == '1'){
            $("#id_categoria").val(17).trigger('change');
        }else{
            $("#id_categoria").val('').trigger('change');
        }
        
        var selectedValues = new Array();
    
        if(valor == '2' || valor == '3'){ //medios
            
            selectedValues[0] = "63";//Gisse
            selectedValues[1] = "62";//Mapi
            
            $('#notificados').select2('val', selectedValues);
            
        }else if(valor == '4'){ //creativos y digital
            
            selectedValues[0] = "85";//Miguel Gaviria
            
            $('#notificados').select2('val', selectedValues);
        }else if(valor == '5'){ //creativos y digital
            
            selectedValues[0] = "42";//Miguel Gaviria
            selectedValues[1] = "41";//Camilo
            
            $('#notificados').select2('val', selectedValues);
            
        }else if(valor == '1'){
            selectedValues[0] = "47";//Andres Beltran
            
            $('#notificados').select2('val', selectedValues);
        }
        
    }
</script> 