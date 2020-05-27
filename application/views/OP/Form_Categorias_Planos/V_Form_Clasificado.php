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
        <label for="">Sección: </label>
        <?= $info->seccion ?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Publicaciones: </label>
        <?= $info->publicaciones ?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Fechas: </label>
        <?= $info->fechas ?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Foto: </label>
        <?=$info->foto?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Negrita: </label>
        <?=$info->negrita?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Mayuscula: </label>
        <?=$info->mayuscula?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Fondo: </label>
        <?=$info->fondo?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Logo: </label>
        <?=$info->tipo_logo?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Titulo: </label>
        <?= $info->titulo ?>
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="">Texto: </label>
        <?= $info->texto ?>
    </div>
</div>