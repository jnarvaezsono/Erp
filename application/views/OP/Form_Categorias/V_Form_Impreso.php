<div class="col-md-3">
    <div class="form-group">
        <label for="">Pieza</label>
        <select class="form-control   input-task select-modal-form task-required" id="t_servicio" name="id_tipo_servicio" >
            <option value="">. . .</option>
            <?php foreach ($servicios as $v) : ?>
                <option value="<?= $v->id_tipo_servicio ?>"><?= $v->nombre ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Elemento</label>
        <select class="form-control   input-task  select-modal-form" id="t_elemento" name="id_elemento" >
            <option value="">. . .</option>
            <?php foreach ($elementos as $v) : ?>
                <option value="<?=$v->elem_id?>"><?=$v->elem_nombre?></option>
            <?php endforeach;  ?>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Concepto</label>
        <select class="form-control   input-task  select-modal-form" id="t_concepto" name="id_concepto" >
            <option value="">. . .</option>
            <?php foreach ($conceptos as $v) : ?>
                <option value="<?=$v->concp_id?>"><?=$v->concp_nmb?></option>
            <?php endforeach;  ?>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="t_material">Material</label>
        <input type="text" class="form-control " id="t_material" name="material">
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Tamaño</label>
        <input type="text" class="form-control " id="t_longitud" name="longitud">
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Tinta</label>
        <select class="form-control   input-task select-modal-form " id="t_tinta" name="id_tinta" >
            <option value="">. . .</option>
            <?php foreach ($tintas as $v) : ?>
                <option value="<?=$v->tinta_id?>"><?=$v->tinta_nombre?></option>
            <?php endforeach;  ?>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Paginas</label>
        <input type="text" class="form-control " id="t_paginas" name="numero_paginas">
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Acabados</label>
        <input type="text" class="form-control " id="t_acabados" name="acabados">
    </div>
</div>
<div class="col-md-9">
    <div class="form-group">
        <label for="">Detalle</label>
        <textarea class="form-control input-task " rows="1" id="t_texto" name="texto" placeholder="Enter ..."></textarea>
    </div>
</div>