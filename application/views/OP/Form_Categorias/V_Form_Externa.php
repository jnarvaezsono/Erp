<div class="col-md-3">
    <div class="form-group">
        <label for="">Pieza</label>
        <select class="form-control   input-task select-modal-form task-required" id="t_servicio" name="id_tipo_servicio" >
            <option value="">. . .</option>
            <?php foreach ($servicios as $v) : ?>
                <option value="<?= $v->id_tipo_servicio ?>"><?= $v->nombre ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>