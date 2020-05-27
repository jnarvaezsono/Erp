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
                <h3 class="box-title"><i class="fa fa-fw fa-table"></i> Generar <?=$function?></h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Fecha</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="id_fecha" >
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Cliente</label>
                            <select class="form-control select2 input-sm" id="id_cliente" >
                                <option value="all">TODOS</option>
                                <?php foreach ($clientes as $v) : ?>
                                    <option value="<?= $v->pvcl_id ?>"><?= $v->pvcl_nombre ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3" style="display:none">
                        <div class="form-group">
                            <label>Proveedor</label>
                            <select class="form-control select2 input-sm" id="id_proveedor" >
                                <option value="all">TODOS</option>
                                <?php foreach ($proveedores as $v) : ?>
                                    <option value="<?= $v->pvcl_id ?>"><?= $v->pvcl_nombre ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tipo</label>
                            <select class="form-control select2 input-sm" id="id_categoria" <?=($function == 'InHouse')?'disabled':''?>>
                                <option value="all">TODOS</option>
                                <?php foreach ($categorias as $v) : ?>
                                    <option value="<?= $v->id_categoria ?>" id_tabla="<?= $v->id_tabla ?>" ><?= $v->descripcion ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 ">
                        <button type="button" class="btn pull-left btn-primary" ><i class="fa fa-fw fa-file-excel-o"></i> Generar</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<script>
    $(document).ready(function () {
        
        if('<?=$function?>' == 'InHouse'){
            $('#id_categoria').val('7').trigger('change');
        }
        
        $(".select2").select2();
        $('#id_fecha').daterangepicker({format: 'YYYY-MM-DD'});

        $('.btn-primary').click(function () {

            if ($("#id_fecha").val() != '') {
                
               
                var result = $("#id_fecha").val().split(' - ');
                var fecha_ini = result[0];
                var fecha_fin = result[1];

                var id_proveedor = $("#id_proveedor").val();
                var id_cliente = $("#id_cliente").val();
                var id_categoria = $("#id_categoria").val();
                $(".loader_ajax2").text("Creando Archivo");
                $.post("<?= base_url() ?>Billing/Report/C_Report/<?=$function?>", {fecha_fin:fecha_fin,fecha_ini: fecha_ini,id_proveedor:id_proveedor,id_cliente:id_cliente,id_categoria:id_categoria}, function(data) {
                    if (data.result != 'ok') {
                        alertify.error("Ha ocurrido un error al descargar el archivo");
                        return false;
                    } else {
                        window.location.replace("<?= base_url() ?>Billing/Report/C_Report/<?=$function?>/" + data.archivo);
                    }
                }, 'JSON');

            } else {
                alertify.error('SELECCIONE UN RANGO DE FECHA');
            }

        });

    });

</script>