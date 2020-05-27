<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title">Actualizar <?=$type?></h4>
</div>
<div class="modal-body">

    <form role="form" id="form-edit" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Cliente</label>
                    <div class="input-group">
                        <input type="checkbox" class="minimal-red" id="ck-cl" <?=($info->cliente == 1)?'checked':''?>>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Proveedor</label>
                    <div class="input-group">
                        <input type="checkbox" class="minimal-red" id="ck-pv" <?=($info->proveedor == 1)?'checked':''?> >
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" class="form-control required" id="nombre" value="<?= $info->nombre ?>"  />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="documento">Documento</label>
                    <input type="number" name="documento" class="form-control required" id="documento"  value="<?= $info->documento ?>"/>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="camara">Camara Comercio</label>
                    <input type="text" name="camara" class="form-control " id="camara" value="<?= $info->camara ?>" />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="sap">Cod SAP</label>
                    <input type="text" name="sap" class="form-control required" id="sap" value="<?= $info->sap ?>" />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="nombre_establecimiento">Establecimiento o punto de venta</label>
                    <input type="text" name="nombre_establecimiento" class="form-control required" id="nombre_establecimiento" value="<?= $info->nombre_establecimiento ?>" />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" class="form-control required" id="direccion"  value="<?= $info->direccion ?>"/>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="direccion">Telefono</label>
                    <input type="text" name="telefono" class="form-control required" id="telefono"  value="<?= $info->telefono ?>"/>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="pais">Pais</label>
                    <select name="pais" class="form-control required" id="pais">
                        <option value="">. . .</option>
                        <option value="CO" <?=($info->pais == 'CO')?'selected':'' ?> >COLOMBIA</option>
                        <option value="US" <?=($info->pais == 'US')?'selected':'' ?>>ESTADOS UNIDOS</option>
                        <option value="US" <?=($info->pais == 'MX')?'selected':'' ?>>MEXICO</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="departamento">Departamento</label>  
                    <select name="departamento" class="form-control required" id="departamento">
                        <option value="">. . .</option>
                        <?php foreach ($departamentos as $v) : ?>
                        <option value="<?= $v->nombre ?>" <?=($info->departamento == $v->nombre)?'selected':'' ?> ><?= $v->nombre ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="ciudad">Ciudad</label>
                    <select name="ciudad" class="form-control required" id="ciudad">
                        <option value="">. . .</option>
                        <?php foreach ($ciudades as $v) : ?>
                            <option value="<?= $v->nombre ?>" <?=($info->ciudad == $v->nombre)?'selected':'' ?>><?= $v->nombre ?> (<?= $v->departamento ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group register">
                    <label for="regimen">Regimen</label>
                    <select name="regimen" class="form-control required" id="regimen">
                        <option value="">. . .</option>
                        <option value="2" <?= ($info->regimen == 2) ? 'selected' : '' ?>>Común</option>
                        <option value="0" <?= ($info->regimen == 0) ? 'selected' : '' ?>>Simplificado</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group register">
                    <label for="tipo_documento">Tipo Documento</label>
                    <select name="tipo_documento" class="form-control required" id="tipo_documento">
                        <option value="">. . .</option>
                        <?php foreach ($tipos_doc as $v) : ?>
                            <option value="<?= $v->id_tipo_documento ?>" <?= ($info->tipo_documento == $v->id_tipo_documento) ? 'selected' : '' ?>><?= $v->nombre_tipo_documento ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group register">
                    <label for="tipo_persona">Tipo Persona</label>
                    <select name="tipo_persona" class="form-control required" id="tipo_persona">
                        <option value="">. . .</option>
                        <?php foreach ($tipos_persona as $v) : ?>
                            <option value="<?= $v->id_tipo_persona ?>" <?= ($info->tipo_persona == $v->id_tipo_persona) ? 'selected' : '' ?>><?= $v->nombre_tipo_persona ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="contacto_facturacion">Contacto Facturación</label>
                    <input type="text" name="contacto_facturacion" class="form-control " id="contacto_facturacion"  value="<?= $info->contacto_facturacion ?>"/>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="info_email">Email Facturación</label>
                    <input type="text" name="info_email" class="form-control required" id="info_email"  value="<?= $info->info_email ?>"/>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="telefono_facturacion">Telefono Facturación</label>
                    <input type="text" name="telefono_facturacion" class="form-control " id="telefono_facturacion"  value="<?= $info->telefono_facturacion ?>"/>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group register">
                    <label for="id_status">Estado</label>
                    <select name="id_status" class="form-control required" id="id_status">
                        <option value="">. . .</option>
                        <?php foreach ($status as $e) : ?>
                            <option value="<?= $e->id_status ?>" <?= ($info->id_status == $e->id_status) ? 'selected' : '' ?>><?= $e->description ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group register">
                    <label for="obligaciones">Obligaciones Dian</label>
                    <select name="obligaciones" class="form-control select2 " multiple id="obligaciones">
                        <option value="">. . .</option>
                        <?php 
                        $array_obligaciones = explode(',', $info->obligaciones);
                        foreach ($obligaciones as $v) : ?>
                            <option value="<?= $v->codigo ?>" <?=(in_array($v->codigo, $array_obligaciones))?'selected':''?>><?= $v->descripcion ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">CANCELAR</button>
    <!--<button type="button" class="btn btn-primary create" onclick="CreateRol()">CREAR</button>-->
    <button type="button" class="btn btn-primary update" onclick="UpdateClient(<?= $info->id_client ?>)" >ACTUALIZAR</button>
</div>