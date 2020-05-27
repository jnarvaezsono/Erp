<div class="col-md-4">
    <div class="form-group">
        <label for="">Servicio: </label>
        <?php foreach ($servicios as $v) : 
            if($info->id_tipo_servicio == $v->id_tipo_servicio): ?>
            <?= $v->nombre ?>
        <?php endif; endforeach; ?>
    </div>
</div>
<div class="col-md-9">
    <div class="form-group">
        <label for="">Detalle</label>
        <?= $info->texto ?>
    </div>
</div>