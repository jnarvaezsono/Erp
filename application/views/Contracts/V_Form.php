<div class="content-wrapper">
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-fw fa-edit"></i> FORM CONTRATO </h3>
            </div>
            <div class="box-body">
                <form role="form" id="form" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Fec. Inicio:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control picker pull-right required" name="fecha_inicio" id="fecha_inicio">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Fec. Vencimiento:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control picker pull-right required" name="fecha_vencimiento" id="fecha_vencimiento">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tipo</label>
                                <select class="form-control select2 required" style="width: 100%;" name="tipo" id="tipo">
                                    <option value="">. . .</option>
                                    <option value="ACUERDO COMERCIAL">ACUERDO COMERCIAL</option>
                                    <option value="ACUERDO CONFIDENCIALIDAD">ACUERDO CONFIDENCIALIDAD</option>
                                    <option value="ACUERDO PROVEEDOR">ACUERDO PROVEEDOR</option>
                                    <option value="CONTRATO">CONTRATO</option>
                                    <option value="CONTRATO SENA">CONTRATO SENA</option>
                                    <option value="LICENCIA">LICENCIA</option>
                                    <option value="SUSCRIPCION">SUSCRIPCIÓN</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Numero Contrato</label>
                                <input type="text" class="form-control"  name="numero" id="numero" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Contra Parte</label>
                                <select class="form-control select2" style="width: 100%;" name="parte" id="parte">
                                    <option value="CLIENTE">CLIENTE</option>
                                    <option value="PROVEEDOR">PROVEEDOR</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Nombre Contra Parte</label>
                                <select class="form-control select2 required" style="width: 100%;" name="contra_parte" id="contra_parte">
                                    <option value="">. . .</option>
                                        <?php foreach ($clientes as $v) : ?>
                                            <option value="<?=$v->id_client?>"><?=$v->nombre?></option>
                                        <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Responsable</label>
                                <select class="form-control select2" style="width: 100%;" name="responsable" id="responsable">
                                    <option value="GERENCIA ADMINISTRATIVA">GERENCIA ADMINISTRATIVA</option>
                                    <option value="GERENCIA COMERCIAL">GERENCIA COMERCIAL</option>
                                    <option value="GERENCIA MEDIOS">GERENCIA MEDIOS</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Valor</label>
                                <input type="text" class="form-control numerico"  name="valor" id="valor" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Forma Pago</label>
                                <input type="text" class="form-control"  name="forma_pago" id="forma_pago" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipo Poliza</label>
                                <select class="form-control select2" style="width: 100%;" multiple name="tipo_poliza" id="tipo_poliza">
                                    <option value="">. . .</option>
                                    <option value="CUMPLIMIENTO" >CUMPLIMIENTO</option>
                                    <option value="RESPONSABILIDAD CIVIL">RESPONSABILIDAD CIVIL</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Emisor Poliza</label>
                                <input type="text" class="form-control"  name="emisor_poliza" id="emisor_poliza" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Obligaciones Contra Parte</label>
                                <textarea type="text" class="form-control" rows="2" name="obligaciones_contra_parte" id="obligaciones_contra_parte" ></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Obligaciones Sonovista</label>
                                <textarea type="text" class="form-control" rows="2"  name="obligaciones_sonovista" id="obligaciones_sonovista" ></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Objeto</label>
                                <textarea type="text" rows="2" class="form-control"  name="objeto" id="objeto" ></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Anexos</label>
                                <textarea type="text" rows="2" class="form-control"  name="anexos" id="anexos" ></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-default">Cancelar</button>
                <button type="submit" class="btn btn-default" id="list"><i class="fa fa-fw fa-list"></i> Listar</button>
                <button type="submit" class="btn btn-primary pull-right" id="save"><i class="fa fa-fw fa-save"></i> Guardar</button>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function () {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        
        $('.picker').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
        });
        
        $('.select2').select2();
        
        $('.numerico').autoNumeric('init', {
            mDec: 0,
            aDec: ',',
            aSep: '.'
        }); 
        
        $('#fecha_inicio').datepicker('setDate',today);
        
        $("#parte").change(function(){
            $.post('<?= base_url() ?>Contracts/C_Contracts/LoadClients',{parte:$('#parte').val()},function(data){
                var options = '<option value="">. . .</option>';
                $.each(data,function(e,i){
                    options += '<option value="'+i.id_client+'">'+i.nombre+'</option>';
                });
                $('#contra_parte').html(options);
            },'json');
        });

        $("#list").click(function () {
            window.location.href = '<?= base_url() ?>Contracts'
        });
        $("#save").click(function () {
            if (validatefield('required')) {
                $(".overlay_ajax").show();

                var formData = new FormData($('#form')[0]);
                $.ajax({
                    url: "<?= base_url() ?>Contracts/C_Contracts/Create",
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        var obj = jQuery.parseJSON(data);
                        if (obj.res == "OK") {
                            $("#form")[0].reset();
                            $('.select2').val('').trigger('change');
                            swal({title: 'OK!', text: '', type: 'success'});
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

            } else {
                alertify.error("DATOS INCOMPLETOS!");
            }
        });
    });
</script>
