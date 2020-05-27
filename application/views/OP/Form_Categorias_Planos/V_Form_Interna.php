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
        <?php endforeach; }  ?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="longitud">Tamaño: </label>
        <?=$info->longitud?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Tinta: </label>
        <?php foreach ($tintas as $v) : 
            if($info->id_tinta == $v->tinta_id):?>
            <?=$v->tinta_nombre?>
        <?php endif; endforeach;  ?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">N.Paginas: </label>
        <?=$info->numero_paginas?>
    </div>
</div>
<div class="col-md-9">
    <div class="form-group">
        <label for="">Obligatorio a tener en cuenta: </label>
        <?= $info->texto ?>
    </div>
</div>

