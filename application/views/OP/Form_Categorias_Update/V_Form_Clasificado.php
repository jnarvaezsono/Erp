<div class="col-md-3">
    <div class="form-group">
        <label for="">Pieza</label>
        <select class="form-control   input-task select-modal-form task-required" id="t_servicio" name="id_tipo_servicio" onchange="DuplicateService(this.value)">
            <option value="">. . .</option>
            <?php foreach ($servicios as $v) : ?>
                <option value="<?= $v->id_tipo_servicio ?>" <?= ($info->id_tipo_servicio == $v->id_tipo_servicio) ? "selected" : "" ?>><?= $v->nombre ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Medio</label>
        <select class="form-control   input-task select-modal-form " id="t_medio" name="id_medio" >
            <option value="">. . .</option>
            <?php foreach ($medios as $v) : ?>
                <option value="<?= $v->medio_id ?>" <?= ($info->id_medio == $v->medio_id) ? "selected" : "" ?>><?= $v->medio_nombre ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Sección</label>
        <input type="text" class="form-control input-task " value="<?= $info->seccion ?>" id="t_seccion" name="seccion">
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Publicaciones</label>
        <input type="text" class="form-control " value="<?= $info->publicaciones ?>" id="t_publicaciones" name="publicaciones">
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Fechas</label>
        <input type="text" class="form-control " value="<?= $info->fechas ?>" id="t_fechas" name="fechas">
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Foto</label>
        <select class="form-control   input-task select-modal-form " id="t_foto" name="foto" >
            <option value="" <?= ($info->foto == "") ? "selected" : "" ?>>. . .</option>
            <option value="SI" <?= ($info->foto == "SI") ? "selected" : "" ?>>SI</option>
            <option value="NO" <?= ($info->foto == "NO") ? "selected" : "" ?>>NO</option>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Negrita</label>
        <select class="form-control   input-task select-modal-form " id="t_negrita" name="negrita" >
            <option value="" <?= ($info->negrita == "") ? "selected" : "" ?>>. . .</option>
            <option value="SI" <?= ($info->negrita == "SI") ? "selected" : "" ?>>SI</option>
            <option value="NO" <?= ($info->negrita == "NO") ? "selected" : "" ?>>NO</option>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Mayuscula</label>
        <select class="form-control   input-task select-modal-form " id="t_mayuscula" name="mayuscula" >
            <option value="" <?= ($info->mayuscula == "") ? "selected" : "" ?>>. . .</option>
            <option value="SI" <?= ($info->mayuscula == "SI") ? "selected" : "" ?>>SI</option>
            <option value="NO" <?= ($info->mayuscula == "NO") ? "selected" : "" ?>>NO</option>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Fondo</label>
        <select class="form-control   input-task select-modal-form " id="t_fondo" name="fondo" >
            <option value="" <?= ($info->fondo == "") ? "selected" : "" ?>>. . .</option>
            <option value="SI" <?= ($info->fondo == "SI") ? "selected" : "" ?>>SI</option>
            <option value="NO" <?= ($info->fondo == "NO") ? "selected" : "" ?>>NO</option>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Logo</label>
        <select class="form-control   input-task select-modal-form " id="t_logo" name="tipo_logo" >
            <option value="" <?= ($info->tipo_logo == "") ? "selected" : "" ?>>. . .</option>
            <option value="Grande" <?= ($info->tipo_logo == "Grande") ? "selected" : "" ?>>Grande</option>
            <option value="Pequeño" <?= ($info->tipo_logo == "Pequeño") ? "selected" : "" ?>>Pequeño</option>
            <option value="Sin Logo" <?= ($info->tipo_logo == "Sin Logo") ? "selected" : "" ?>>Sin Logo</option>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Titulo</label>
        <input type="text" id="t_titulo" name="titulo" class="form-control input-task " value="<?= $info->titulo ?>">
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="">Texto</label>
        <textarea class="form-control input-task " rows="2" id="t_texto" name="texto" placeholder="Enter ..."><?= $info->texto ?></textarea>
    </div>
</div>