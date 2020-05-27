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
        <label for="">Emisora: </label>
        <?php foreach ($emisoras as $v) : 
            if($info->id_emisora == $v->emis_id):?>
                <?= $v->emis_nombre ?>
        <?php endif; endforeach; ?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Frecuencia: </label>
        <?= $info->frecuencia ?>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <label for="">Programa: </label>
            <?php foreach ($programas as $v) : 
                if($info->id_programa == $v->progr_id) :?>
                    <?= $v->progr_nombre ?>
            <?php endif; endforeach; ?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Ciudad: </label>
            <?php foreach ($ciudades as $v) : 
                if($info->id_ciudad == $v->id_ciudad):?>
                    <?= $v->nombre ?>
            <?php endif; endforeach; ?>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label>Fecha De Inicio: </label>
        <?= $info->fecha_inicio ?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label>Fecha De Fin: </label>
        <?= $info->fecha_fin ?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Segundos: </label>
        <?= $info->segundos ?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Días: </label>
        <?= $info->dias ?>
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="">Referencia: </label>
        <?= $info->texto ?>
    </div>
</div>