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
        <label for="">Tinta: </label>
            <?php foreach ($tintas as $v) : 
                if($info->id_tinta == $v->tinta_id):?>
                    <?= $v->tinta_nombre ?>
            <?php endif; endforeach; ?>
        </select>
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
        <label for="ubicacion">Ubicación: </label>
        <?= $info->ubicacion ?>
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
        <label for="">Avisos: </label>
        <?= $info->aviso ?>
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="">Publicacion: </label>
        <?= $info->texto ?>
    </div>
</div>