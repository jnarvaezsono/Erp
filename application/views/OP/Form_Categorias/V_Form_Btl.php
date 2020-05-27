<div class="col-md-9">
    <div class="form-group">
        <label for="">Servicio</label>
        <select class="form-control   input-task select-modal-form task-required" multiple onchange="ShowNewPieza(this.value)" id="id_tarifa_servicio" name="id_tarifa_servicio" >
            <option value="">. . .</option>
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
<div class="col-md-3">
    <div class="form-group">
        <label>Fecha Cotización</label>
        <div class="input-group date">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="text" id="t_fecha_inicio" name="fecha_inicio" class="form-control pull-right input-task  picker-task " >
        </div>
    </div>
</div>