<div class="col-md-9">
    <div class="form-group">
        <label for="id_tarifa_servicio">Pieza</label>
        <select class="form-control   input-task select-modal-form task-required" multiple onchange="ShowNewPieza(this.value)" id="id_tarifa_servicio" name="id_tarifa_servicio" >
            <option value="">. . .</option>
            <option value="new">CREAR NUEVO</option>
            <?php 
            $tipo = '';
            $array = explode(',', $info->id_tarifa_servicio);
            foreach ($servicios as $v) : ?>
                <?php if ($v->tipo != $tipo) : ?>
                    <optgroup label="<?=$v->tipo?>">
                <?php endif; ?>
                        <option value="<?=$v->id_tarifa_servicio?>" <?= (in_array($v->id_tarifa_servicio, $array)) ? "selected" : "" ?>><?=$v->descripcion?></option>   
                 <?php $tipo = $v->tipo; ?>
                    
            <?php endforeach;  ?>
                
        </select>
    </div>
</div>
<div class="col-md-3" id="content-new-pieza" style="display:none">
    <div class="form-group">
        <label for="">Nueva Pieza</label>
        <input type="text" class="form-control input-task " id="tarifa_new" name="tarifa_new" >
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="medio_digital">Medio Digital</label>
        <select class="form-control   input-task select-modal-form " id="medio_digital" name="medio_digital" >
            <option value="">. . .</option>
            <option value="PAGINA WEB" <?= ($info->medio_digital == 'PAGINA WEB') ? "selected" : "" ?>>PAGINA WEB</option>
            <option value="REDES SOCIALES" <?= ($info->medio_digital == 'REDES SOCIALES') ? "selected" : "" ?>>REDES SOCIALES</option>
            
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="t_longitud">Tamaño</label>
        <select class="form-control   input-task select-modal-form " id="t_longitud" name="longitud" >
            <option value="">. . .</option>
            <option value="BANNER" <?= ($info->longitud == 'BANNER') ? "selected" : "" ?>>BANNER</option>
            <option value="LANDING" <?= ($info->longitud == 'LANDING') ? "selected" : "" ?>>LANDING</option>
            <option value="WEBMAIL" <?= ($info->longitud == 'WEBMAIL') ? "selected" : "" ?>>WEBMAIL</option>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="t_fecha_inicio">Fecha Vigencia</label>
        <input type="text" id="t_fecha_inicio" value="<?=$info->fecha_inicio?>" name="fecha_inicio" class="form-control pull-right input-task  picker-task " >
    </div>
</div>