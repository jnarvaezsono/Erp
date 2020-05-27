<div class="modal fade" id="modal-task">
    <div class="modal-dialog" style="width: 100%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-fw fa-tasks"></i> GESTIONAR TAREA</h4>
            </div>
            <div class="modal-body">
                <?= $form_modal ?>
                <div id="content-area">

                </div>

                <div class="box box-widget">
                    <div class="box-body">
                        <form role="form" class="form-task" method="POST" enctype="multipart/form-data">
                            <div class="row" >
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="id_categoria">Categoria</label>
                                        <select class="form-control input-sm select-modal input-task task-required "  id="id_categoria" name="id_categoria" onchange="LoadForm(this.value)">
                                            <option value="">. . .</option>
                                            <?php foreach ($categorias as $v) : ?>
                                                <option form="<?= $v->form ?>" value="<?= $v->id_categoria ?>"><?= $v->descripcion ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="content-form">
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btn-save-task" onclick="SaveTask(<?= $id_op ?>)"><i class="fa fa-fw fa-save"></i> Guardar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>