<div class="col-md-9">
    <div class="form-group">
        <label for="">Servicio: </label>
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
        <label>Fecha Cotización: </label>
        <?=$info->fecha_inicio?>
    </div>
</div>