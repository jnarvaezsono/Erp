<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            <label for="responsable">Área (<?= $type ?>)</label>
            <select class="form-control input-sm input-task task-required select-modal select-area " id="area_responsable<?= $type ?>"  onchange="LoadSelect('t_responsable', this.value, '<?= $type ?>')" >
                <option value="">. . .</option>
                <?php foreach ($area_responsable as $v) : ?>
                    <option value="<?= $v->id_area ?>" <?= (($type == 'COTIZAR' || $type == 'ORDENAR' ) && $v->id_area == 4) ? 'selected' : ($v->id_area == 1) ? 'selected' : '' ?> ><?= $v->descripcion ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label for="">Responsable</label>
            <select class="form-control   input-task select-modal task-required select-area " multiple id="t_responsable<?= $type ?>"  >
                <option value="">. . .</option>
                <?php foreach ($responsable as $v) : ?>
                    <option value="<?= $v->id_users ?>"><?= strtoupper($v->name) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label for="notificados">Notificar A:</label>
            <select class="form-control input-sm input-task select-modal select-area notificados" multiple id="notificados<?= $type ?>" >
                <option value="">. . .</option>
                <?php foreach ($usuarios as $v) : ?>
                    <option value="<?= $v->id_users ?>"><?= strtoupper($v->name) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>
