<div class="box box-widget">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="modalidad_cobro">Modalidad</label>
                <select class="form-control input-sm input-task task-required select-modal"  id="modalidad_cobro" name="modalidad_cobro" >
                    <option value="">. . .</option>
                    <?php foreach ($modalidades as $v) : ?>
                        <option value="<?= $v->descripcion ?>"><?= $v->descripcion ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="unidad">Area De Negocio</label>
                <select class="form-control input-sm select-modal input-task task-required unidades"  id="unidad" name="id_unidad"  onchange="LoadSelect('t_responsable', this.value, ''); ChargeCategory(this.value);" >
                    <option value="">. . .</option>
                    <?php foreach ($unidades as $v) : ?>
                        <option value="<?= $v->id_unidad ?>" area="<?= $v->area ?>"><?= $v->descripcion ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-2" style="display:none">
            <div class="form-group">
                <label for="responsable">Área Responsable</label>
                <select class="form-control input-sm input-task  select-modal select-area"  id="area_responsable" >
                    <option value="">. . .</option>
                    <?php foreach ($area_responsable as $v) : ?>
                        <option value="<?= $v->id_area ?>"><?= $v->descripcion ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Responsable</label>
                <select class="form-control   input-task select-modal  select-area responsable" multiple id="t_responsable" name="t_responsable" >
                    <option value="">. . .</option>

                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Fecha De Entrega</label>
                <input type="text" id="fecha_entrega" name="fecha_entrega" class="form-control  input-task task-required picker" >
            </div>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <label>Descripción De Tarea</label> <i class="fa fa-fw fa-refresh" onclick="copydescription()" style="cursor: pointer"></i>
                <textarea class="form-control input-task ckedit " id="descripcion" name="descripcion" rows="2" placeholder="Enter ..."></textarea>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="notificados">Notificar A:</label>
                <select class="form-control input-sm input-task select-modal select-area notificados" multiple id="notificados" >
                    <option value="">. . .</option>
                    <?php foreach ($usuarios as $v) : ?>
                        <option value="<?= $v->id_users ?>"><?= strtoupper($v->name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <form role="form" class="form-attach" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Adjuntar</label>
                        <input class=" form-prom" type="file" name="files[]" id="filer_input" >
                    </div>
            </form>
        </div>
    </div>
</div>
