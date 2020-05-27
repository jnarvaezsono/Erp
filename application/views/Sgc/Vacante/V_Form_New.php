<style>
    .nav-tabs-custom>.nav-tabs>li.active {
        border-top-color: #d2d6de;
    }
    .form-horizontal .control-label {
        text-align: left;
    }
    .box-title {
        font-size: 12px !important;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1 id="titulo">
            <i class="fa fa-edit"></i>Solictud Vacante
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Gestion Calidad</a></li>
            <li><a href="<?= base_url() ?>GetTableFormat/<?= $tipo ?>">Listar</a></li>
            <li class="active">Crear</li>
        </ol>
    </section>
    <section class="content">
        <form id="form">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h4 class="box-title">1. ESPECIFICACIONES DE LA VACANTE </h4>
                </div>
                <div class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Nombre de la vacante</label>
                            <select class="form-control input-sm  "  required id="" name="nombre_vacante" >
                                <option value="" selected>. . .</option>
                                <?php foreach($cargos as $v): ?>
                                    <option value="<?=$v->cargo?>"><?=$v->cargo?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Ingreso mensual</label>
                            <input type="number" class="form-control input-sm "  required id="" name="ingresos">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Motivo de la vacante</label>
                            <select class="form-control input-sm  "  required id="" name="motivo_vacante" onchange="showHide(this.value, 'ingreso_mensual', 'div-ingreso', 'ingreso_otro')">
                                <option value="NUEVO PUESTO DE TRABAJO" selected>NUEVO PUESTO DE TRABAJO</option>
                                <option value="REEMPLAZO">REEMPLAZO</option>
                                <option value="OTRO">OTRO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 div-ingreso" style="display:none">
                        <div class="form-group">
                            <label for="">Cual Otro?</label>
                            <input type="text" class="form-control input-sm" id="ingreso_otro" name="ingreso_otro">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Fecha prevista de ingreso</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control  input-sm date"  required id="" name="fecha_ingreso"  autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label style="display: block;">Delegado Olimpica</label>
                            <input type="checkbox" id="delegado"  >
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Funciones y responsabilidades</label>
                            <textarea type="text" class="form-control input-sm" required  rows="3" id="" name="funciones" ></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box box-success">
                <div class="box-header with-border">
                    <h4 class="box-title">2. REQUISITOS DEL ASPIRANTE  </h4>
                </div>
                <div class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Formación academica</label>
                            <select class="form-control input-sm  " required id="" name="formacion">
                                <option value=". . ." > . . .</option>
                                <option value="DOCTORADO">DOCTORADO</option>
                                <option value="ESPECIALISTA">ESPECIALISTA</option>
                                <option value="MAGISTER">MAGISTER</option>
                                <option value="PROFESIONAL">PROFESIONAL</option>
                                <option value="TECNICO">TECNICO</option>
                                <option value="TEGNOLOGO">TEGNOLOGO</option>
                                <option value="UNIVERSITARIA">UNIVERSITARIA</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Experiencia minima(Años)</label>
                            <input type="number" class="form-control input-sm" id="" name="experiencia">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Conocimientos especificos</label>
                            <textarea type="text" class="form-control input-sm" required rows="3" id="" name="conocimientos" ></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Manejo de herramientas</label>
                            <textarea type="text" class="form-control input-sm" rows="3" id="" name="herramientas" ></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box box-success">
                <div class="box-header with-border">
                    <h4 class="box-title">3. ACCESO A LOS SISTEMAS</h4>
                </div>
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><input type="checkbox" id="pc"  checked> Equipo de computo </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><input type="checkbox" id="puesto_trabajo" class="flat-red" checked> Puesto Trabajo </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><input type="checkbox" id="email" class="flat-red" > Correo electronico </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><input type="checkbox" id="carpetas_red" class="flat-red" > Carpetas compartidas</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><input type="checkbox" id="erp" class="flat-red" > Sistema ERP</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><input type="checkbox" id="sap" class="flat-red" > Sap </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><input type="checkbox"  id="adobe" class="flat-red" > Adobe </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> <input type="checkbox" id="vpn" class="flat-red" > Vpn </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><input type="checkbox" id="ftp" class="flat-red" > Ftp </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label >
                                <input type="radio" name="tipo_pc" class="flat-rad" value="Desktop Mac">
                                Desktop Mac
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label >
                                <input type="radio" name="tipo_pc" class="flat-rad" value="Laptop Mac" >
                                Laptop Mac
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label >
                                <input type="radio" name="tipo_pc" class="flat-rad" value="Desktop Win" >
                                Desktop Win
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label >
                                <input type="radio" name="tipo_pc" class="flat-rad" value="Laptop Win">
                                Laptop Win
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>En caso de ser un nuevo ingreso especifique los modulos del sistema ERP y/o SAP a los que tendra acceso</label>
                            <textarea type="text" class="form-control input-sm" rows="3" id="" name="modulos" ></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box box-success">
                <div class="box-header with-border">
                    <h4 class="box-title">4. OBSERVACIONES</h4>
                </div>
                <div class="box-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Observaciones</label>
                            <textarea type="text" class="form-control input-sm" rows="3" id="" name="observaciones" ></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </section>
</div>

<script>
    $(function () {
        $('.date').datepicker({
            format: 'yyyy-mm-dd',
            orientation: 'bottom'
        });

        $('input[type="checkbox"].flat-red, input[type="radio"].flat-rad').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });
        
        $('#delegado').iCheck({
            checkboxClass: 'icheckbox_flat-green',
        });

        $('#pc').iCheck({
            checkboxClass: 'icheckbox_flat-green',
        }).on('ifChecked', function (event) {
            $('.flat-rad').prop('disabled', false).iCheck('update');
        }).on('ifUnchecked', function (event) {
            $('.flat-rad').prop('checked', false);
            $('.flat-rad').prop('disabled', true).iCheck('update');
        });

        $("#form ").submit(function (event) {
            event.preventDefault();
            save();
        });
    });

    function save() {

        var formData = new FormData($('#form')[0]);
        formData.append("tipo", <?= $tipo ?>);

        $('.flat-red').each(function () {
            if ($(this).is(':checked')) {
                formData.append($(this).attr('id'), 1);
            }
        });
        
        if ($('#pc').is(':checked')) {
            formData.append('pc', 1);
        }
        
        if ($('#delegado').is(':checked')) {
            formData.append('delegado', 1);
        }
        
        $.ajax({
            url: "<?= base_url() ?>Sgc/C_Sgc/InsertInfo",
            type: 'POST',
            data: formData,
            success: function (data) {
                var obj = jQuery.parseJSON(data);
                if (obj.res == "OK") {
                    $('#form')[0].reset();
                    swal({title: 'OK!', text: '', type: 'success'}).then((result) => {
                        if (result) {
                             $('html, body').animate({scrollTop:0}, 1250);
                        }
                    })
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

    function showHide(valor, input, div, input2) {
        switch (input) {
            case 'ingreso_mensual':
                if (valor == 'OTRO') {
                    $('.' + div).show();
                    $('#' + input2).show();
                } else {
                    $('.' + div).hide();
                    $('#' + input2).hide();
                }
                break;
        }

    }
    
    
</script>

