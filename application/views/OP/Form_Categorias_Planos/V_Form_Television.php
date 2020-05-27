<div class="col-md-3">
    <div class="form-group">
        <label for="">Pieza: </label>
        <?php foreach ($servicios as $v) : 
            if($info->id_tipo_servicio == $v->id_tipo_servicio): ?>
            <?= $v->nombre ?>
        <?php endif; endforeach; ?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Medio: </label>
        <?php foreach ($medios as $v) : 
            if($info->id_medio == $v->medio_id) :?>
                <?= $v->medio_nombre ?>
        <?php endif; endforeach; ?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Canal: </label>
            <?php foreach ($canales as $v) : 
                if($info->id_canal == $v->id_canal) : ?><?= $v->nombre ?>
            <?php endif ;endforeach; ?>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Programa: </label>
        <?= $info->programa_tv ?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Frecuencia: </label>
        <?= $info->frecuencia ?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Franja: </label>
        <?= $info->franja ?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label>Fecha Comercial: </label>
        <?= $info->fecha_inicio ?>
    </div>
</div>
<div class="col-md-3">
    <div class="bootstrap-timepicker">
        <div class="form-group">
            <label>Hora: </label>
            <?= $info->hora ?>
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Duración(Segundos): </label>
        <?= $info->segundos ?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Referencia: </label>
        <?=$info->texto ?>
    </div>
</div>