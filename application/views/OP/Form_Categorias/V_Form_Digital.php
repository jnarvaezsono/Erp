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
        <label>Fecha Vigencia</label>
        <input type="text" id="t_fecha_inicio" name="fecha_inicio" class="form-control pull-right input-task  picker-task " >
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="">Medio Digital</label>
        <select class="form-control   input-task select-modal-form " id="medio_digital" name="medio_digital" >
            <option value="">. . .</option>
            <option value="PAGINA WEB">PAGINA WEB</option>
            <option value="REDES SOCIALES">REDES SOCIALES</option>
            
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="longitud">Tamaño</label>
        <select class="form-control   input-task select-modal-form " id="t_longitud" name="longitud" >
            <option value="">. . .</option>
            <option value="BANNER">BANNER</option>
            <option value="LANDING">LANDING</option>
            <option value="WEBMAIL">WEBMAIL</option>
        </select>
    </div>
</div>