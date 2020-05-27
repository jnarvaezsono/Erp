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
            <i class="fa fa-edit"></i> Solictud Vacante N° <?= $id ?>
            <small id="status"> <?= $row->estado ?> </small>
        </h1>
        <ol class="breadcrumb">
            <li onclick="back()"><a href="#" style="text-decoration: underline;color:orange;font-size: large;"><i class="fa fa-backward"></i> ATRAS</a></li>
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
                            <select class="form-control input-sm "  required id="" name="nombre_vacante" >
                                <option value="" selected>. . .</option>
                                <?php foreach($cargos as $v): ?>
                                    <option value="<?=$v->cargo?>" <?=($row->nombre_vacante == $v->cargo)?'selected':''?>><?=$v->cargo?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <?php if($row->id_usuario == $this->session->IdUser || in_array($this->session->IdRol, array(4,14,1))) :?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Ingreso mensual</label>
                            <input type="number" class="form-control input-sm "  required id="" name="ingresos" value="<?=$row->ingresos?>">
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Motivo de la vacante</label>
                            <select class="form-control input-sm  "  required id="" name="motivo_vacante" onchange="showHide(this.value, 'ingreso_mensual', 'div-ingreso', 'ingreso_otro')">
                                <option value="NUEVO PUESTO DE TRABAJO" <?=($row->motivo_vacante == 'NUEVO PUESTO DE TRABAJO')?'selected':''?>>NUEVO PUESTO DE TRABAJO</option>
                                <option value="REEMPLAZO" <?=($row->motivo_vacante == 'REEMPLAZO')?'selected':''?>>REEMPLAZO</option>
                                <option value="OTRO" <?=($row->motivo_vacante == 'OTRO')?'selected':''?>>OTRO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 div-ingreso" <?=($row->motivo_vacante == 'OTRO')?'':'style="display:none"'?> >
                        <div class="form-group">
                            <label for="">Cual Otro?</label>
                            <input type="text" class="form-control input-sm" id="ingreso_otro" name="ingreso_otro" value="<?=$row->ingreso_otro?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Fecha prevista de ingreso</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control  input-sm date"  required id="" name="fecha_ingreso" value="<?=$row->fecha_ingreso?>" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label style="display: block;">Delegado Olimpica</label>
                            <input type="checkbox" id="delegado" <?=($row->delegado == 1)?'checked':''?> >
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Funciones y responsabilidades</label>
                            <textarea type="text" class="form-control input-sm" required  rows="3" id="" name="funciones" ><?=$row->funciones?></textarea>
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
                                <option value="DOCTORADO" <?=($row->formacion == 'DOCTORADO')?'selected':''?>>DOCTORADO</option>
                                <option value="ESPECIALISTA" <?=($row->formacion == 'ESPECIALISTA')?'selected':''?>>ESPECIALISTA</option>
                                <option value="MAGISTER" <?=($row->formacion == 'MAGISTER')?'selected':''?>>MAGISTER</option>
                                <option value="PROFESIONAL" <?=($row->formacion == 'PROFESIONAL')?'selected':''?>>PROFESIONAL</option>
                                <option value="TECNICO" <?=($row->formacion == 'TECNICO')?'selected':''?>>TECNICO</option>
                                <option value="TEGNOLOGO" <?=($row->formacion == 'TEGNOLOGO')?'selected':''?>>TEGNOLOGO</option>
                                <option value="UNIVERSITARIA" <?=($row->formacion == 'UNIVERSITARIA')?'selected':''?>>UNIVERSITARIA</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Experiencia minima(Años)</label>
                            <input type="number" class="form-control input-sm" id="" name="experiencia" value="<?=$row->experiencia?>">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Conocimientos especificos</label>
                            <textarea type="text" class="form-control input-sm" required rows="3" id="" name="conocimientos" ><?=$row->conocimientos?></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Manejo de herramientas</label>
                            <textarea type="text" class="form-control input-sm" rows="3" id="" name="herramientas" ><?=$row->herramientas?></textarea>
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
                            <label><input type="checkbox" id="pc" <?=($row->pc == 1)?'checked':''?> > Equipo de computo </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><input type="checkbox" id="puesto_trabajo" class="flat-red" <?= ($row->puesto_trabajo == 1) ? 'checked' : '' ?>> Puesto Trabajo </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><input type="checkbox" id="email" class="flat-red" <?=($row->email == 1)?'checked':''?>> Correo electronico </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><input type="checkbox" id="carpetas_red" class="flat-red" <?=($row->carpetas_red == 1)?'checked':''?>> Carpetas compartidas</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><input type="checkbox" id="erp" class="flat-red" <?=($row->erp == 1)?'checked':''?>> Sistema ERP</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><input type="checkbox" id="sap" class="flat-red"  <?=($row->sap == 1)?'checked':''?>> Sap </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><input type="checkbox"  id="adobe" class="flat-red" <?=($row->adobe == 1)?'checked':''?>> Adobe </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> <input type="checkbox" id="vpn" class="flat-red"  <?=($row->vpn == 1)?'checked':''?>> Vpn </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><input type="checkbox" id="ftp" class="flat-red" <?=($row->ftp == 1)?'checked':''?>> Ftp </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label >
                                <input type="radio" name="tipo_pc" class="flat-rad" value="Desktop Mac" <?=($row->tipo_pc == 'Desktop Mac')?'checked':''?>>
                                Desktop Mac
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label >
                                <input type="radio" name="tipo_pc" class="flat-rad" value="Laptop Mac" <?=($row->tipo_pc == 'Laptop Mac')?'checked':''?>>
                                Laptop Mac
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label >
                                <input type="radio" name="tipo_pc" class="flat-rad" value="Desktop Win" <?=($row->tipo_pc == 'Desktop Win')?'checked':''?>>
                                Desktop Win
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label >
                                <input type="radio" name="tipo_pc" class="flat-rad" value="Laptop Win" <?=($row->tipo_pc == 'Laptop Win')?'checked':''?>>
                                Laptop Win
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>En caso de ser un nuevo ingreso especifique los modulos del sistema ERP y/o SAP a los que tendra acceso</label>
                            <textarea type="text" class="form-control input-sm" rows="3" id="" name="modulos" ><?=$row->modulos?></textarea>
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
                            <textarea type="text" class="form-control input-sm" rows="3" id="" name="observaciones" ><?=$row->observaciones?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="button" class="btn btn-default " onclick="back()"> Atras</button>
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
        
        
        if(<?=$row->pc ?> == 1){
            $('.flat-rad').prop('disabled', false).iCheck('update');
        }else{
            $('.flat-rad').prop('checked', false);
            $('.flat-rad').prop('disabled', true).iCheck('update');
        }

        $("#form ").submit(function (event) {
            event.preventDefault();
            save();
        });
    });
    
    function back(){
        location.href = "<?= base_url() ?>Sgc/Edit/<?= $id ?>/<?= $tipo ?>";
    }

    function save() {

        var formData = new FormData($('#form')[0]);
        formData.append("tipo", <?= $tipo ?>);
        formData.append("id_solicitud", <?= $id ?>);
        
        if ($('#delegado').is(':checked')) {
            formData.append('delegado', 1);
        }else{
            formData.append('delegado', 0);
        }
        
        $('.flat-red').each(function () {
            if ($(this).is(':checked')) {
                formData.append($(this).attr('id'), 1);
            }else{
                formData.append($(this).attr('id'), 0);
            }
        });
        
        if ($('#pc').is(':checked')) {
            formData.append('pc', 1);
        }else{
            formData.append('pc', 0);
            formData.append('tipo_pc', '');
        }
        
        $.ajax({
            url: "<?= base_url() ?>Sgc/C_Sgc/UpdateInfo",
            type: 'POST',
            data: formData,
            success: function (data) {
                var obj = jQuery.parseJSON(data);
                if (obj.res == "OK") {
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

