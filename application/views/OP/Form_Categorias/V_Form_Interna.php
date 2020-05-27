<div class="col-md-9">
    <div class="form-group">
        <label for="">Pieza</label>
        <select class="form-control   input-task select-modal-form task-required" multiple onchange="ShowNewPieza(this.value)" id="id_tarifa_servicio" name="id_tarifa_servicio" >
            <option value="">. . .</option>
            <option value="new">CREAR NUEVO</option>
            <?php 
            $tipo = '';
            foreach ($servicios as $v) : ?>
                <?php if ($v->tipo != $tipo) : ?>
                    <optgroup label="<?=$v->tipo?>">
                <?php endif; ?>
                <option value="<?=$v->id_tarifa_servicio?>"><?=$v->descripcion?></option>   
                 <?php $tipo = $v->tipo; ?>
                    
            <?php endforeach;  ?>
        </select>
    </div>
</div>
<div class="col-md-3" id="content-new-pieza" style="display:none">
    <div class="form-group">
        <label for="">Nueva Pieza</label>
        <input type="text" class="form-control input-task " id="tarifa_new" name="tarifa_new">
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="longitud">Tamaño</label>
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
        <label for="">N.Paginas</label>
        <input type="text" class="form-control " id="t_paginas" name="numero_paginas">
    </div>
</div>
<div class="col-md-9">
    <div class="form-group">
        <label for="">Obligatorio a tener en cuenta</label>
        <textarea class="form-control input-task " rows="1" id="t_texto" name="texto" placeholder="Enter ..."></textarea>
    </div>
</div>