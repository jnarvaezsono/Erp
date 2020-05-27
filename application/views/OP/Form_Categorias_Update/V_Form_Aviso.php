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
        <label for="">Pagina</label>
        <select class="form-control   input-task select-modal-form " id="t_pagina" name="id_pagina" >
            <option value="">. . .</option>
            <?php foreach ($paginas as $v) : ?>
                <option value="<?= $v->pagina_id ?>" <?= ($info->id_pagina == $v->pagina_id) ? "selected" : "" ?>><?= $v->pagina_nombre ?></option>
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
        <label for="">Tamaño(Col*cm)</label>
        <input type="text" class="form-control " id="t_longitud" name="longitud" value="<?= $info->longitud ?>">
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label>Fecha De Publicacion</label>
        <div class="input-group date">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="text" id="t_publicacion" name="fecha_publicacion" class="form-control pull-right picker-task input-task " value="<?= $info->fecha_publicacion ?>">
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="">Texto</label>
        <textarea class="form-control input-task " rows="2" id="t_texto" name="texto" placeholder="Enter ..."><?= $info->texto ?></textarea>
    </div>
</div>
