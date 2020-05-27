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
        <label for="">Emisora</label>
        <select class="form-control   input-task select-modal-form " id="t_emisora" name="id_emisora" onchange="LoadSelect('t_programa',this.value)">
            <option value="">. . .</option>
            <?php foreach ($emisoras as $v) : ?>
                <option value="<?= $v->emis_id ?>"><?= $v->emis_nombre ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Programa</label>
        <select class="form-control   input-task select-modal-form " id="t_programa" name="id_programa" >
            <option value="">. . .</option>
        </select>
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
        <label for="">Ciudad</label>
        <select class="form-control   input-task select-modal-form " id="t_ciudad" name="id_ciudad" >
            <option value="">. . .</option>
            <?php foreach ($ciudades as $v) : ?>
                <option value="<?= $v->id_ciudad ?>"><?= $v->nombre ?></option>
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
            <input type="text" id="t_fecha_inicio" name="fecha_inicio" class="form-control pull-right input-task  picker-task " >
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
            <input type="text" id="t_fecha_fin" name="fecha_fin" class="form-control pull-right input-task  picker-task" >
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Segundos</label>
        <input type="number" class="form-control " id="t_segundos" name="segundos">
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Días</label>
        <input type="number" class="form-control " id="t_dias" name="dias">
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Referencia</label>
        <textarea class="form-control input-task " rows="1" id="t_texto" name="texto" placeholder="Enter ..."></textarea>
    </div>
</div>