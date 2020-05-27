<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title">Crear <?=$type?></h4>
</div>
<div class="modal-body">

    <form role="form" id="form-create" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Cliente</label>
                    <div class="input-group">
                        <input type="checkbox" class="minimal-red" id="ck-cl" >
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Proveedor</label>
                    <div class="input-group">
                        <input type="checkbox" class="minimal-red" id="ck-pv" >
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" class="form-control required" id="nombre"   />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="documento">Documento</label>
                    <input type="number" name="documento" class="form-control required" id="documento"  />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="camara">Camara Comercio</label>
                    <input type="text" name="camara" class="form-control " id="camara" value="" />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="sap">Cod SAP</label>
                    <input type="text" name="sap" class="form-control required" id="sap"  />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="nombre_establecimiento">Establecimiento o punto de venta</label>
                    <input type="text" name="nombre_establecimiento" class="form-control required" id="nombre_establecimiento"  />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" class="form-control required" id="direccion"  />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="direccion">Telefono</label>
                    <input type="text" name="telefono" class="form-control required" id="telefono"  />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="departamento">Departamento</label>
                    <select name="departamento" class="form-control required" id="departamento">
                        <option value="">. . .</option>
                        <?php foreach ($departamentos as $v) : ?>
                            <option value="<?= $v->nombre ?>"><?= $v->nombre ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="pais">Pais</label>
                    <select name="pais" class="form-control required" id="pais">
                        <option value="">. . .</option>
                        <option value="CO">COLOMBIA</option>
                        <option value="US">ESTADOS UNIDOS</option>
                        <option value="MX">MEXICO</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="ciudad">Ciudad</label>
                    <select name="ciudad" class="form-control required" id="ciudad">
                        <option value="">. . .</option>
                        <?php foreach ($ciudades as $v) : ?>
                            <option value="<?= $v->nombre ?>"><?= $v->nombre ?> (<?= $v->departamento ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group register">
                    <label for="regimen">Regimen</label>
                    <select name="regimen" class="form-control required" id="regimen">
                        <option value="">. . .</option>
                        <option value="2" >Común</option>
                        <option value="0" >Simplificado</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group register">
                    <label for="tipo_documento">Tipo Documento</label>
                    <select name="tipo_documento" class="form-control required" id="tipo_documento">
                        <option value="">. . .</option>
                        <?php foreach ($tipos_doc as $v) : ?>
                            <option value="<?= $v->id_tipo_documento ?>"><?= $v->nombre_tipo_documento ?></option>
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
                            <option value="<?= $v->id_tipo_persona ?>" ><?= $v->nombre_tipo_persona ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="contacto_facturacion">Contacto Facturación</label>
                    <input type="text" name="contacto_facturacion" class="form-control " id="contacto_facturacion"  />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="info_email">Email Facturación</label>
                    <input type="text" name="info_email" class="form-control required" id="info_email" value="angie.santiago@sonovista.co " />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="telefono_facturacion">Telefono Facturación</label>
                    <input type="text" name="telefono_facturacion" class="form-control " id="telefono_facturacion" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group register">
                    <label for="obligaciones">Obligaciones Dian</label>
                    <select name="obligaciones" class="form-control select2 " multiple id="obligaciones">
                        <option value="">. . .</option>
                        <?php foreach ($obligaciones as $v) : ?>
                            <option value="<?= $v->codigo ?>" ><?= $v->descripcion ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">CANCELAR</button>
    <button type="button" class="btn btn-primary create" onclick="CreateClient()">CREAR</button>
</div>