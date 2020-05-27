<style>
    .nav-tabs-custom>.nav-tabs>li.active {
        border-top-color: #d2d6de;
    }
    .form-horizontal .control-label {
        text-align: left;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1 id="title">
            <i class="fa fa-edit"></i> Radicado N&deg;
            <small><?= $id ?> <?= $row->estado ?> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Medios</a></li>
            <li><a href="<?= base_url() ?>Filed">Listar</a></li>
            <li class="active">Editar</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Valores</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <form id="form" role="form" method="POST" enctype="multipart/form-data">
                                <div class=" col-md-4">
                                    <div class="form-group">
                                        <label>Proveedor</label>
                                        <select  class="form-control input-sm info-required" id="id_prov" name="id_prov" >
                                            <option value="">. . .</option>
                                            <?php foreach ($proveedores as $p) : ?>
                                                <option value="<?= $p->id_client ?>" <?= ($row->id_prov == $p->id_client) ? 'selected' : '' ?>><?= $p->nombre ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class=" col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">N&deg;. Factura</label>
                                        <input type="text" class="form-control input-sm" id="factura" name="factura" value="<?= $row->factura ?>">
                                    </div>
                                </div>
                                <div class=" col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Valor Factura</label>
                                        <input  type="text" class="form-control  input-sm  numerico" value="<?= $row->valor ?>"  id="valor"   placeholder="$ 0">
                                    </div>
                                </div>
                                <div class=" col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Total Cobrado</label>
                                        <input readonly  type="text" class="form-control  input-sm  numerico" value="<?= $totals->valor_total ?>"  id="cobrado"   placeholder="$ 0">
                                    </div>
                                </div>
                                <div class=" col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Total Faltante</label>
                                        <input readonly  type="text" class="form-control  input-sm  numerico" value="<?= $row->faltante ?>"  id="faltante"   placeholder="$ 0">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="button" class="btn btn-default btn-sm" onclick="window.location.href = '<?= base_url() ?>Filed'">Cancelar</button>
                        <button type="button" class="btn btn-default  btn-sm" id="add"><i class="fa fa-edit"></i> Agregar Orden</button>
                        <button type="button" class="btn btn-default  btn-sm" id="save"><i class="fa fa-refresh"></i> Actualizar</button>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table id="table_detail" class="table table-bordered table-striped table-condensed display">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center">N&deg; Orden</th>
                                            <th >Tipo</th>
                                            <th >Total</th>
                                            <th ></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($details as $v) : ?>
                                            <tr>
                                                <td style="text-align:center"><?= $v->orden ?></td>
                                                <td><?= $v->tipo ?></td>
                                                <td>$<?= number_format($v->valor, 2, ',', '.') ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-default  btn-sm" style="padding: 1px 7px;" ><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<div class="modal fade" id="modal-update">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Detalle</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class=" col-md-6">
                        <div class="form-group">
                            <label>Tipo Orden</label>
                            <select  class="form-control input-sm" id="Torden" name="Torden">
                                <option value="">. . .</option>
                                <option value="costo">Orden Costo</option>
                                <option value="gasto">Orden Gasto</option>
                                <option value="externa">Orden Externa</option>
                            </select>
                        </div>
                    </div>
                    <div class=" col-md-6">
                        <div class="form-group">
                            <label class="control-label">N&deg; Orden</label>
                            <input  type="text" class="form-control  input-sm " value=""  id="Norden" name="Norden"  >
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="search()" ><i class="fa fa-search"></i> Buscar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        var sw = false;
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

        $('.numerico, .decimals').autoNumeric('init', {
            mDec: 2,
            aDec: ',',
            aSep: '.'
        });

        $('#save').click(function () {
            save();
        });

        $('#add').click(function () {
            $('#modal-update').modal();
        });


        lock('<?= $row->id_estado ?>');
    });

    function search(){
        $.post('<?= base_url() ?>Filed/C_Bill/SearchOrder', {order:$('#Norden').val(),tipo:$('#Torden').val()}, function (data) {
            if (data.res == "OK") {
                
            } else {
                
            }
        }, 'json');
    }

    function lock(id_estado) {
        if (id_estado != '1') {
            $('.form-control').attr('disabled', 'disabled');
            $('#save ,#add-detail ,#btn-Aprobar').hide();
            $('.btn-danger ,.btn-info').attr('disabled', 'disabled').removeAttr('onclick');
        } else {
        }
    }

    function save() {
        if (validatefield('info-required')) {

            var formData = new FormData($('#form')[0]);

            formData.append("factura_id", <?= $id ?>);
            $.ajax({
                url: "<?= base_url() ?>Filed/C_Bill/UpdateInfo",
                type: 'POST',
                data: formData,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
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
    }

</script>

