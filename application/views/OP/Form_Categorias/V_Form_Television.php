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
<div class="col-md-3">
    <div class="form-group">
        <label for="">Medio</label>
        <select class="form-control   input-task select-modal-form " id="t_medio" name="id_medio" >
            <option value="">. . .</option>
            <?php foreach ($medios as $v) : ?>
                <option value="<?= $v->medio_id ?>"><?= $v->medio_nombre ?></option>
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
                <option value="<?= $v->id_canal ?>"><?= $v->nombre ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Programa</label>
        <input type="text" class="form-control " id="t_programa" name="programa_tv">
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Frecuencia</label>
        <input type="text" class="form-control " id="t_frecuencia" name="frecuencia">
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Duración(Segundos)</label>
        <input type="number" class="form-control " value="0" id="t_segundos" name="segundos">
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label>Fecha Comercial</label>
        <div class="input-group date">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="text" id="t_fecha_inicio" name="fecha_inicio" class="form-control pull-right input-task  picker-task " >
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="bootstrap-timepicker">
        <div class="form-group">
            <label>Hora</label>
            <div class="input-group">
                <input type="text" class="form-control timepicker " id="t_hora" name="hora">
                <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Franja</label>
        <input type="text" class="form-control " id="t_franja" name="franja">
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Referencia</label>
        <select class="form-control   input-task select-modal-form " id="t_texto" name="texto" >
            <option value="">. . .</option>
            <option value="HOY">HOY</option>
            <option value="MAÑANA">MAÑANA</option>
            <option value="HOY-MAÑANA">HOY-MAÑANA</option>
        </select>
    </div>
</div>