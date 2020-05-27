<div class="col-md-4">
    <div class="form-group">
        <label for="">Servicio: </label>
        <?php foreach ($servicios as $v) : 
            if($info->id_tipo_servicio == $v->id_tipo_servicio): ?>
            <?= $v->nombre ?>
        <?php endif; endforeach; ?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Pieza: </label>
        <?php foreach ($piezas as $v) : 
            if($info->id_pieza == $v->pieza_id):?>
                <?= $v->pieza_nombre ?>
        <?php endif; endforeach; ?>
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
        <label for="longitud">Tamaño Impresión: </label>
        <?= $info->longitud ?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="ubicacion">Ubicación: </label>
        <?= $info->ubicacion ?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Ciudad: </label>
            <?php foreach ($ciudades as $v) : 
                if($info->id_ciudad == $v->id_ciudad) :?>
                    <?= $v->nombre ?>
            <?php endif; endforeach; ?>
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="">Detalle: </label>
        <?= $info->texto ?>
    </div>
</div>