<div class="col-md-3">
    <div class="form-group">
        <label for="">Pieza</label>
        <select class="form-control   input-task select-modal-form task-required" id="t_servicio" name="id_tipo_servicio" onchange="DuplicateService(this.value)">
            <option value="">. . .</option>
            <?php foreach ($servicios as $v) : ?>
                <option value="<?= $v->id_tipo_servicio ?>" <?= ($info->id_tipo_servicio == $v->id_tipo_servicio) ? "selected" : "" ?>><?= $v->nombre ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Medio</label>
        <select class="form-control   input-task select-modal-form " id="t_medio" name="id_medio" >
            <option value="">. . .</option>
            <?php foreach ($medios as $v) : ?>
                <option value="<?= $v->medio_id ?>" <?= ($info->id_medio == $v->medio_id) ? "selected" : "" ?>><?= $v->medio_nombre ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Tinta</label>
        <select class="form-control   input-task select-modal-form " id="t_tinta" name="id_tinta" >
            <option value="">. . .</option>
            <?php foreach ($tintas as $v) : ?>
                <option value="<?= $v->tinta_id ?>" <?= ($info->id_tinta == $v->tinta_id) ? "selected" : "" ?>><?= $v->tinta_nombre ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="longitud">Tamaño</label>
        <input type="text" class="form-control " id="t_longitud" name="longitud" value="<?= $info->longitud ?>">
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="ubicacion">Ubicación</label>
        <input type="text" class="form-control " id="t_ubicacion" name="ubicacion" value="<?= $info->ubicacion ?>">
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Frecuencia</label>
        <input type="text" class="form-control " id="t_frecuencia" name="frecuencia" value="<?= $info->frecuencia ?>">
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Avisos</label>
        <input type="number" class="form-control " id="t_aviso" name="aviso" value="<?= $info->aviso ?>">
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="">Publicacion</label>
        <textarea class="form-control input-task " rows="2" id="t_texto" name="texto" placeholder="Enter ..."><?= $info->texto ?></textarea>
    </div>
</div>