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
        <label for="">Elemento: </label>
            <?php foreach ($elementos as $v) : 
                if($info->id_elemento == $v->elem_id):?>
                    <?= $v->elem_nombre ?>
            <?php endif; endforeach; ?>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Concepto: </label>
            <?php foreach ($conceptos as $v) : 
                if($info->id_concepto == $v->concp_id) :?>
                    <?= $v->concp_nmb ?>
            <?php endif; endforeach; ?>
        </select>
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
        <label for="">Tamaño: </label>
        <?= $info->longitud ?>
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
        <label for="">Paginas: </label>
        <?= $info->numero_paginas ?>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Acabados: </label>
        <?= $info->acabados ?>
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="">Detalle: </label>
        <?= $info->texto ?>
    </div>
</div>