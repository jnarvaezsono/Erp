
<div class="col-md-3">
    <div class="form-group">
        <label for="">Piezas</label>
        <select class="form-control   input-task select-modal-form task-required" id="t_servicio" name="id_tipo_servicio" >
            <option value="">. . .</option>
            <?php foreach ($servicios as $v) : ?>
                <option value="<?= $v->id_tipo_servicio ?>" <?= ($info->id_tipo_servicio == $v->id_tipo_servicio) ? "selected" : "" ?>><?= $v->nombre ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="col-md-9">
    <div class="form-group">
        <label for="">Detalle</label>
        <textarea class="form-control input-task " rows="3" id="t_texto" name="texto" placeholder="Enter ..."><?= $info->texto ?></textarea>
    </div>
</div>