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
        <label for="">Pieza</label>
        <select class="form-control   input-task select-modal-form " id="t_pieza" name="id_pieza" >
            <option value="">. . .</option>
            <?php foreach ($piezas as $v) : ?>
                <option value="<?= $v->pieza_id ?>" <?= ($info->id_pieza == $v->pieza_id) ? "selected" : "" ?>><?= $v->pieza_nombre ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label>Fecha De Inicio</label>
        <div class="input-group date">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="text" id="t_fecha_inicio" name="fecha_inicio" class="form-control pull-right input-task  picker-task " value="<?= $info->fecha_inicio ?>" >
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label>Fecha De Fin</label>
        <div class="input-group date">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="text" id="t_fecha_fin" name="fecha_fin" class="form-control pull-right input-task  picker-task" value="<?= $info->fecha_fin ?>">
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="longitud">Tamaño Impresión</label>
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
        <label for="">Ciudad</label>
        <select class="form-control   input-task select-modal-form " id="t_ciudad" name="id_ciudad" >
            <option value="">. . .</option>
            <?php foreach ($ciudades as $v) : ?>
                <option value="<?= $v->id_ciudad ?>" <?= ($info->id_ciudad == $v->id_ciudad) ? "selected" : "" ?>><?= $v->nombre ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="">Detalle</label>
        <textarea class="form-control input-task " rows="3" id="t_texto" name="texto" placeholder="Enter ..."><?= $info->texto ?></textarea>
    </div>
</div>