<style>
    .td-estado{
        padding: 0 !important;
        vertical-align: middle !important;
    }
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-fw fa-table"></i> Generar Archivo</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Fecha</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="id_fecha" autocomplete="off">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <button type="button" class="btn pull-left btn-info down-xls" style="margin-top: 24px;"><i class="fa fa-fw fa-file-excel-o"></i> Generar</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-fw fa-file-excel-o"></i> Cargar Archivo</h3>
                    </div>
                    <div class="box-body">
                        <form role="form" id="form-import" method="POST" enctype="multipart/form-data">
                            <label>File</label>
                            <div class="form-group">
                                <input class="" type="file" name="files[]" id="import" autocomplete="off">
                            </div>
                        </form>
                        <button type="button" class="btn pull-left btn-primary" style="margin-top: 24px;"  onclick="Upexcelfile()"><i class="fa fa-fw fa-upload"></i> Cargar</button>
                    </div>
                </div>
            </div>
            <div class="col-md-12" id="cont-file">

            </div>

        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <div id="fileTreeDemo_1" style="overflow-y: scroll;max-height: 400px;" class="demo"></div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div id="fileTreeDemo_2" style="overflow-y: scroll;max-height: 400px;" class="demo"></div>

                </div>
            </div>
        </div>




    </section>
</div>


<script>
    $(document).ready(function () {


        $('#fileTreeDemo_1').fileTree({
            root: '../../../Cargue/M/',
            script: '<?= base_url() ?>dist/jqueryFileTree/connectors/cargue.php?folder=M',
            folderEvent: 'click',
            expandSpeed: 750,
            collapseSpeed: 750,
            expandEasing: 'easeOutBounce',
            collapseEasing: 'easeOutBounce',
            loadMessage: 'Un momento...'
        });

        $('#fileTreeDemo_2').fileTree({
            root: '../../../Cargue/I/',
            script: '<?= base_url() ?>dist/jqueryFileTree/connectors/cargue.php?folder=I',
            folderEvent: 'click',
            expandSpeed: 750,
            collapseSpeed: 750,
            expandEasing: 'easeOutBounce',
            collapseEasing: 'easeOutBounce',
            loadMessage: 'Un momento...'
        });


        $('#id_fecha').daterangepicker({format: 'YYYY-MM-DD'});

        $('#import').filer({
            showThumbs: true,
            addMore: true,
            allowDuplicates: false,
            limit: 1,
            extensions: ["xls", "xlsx"]
        });

        $('.down-xls').click(function () {

            if ($("#id_fecha").val() != '') {


                var result = $("#id_fecha").val().split(' - ');
                var fecha_ini = result[0];
                var fecha_fin = result[1];

                var id_proveedor = $("#id_proveedor").val();
                var id_cliente = $("#id_cliente").val();
                var id_categoria = $("#id_categoria").val();
                $(".loader_ajax2").text("Creando Archivo");
                $.post("<?= base_url() ?>Billing/C_Chargue/Cargue", {fecha_fin: fecha_fin, fecha_ini: fecha_ini}, function (data) {
                    if (data.result != 'ok') {
                        alertify.error("Ha ocurrido un error al descargar el archivo");
                        return false;
                    } else {
                        window.location.replace("<?= base_url() ?>Billing/C_Chargue/Cargue/" + data.archivo);
                    }
                }, 'JSON');

            } else {
                alertify.error('SELECCIONE UN RANGO DE FECHA');
            }

        });

    });

    function Upexcelfile() {
        if ($("#import").val() != '') {
            var formData = new FormData($('#form-import')[0]);

            $.ajax({
                url: "<?= base_url() ?>Billing/C_Chargue/Upexcelfile",
                type: 'POST',
                data: formData,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        if (obj.opcion[1] == 0) {
                            if (obj.opcion[0].length <= 0) {
                                swal({title: 'Atención!', text: 'El archivo esta vacio', type: 'warning'});
                            } else {
                                var texto = '';
                                $.each(obj.opcion[0], function (e, i) {
                                    texto += i + ' - ';
                                });
                                swal({title: 'Atención!', text: texto, type: 'warning'});
                            }
                        } else {
                            $('#import').trigger("filer.reset");
                            var img = '<a href="<?= base_url() ?>Cargue/I/PB' + obj.opcion[4] + '" download="PB' + obj.opcion[4] + '">';
                            img += '<img src="<?= base_url() ?>dist/img/plane.png" class="img-circle" alt="User Image" style="width: 100px;cursor: pointer" title="DT' + obj.opcion[4] + '">';
                            img += '</a>';
                            img += '<a href="<?= base_url() ?>Cargue/M/DT' + obj.opcion[5] + '" download="DT' + obj.opcion[5] + '">';
                            img += '<img src="<?= base_url() ?>dist/img/plane.png" class="img-circle" alt="User Image" style="width: 100px;cursor: pointer" title="DT' + obj.opcion[5] + '">';
                            img += '</a>';

                            $('#cont-file').html(img);
                            swal({title: 'OK!', text: obj.opcion[2] + ' Facturas ingresadas', type: 'success'});
                            //window.location.replace('<?= base_url() ?>Tv/Edit/'+id+'/5');
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
    }

</script>