<div class="col-md-4">
    <div class="form-group">
        <label for="">Pieza: </label>
        <?php foreach ($servicios as $v) : 
            if($info->id_tipo_servicio == $v->id_tipo_servicio): ?>
            <?= $v->nombre ?>
        <?php endif; endforeach; ?>
    </div>
</div>
<div class="col-md-5">
    <div class="form-group">
        <label for="producto">Producto: </label>
        <?= $info->producto ?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="longitud">Tamaño: </label>
        <?= $info->longitud ?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="t_material">Material: </label>
        <?= $info->material ?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Tinta: </label>
            <?php foreach ($tintas as $v) : 
                if($info->id_tinta == $v->tinta_id): ?>
                    <?= $v->tinta_nombre ?>
            <?php endif; endforeach; ?>
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="">Detalle: </label>
        <?= $info->texto ?>
    </div>
</div>
