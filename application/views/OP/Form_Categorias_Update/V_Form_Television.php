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
        <label for="">Canal</label>
        <select class="form-control   input-task select-modal-form " id="t_canal" name="id_canal" >
            <option value="">. . .</option>
            <?php foreach ($canales as $v) : ?>
                <option value="<?= $v->id_canal ?>" <?= ($info->id_canal == $v->id_canal) ? "selected" : "" ?>><?= $v->nombre ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Programa</label>
        <input type="text" class="form-control " id="t_programa" name="programa_tv" value="<?= $info->programa_tv ?>">
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
        <label for="">Franja</label>
        <input type="text" class="form-control " id="t_franja" name="franja" value="<?= $info->franja ?>">
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label>Fecha Comercial</label>
        <div class="input-group date">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="text" id="t_fecha_inicio" name="fecha_inicio" class="form-control pull-right input-task  picker-task " value="<?= $info->fecha_inicio ?>" >
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="bootstrap-timepicker">
        <div class="form-group">
            <label>Hora</label>
            <div class="input-group">
                <input type="text" class="form-control timepicker " id="t_hora" name="hora"  value="<?= $info->hora ?>">
                <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Duración(Segundos)</label>
        <input type="number" class="form-control " id="t_segundos" name="segundos" value="<?= $info->segundos ?>">
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Referencia</label>
        <select class="form-control   input-task select-modal-form " id="t_texto" name="texto" >
            <option value="">. . .</option>
            <option value="HOY" <?= ($info->texto == 'HOY') ? "selected" : "" ?>>HOY</option>
            <option value="MAÑANA" <?= ($info->texto == 'MAÑANA') ? "selected" : "" ?>>MAÑANA</option>
            <option value="HOY-MAÑANA" <?= ($info->texto == 'HOY-MAÑANA') ? "selected" : "" ?>>HOY-MAÑANA</option>
        </select>
    </div>
</div>