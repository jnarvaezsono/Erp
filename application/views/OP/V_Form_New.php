<div class="col-md-4">
    <div class="form-group">
        <label for="cliente">Cliente</label>
        <select class="form-control input-sm required input-cab select2" id="cliente" name="cliente" onchange="ListarDatosForm(this.value)">
            <option value="">. . .</option>
            <?php foreach ($clientes as $v) : ?>
                <option value="<?= $v->pvcl_id ?>"><?= $v->pvcl_nombre ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label for="campana">Campaña</label>
        <select class="form-control input-sm required input-cab select2" id="campana" name="campana" onchange="ShowCampana(this.value)">
            <option value="">. . .</option>
        </select>
    </div>
</div>
<div class="col-md-4" style="display:none" id="group-campana">
    <div class="form-group">
        <label for="new_campana">Nueva Campaña</label>
        <input type="text" class="form-control   input-cab" id="new_campana" name="new_campana" >
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label for="rubro">Producto</label>
        <select class="form-control input-sm required input-cab select2" id="rubro" name="rubro" onchange="ShowProducto(this.value)">
            <option value="">. . .</option>
        </select>
    </div>
</div>
<div class="col-md-4" style="display:none" id="group-producto">
    <div class="form-group">
        <label for="new_producto">Nuevo Producto</label>
        <input type="text" class="form-control  input-cab" id="new_producto" name="new_producto" >
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="descripcion_op">Descripción</label>
        <textarea class="form-control required input-cab" id="descripcion_op" name="descripcion_op" rows="1" placeholder="Enter ..."></textarea>
    </div>
</div>
<div class="col-md-12">
    
    <?=(!empty($BtnCreateOP))?'<button type="button" class="btn btn-sm btn-default" id="btn-save" name="CrearOp" style="margin-top: 21px;"><i class="fa fa-fw fa-save"></i> Crear Orden</button>':"" ?>
    <?=(!empty($BtnUpdateOP))?'<button type="button" class="btn btn-sm btn-default" id="btn-update" name="ActualizarOp" style="margin-top: 21px;display:none"><i class="fa fa-fw fa-refresh"></i> Actualizar Orden</button>':"" ?>
    <?=(!empty($BtnNewTask))?'<button type="button" class="btn btn-sm btn-default" id="add-task" style="margin-top: 21px;display:none"><i class="fa fa-fw fa-tasks"></i> Agregar Tarea</button>':"" ?>
    <?=(!empty($BtnCloseOP))?'<button type="button" class="btn btn-sm btn-default" id="close" style="margin-top: 21px;display:none"><i class="fa fa-fw fa-lock"></i> Cerrar OP</button>':"" ?>
    <?=(!empty($BtnCloseOPMasiv))?'<button type="button" class="btn btn-sm btn-default" id="closeM" style="margin-top: 21px" ><i class="fa fa-fw fa-lock"></i> Cierre Masivo</button>':"" ?>
    <?=(!empty($BtnDeleteOp))?'<button type="button" class="btn btn-sm btn-default" id="anule" style="margin-top: 21px;display:none" ><i class="fa fa-fw fa-warning"></i> Anular OP</button>':"" ?>
    <?=(!empty($BtnUpload))?'<button type="button" class="btn btn-sm btn-default"  style="margin-top: 21px;display:none" id="btn-import"><i class="fa fa-fw fa-upload"></i> Importar</button>':"" ?>
    <button type="button" class="btn btn-sm btn-default"  style="margin-top: 21px" onclick="window.location ='<?= base_url()?>OP/C_OP/ListAll'"><i class="fa fa-fw fa-backward"></i> Atras</button>
</div>