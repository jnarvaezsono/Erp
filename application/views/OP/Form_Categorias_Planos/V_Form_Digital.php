<div class="col-md-9">
    <div class="form-group">
        <label for="">Pieza: </label>
            <?php 
        $tipo = '';
        $array = explode(',', $info->id_tarifa_servicio);
        if(!empty($info->id_tarifa_servicio) > 0){
        foreach ($servicios as $v) : ?>
            <?php if (in_array($v->id_tarifa_servicio, $array)) : ?>
                <?=$v->descripcion.', '?>  
             <?php endif; ?>
        <?php endforeach; } ?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="medio_digital">Medio Digital: </label>
        <?=$info->medio_digital?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="t_longitud">Tamaño: </label>
        <?=$info->longitud?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="t_fecha_inicio">Fecha Vigencia: </label>
        <?=$info->fecha_inicio?>
    </div>
</div>