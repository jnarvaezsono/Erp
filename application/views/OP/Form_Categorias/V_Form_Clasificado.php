<div class="col-md-3">
    <div class="form-group">
        <label for="">Pieza</label>
        <select class="form-control   input-task select-modal-form task-required" id="t_servicio" name="id_tipo_servicio" >
            <option value="">. . .</option>
            <?php foreach ($servicios as $v) : ?>
                <option value="<?=$v->id_tipo_servicio?>"><?=$v->nombre?></option>
            <?php endforeach;  ?>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Logo</label>
        <select class="form-control   input-task select-modal-form " id="t_logo" name="tipo_logo" >
            <option value="">. . .</option>
            <option value="Grande">Grande</option>
            <option value="Pequeño">Pequeño</option>
            <option value="Sin Logo">Sin Logo</option>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Titulo</label>
        <input type="text" id="t_titulo" name="titulo" class="form-control input-task " >
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Medio</label>
        <select class="form-control   input-task select-modal-form " id="t_medio" name="id_medio" >
            <option value="">. . .</option>
            <?php foreach ($medios as $v) : ?>
                <option value="<?=$v->medio_id?>"><?=$v->medio_nombre?></option>
            <?php endforeach;  ?>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Sección</label>
        <input type="text" class="form-control input-task " id="t_seccion" name="seccion">
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Fechas</label>
        <input type="text" class="form-control " id="t_fechas" name="fechas">
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Publicaciones</label>
        <input type="text" class="form-control " id="t_publicaciones" name="publicaciones">
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Foto</label>
        <select class="form-control   input-task select-modal-form " id="t_foto" name="foto" >
            <option value="">. . .</option>
            <option value="SI">SI</option>
            <option value="NO">NO</option>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Negrita</label>
        <select class="form-control   input-task select-modal-form " id="t_negrita" name="negrita" >
            <option value="">. . .</option>
            <option value="SI">SI</option>
            <option value="NO">NO</option>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Mayuscula</label>
        <select class="form-control   input-task select-modal-form " id="t_mayuscula" name="mayuscula" >
            <option value="">. . .</option>
            <option value="SI">SI</option>
            <option value="NO">NO</option>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Fondo</label>
        <select class="form-control   input-task select-modal-form " id="t_fondo" name="fondo" >
            <option value="">. . .</option>
            <option value="SI">SI</option>
            <option value="NO">NO</option>
        </select>
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="">Texto</label>
        <textarea class="form-control input-task " rows="1" id="t_texto" name="texto" placeholder="Enter ..."></textarea>
    </div>
</div>