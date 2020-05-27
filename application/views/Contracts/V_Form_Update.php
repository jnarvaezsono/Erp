<div class="content-wrapper">
    <section class="content">
        <div class="box">
<!--            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-fw fa-edit"></i> FORM CONTRATO </h3>
            </div>-->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="<?=($info->id == $id)?'active':''?>"><a href="#tab_0" data-toggle="tab">CONTRATO INICIAL</a></li>
                                <?php 
                                $cont = 1;
                                foreach ($renov as $l) : ?>
                                    <li class="<?=($l->id == $id)?'active':''?>"><a href="#tab_<?=$l->id?>" data-toggle="tab">OTRO SI (<?=$cont++?>)</a></li>
                                <?php endforeach;?>
                                <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                            </ul>
                            <div class="tab-content">
                                    <div class="tab-pane <?=($info->id == $id)?'active':''?>" id="tab_0">
                                        <?php if($info->id == $id){?><form role="form" id="form" method="POST" enctype="multipart/form-data"><?php } ?>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Fec. Inicio:</label>
                                                        <div class="input-group date">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </div>
                                                            <?PHP if($info->id == $id): ?>
                                                                <input type="text" class="form-control picker pull-right required" name="fecha_inicio" id="fecha_inicio" value="<?= $info->fecha_inicio ?>">
                                                            <?PHP else: ?>
                                                                <input type="text" class="form-control picker pull-right" disabled readonly value="<?= $info->fecha_inicio ?>">
                                                            <?PHP endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Fec. Vencimiento:</label>
                                                        <div class="input-group date">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </div>
                                                            <?PHP if($info->id == $id): ?>
                                                                <input type="text" class="form-control picker pull-right required" name="fecha_vencimiento" id="fecha_vencimiento" value="<?= $info->fecha_vencimiento ?>">
                                                            <?PHP else: ?>
                                                                <input type="text" class="form-control picker pull-right" disabled readonly value="<?= $info->fecha_vencimiento ?>">
                                                            <?PHP endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Tipo</label>
                                                        <?PHP if($info->id == $id): ?>
                                                            <select class="form-control select2 required" style="width: 100%;" name="tipo" id="tipo">
                                                                <option value="">. . .</option>
                                                                <option value="ACUERDO COMERCIAL" <?= ($info->tipo == 'ACUERDO COMERCIAL') ? 'selected' : '' ?>>ACUERDO COMERCIAL</option>
                                                                <option value="ACUERDO CONFIDENCIALIDAD" <?= ($info->tipo == 'ACUERDO CONFIDENCIALIDAD') ? 'selected' : '' ?>>ACUERDO CONFIDENCIALIDAD</option>
                                                                <option value="ACUERDO PROVEEDOR" <?= ($info->tipo == 'ACUERDO PROVEEDOR') ? 'selected' : '' ?>>ACUERDO PROVEEDOR</option>
                                                                <option value="CONTRATO" <?= ($info->tipo == 'CONTRATO') ? 'selected' : '' ?>>CONTRATO</option>
                                                                <option value="CONTRATO SENA" <?= ($info->tipo == 'CONTRATO SENA') ? 'selected' : '' ?>>CONTRATO SENA</option>
                                                                <option value="LICENCIA" <?= ($info->tipo == 'LICENCIA') ? 'selected' : '' ?>>LICENCIA</option>
                                                                <option value="SUSCRIPCION" <?= ($info->tipo == 'SUSCRIPCION') ? 'selected' : '' ?>>SUSCRIPCIÓN</option>
                                                            </select>
                                                        <?PHP else: ?>
                                                            <select class="form-control select2" disabled readonly style="width: 100%;" >
                                                                <option value="">. . .</option>
                                                                <option value="ACUERDO COMERCIAL" <?= ($info->tipo == 'ACUERDO COMERCIAL') ? 'selected' : '' ?>>ACUERDO COMERCIAL</option>
                                                                <option value="ACUERDO CONFIDENCIALIDAD" <?= ($info->tipo == 'ACUERDO CONFIDENCIALIDAD') ? 'selected' : '' ?>>ACUERDO CONFIDENCIALIDAD</option>
                                                                <option value="ACUERDO PROVEEDOR" <?= ($info->tipo == 'ACUERDO PROVEEDOR') ? 'selected' : '' ?>>ACUERDO PROVEEDOR</option>
                                                                <option value="CONTRATO" <?= ($info->tipo == 'CONTRATO') ? 'selected' : '' ?>>CONTRATO</option>
                                                                <option value="CONTRATO SENA" <?= ($info->tipo == 'CONTRATO SENA') ? 'selected' : '' ?>>CONTRATO SENA</option>
                                                                <option value="LICENCIA" <?= ($info->tipo == 'LICENCIA') ? 'selected' : '' ?>>LICENCIA</option>
                                                                <option value="SUSCRIPCION" <?= ($info->tipo == 'SUSCRIPCION') ? 'selected' : '' ?>>SUSCRIPCIÓN</option>
                                                            </select>
                                                        <?PHP endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Numero Contrato</label>
                                                        <?PHP if($info->id == $id): ?>
                                                            <input type="text" class="form-control"  name="numero" id="numero" value="<?= $info->numero ?>" />
                                                        <?PHP else: ?>
                                                            <input type="text" class="form-control" disabled readonly value="<?= $info->numero ?>" />
                                                        <?PHP endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Contra Parte</label>
                                                        <?PHP if($info->id == $id): ?>
                                                            <select class="form-control select2" style="width: 100%;" name="parte" id="parte">
                                                                <option value="CLIENTE" <?= ($info->parte == 'CLIENTE') ? 'selected' : '' ?>>CLIENTE</option>
                                                                <option value="PROVEEDOR" <?= ($info->parte == 'PROVEEDOR') ? 'selected' : '' ?>>PROVEEDOR</option>
                                                            </select>
                                                        <?PHP else: ?>
                                                            <select class="form-control select2" disabled readonly style="width: 100%;" >
                                                                <option value="CLIENTE" <?= ($info->parte == 'CLIENTE') ? 'selected' : '' ?>>CLIENTE</option>
                                                                <option value="PROVEEDOR" <?= ($info->parte == 'PROVEEDOR') ? 'selected' : '' ?>>PROVEEDOR</option>
                                                            </select>
                                                        <?PHP endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Nombre Contra Parte</label>
                                                        <?PHP if($info->id == $id): ?>
                                                            <select class="form-control select2 required" style="width: 100%;" name="contra_parte" id="contra_parte">
                                                                <option value="">. . .</option>
                                                                <?php foreach ($clientes as $v) : ?>
                                                                    <option value="<?= $v->id_client ?>" <?= ($info->contra_parte == $v->id_client) ? 'selected' : '' ?>><?= $v->nombre ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        <?PHP else: ?>
                                                            <select class="form-control select2" disabled readonly style="width: 100%;" >
                                                                <option value="">. . .</option>
                                                                <?php foreach ($clientes as $v) : ?>
                                                                    <option value="<?= $v->id_client ?>" <?= ($info->contra_parte == $v->id_client) ? 'selected' : '' ?>><?= $v->nombre ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        <?PHP endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Responsable</label>
                                                        <?PHP if($info->id == $id): ?>
                                                            <select class="form-control select2" style="width: 100%;" name="responsable" id="responsable">
                                                                <option value="GERENCIA ADMINISTRATIVA" <?= ($info->responsable == 'GERENCIA ADMINISTRATIVA') ? 'selected' : '' ?>>GERENCIA ADMINISTRATIVA</option>
                                                                <option value="GERENCIA COMERCIAL" <?= ($info->responsable == 'GERENCIA COMERCIAL') ? 'selected' : '' ?>>GERENCIA COMERCIAL</option>
                                                                <option value="GERENCIA MEDIOS" <?= ($info->responsable == 'GERENCIA MEDIOS') ? 'selected' : '' ?>>GERENCIA MEDIOS</option>
                                                            </select>
                                                        <?PHP else: ?>
                                                            <select class="form-control select2" disabled readonly style="width: 100%;">
                                                                <option value="GERENCIA ADMINISTRATIVA" <?= ($info->responsable == 'GERENCIA ADMINISTRATIVA') ? 'selected' : '' ?>>GERENCIA ADMINISTRATIVA</option>
                                                                <option value="GERENCIA COMERCIAL" <?= ($info->responsable == 'GERENCIA COMERCIAL') ? 'selected' : '' ?>>GERENCIA COMERCIAL</option>
                                                                <option value="GERENCIA MEDIOS" <?= ($info->responsable == 'GERENCIA MEDIOS') ? 'selected' : '' ?>>GERENCIA MEDIOS</option>
                                                            </select>
                                                        <?PHP endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Valor</label>
                                                        <?PHP if($info->id == $id): ?>
                                                            <input type="text" class="form-control numerico"  name="valor" id="valor" value="<?= $info->valor ?>"/>
                                                        <?PHP else: ?>
                                                            <input type="text" class="form-control numerico" disabled readonly value="<?= $info->valor ?>"/>
                                                        <?PHP endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Forma Pago</label>
                                                        <?PHP if($info->id == $id): ?>
                                                            <input type="text" class="form-control"  name="forma_pago" id="forma_pago" value="<?= $info->forma_pago ?>"/>
                                                        <?PHP else: ?>
                                                            <input type="text" class="form-control" disabled readonly value="<?= $info->forma_pago ?>"/>
                                                        <?PHP endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tipo Poliza</label>
                                                        <?PHP 
                                                        $arr = explode(',', $info->tipo_poliza);
                                                        
                                                        if($info->id == $id): ?>
                                                            <select class="form-control select2" style="width: 100%;" multiple name="tipo_poliza" id="tipo_poliza">
                                                                <option value="">. . .</option>
                                                                <option value="CUMPLIMIENTO" <?= in_array('CUMPLIMIENTO',$arr) ? 'selected' : '' ?>>CUMPLIMIENTO</option>
                                                                <option value="RESPONSABILIDAD CIVIL" <?= in_array('RESPONSABILIDAD CIVIL',$arr) ? 'selected' : '' ?>>RESPONSABILIDAD CIVIL</option>
                                                            </select>
                                                        <?PHP else: ?>
                                                            <select class="form-control select2" disabled readonly multiple style="width: 100%;">
                                                                <option value="">. . .</option>
                                                                <option value="CUMPLIMIENTO" <?= in_array('CUMPLIMIENTO',$arr) ? 'selected' : '' ?>>CUMPLIMIENTO</option>
                                                                <option value="RESPONSABILIDAD CIVIL" <?= in_array('RESPONSABILIDAD CIVIL',$arr) ? 'selected' : '' ?>>RESPONSABILIDAD CIVIL</option>
                                                            </select>
                                                        <?PHP endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Emisor Poliza</label>
                                                        <?PHP if($info->id == $id): ?>
                                                            <input type="text" class="form-control"  name="emisor_poliza" id="emisor_poliza" value="<?= $info->emisor_poliza ?>" />
                                                        <?PHP else: ?>
                                                            <input type="text" class="form-control" disabled readonly  value="<?= $info->emisor_poliza ?>" />
                                                        <?PHP endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Obligaciones Contra Parte</label>
                                                        <?PHP if($info->id == $id): ?>
                                                            <textarea type="text" class="form-control" rows="2" name="obligaciones_contra_parte" id="obligaciones_contra_parte" ><?= $info->obligaciones_contra_parte ?></textarea>
                                                        <?PHP else: ?>
                                                            <textarea type="text" class="form-control" rows="2" disabled readonly  ><?= $info->obligaciones_contra_parte ?></textarea>
                                                        <?PHP endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Obligaciones Sonovista</label>
                                                        <?PHP if($info->id == $id): ?>
                                                        <textarea type="text" class="form-control" rows="2"  name="obligaciones_sonovista" id="obligaciones_sonovista" ><?= $info->obligaciones_sonovista ?></textarea>
                                                        <?PHP else: ?>
                                                        <textarea type="text" class="form-control" rows="2" disabled readonly  ><?= $info->obligaciones_sonovista ?></textarea>
                                                        <?PHP endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Objeto</label>
                                                        <?PHP if($info->id == $id): ?>
                                                            <textarea type="text" rows="2" class="form-control"  name="objeto" id="objeto" ><?= $info->objeto ?></textarea>
                                                        <?PHP else: ?>
                                                            <textarea type="text" rows="2" class="form-control" disabled readonly  ><?= $info->objeto ?></textarea>
                                                        <?PHP endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Anexos</label>
                                                        <?PHP if($info->id == $id): ?>
                                                            <textarea type="text" rows="2" class="form-control"  name="anexos" id="anexos" ><?= $info->anexos ?></textarea>
                                                        <?PHP else: ?>
                                                            <textarea type="text" rows="2" class="form-control" disabled readonly ><?= $info->anexos ?></textarea>
                                                        <?PHP endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="history-<?=$info->id?>">
                                                    <?=$history[$info->id]?>
                                                </div>
                                            </div>
                                        <?php if($info->id == $id){?></form><?php } ?>
                                    </div>
                                <?php foreach ($renov as $l) : ?>
                                    <div class="tab-pane <?=($l->id == $id)?'active':''?> " id="tab_<?=$l->id?>">
                                        <?php if($l->id == $id){?><form role="form" id="form" method="POST" enctype="multipart/form-data"><?php } ?>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Fec. Inicio:</label>
                                                        <div class="input-group date">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </div>
                                                            <?PHP if($l->id == $id): ?>
                                                                <input type="text" class="form-control picker pull-right required" name="fecha_inicio" id="fecha_inicio" value="<?= $l->fecha_inicio ?>">
                                                            <?PHP else: ?>
                                                                <input type="text" class="form-control picker pull-right" disabled readonly value="<?= $l->fecha_inicio ?>">
                                                            <?PHP endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Fec. Vencimiento:</label>
                                                        <div class="input-group date">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </div>
                                                            <?PHP if($l->id == $id): ?>
                                                                <input type="text" class="form-control picker pull-right required" name="fecha_vencimiento" id="fecha_vencimiento" value="<?= $l->fecha_vencimiento ?>">
                                                            <?PHP else: ?>
                                                                <input type="text" class="form-control picker pull-right" disabled readonly value="<?= $l->fecha_vencimiento ?>">
                                                            <?PHP endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Tipo</label>
                                                        <?PHP if($l->id == $id): ?>
                                                            <select class="form-control select2 required" style="width: 100%;" name="tipo" id="tipo">
                                                                <option value="">. . .</option>
                                                                <option value="ACUERDO CONFIDENCIALIDAD" <?= ($l->tipo == 'ACUERDO CONFIDENCIALIDAD') ? 'selected' : '' ?>>ACUERDO CONFIDENCIALIDAD</option>
                                                                <option value="ACUERDO PROVEEDOR" <?= ($l->tipo == 'ACUERDO PROVEEDOR') ? 'selected' : '' ?>>ACUERDO PROVEEDOR</option>
                                                                <option value="CONTRATO" <?= ($l->tipo == 'CONTRATO') ? 'selected' : '' ?>>CONTRATO</option>
                                                            </select>
                                                        <?PHP else: ?>
                                                            <select class="form-control select2" disabled readonly style="width: 100%;" >
                                                                <option value="">. . .</option>
                                                                <option value="ACUERDO CONFIDENCIALIDAD" <?= ($l->tipo == 'ACUERDO CONFIDENCIALIDAD') ? 'selected' : '' ?>>ACUERDO CONFIDENCIALIDAD</option>
                                                                <option value="ACUERDO PROVEEDOR" <?= ($l->tipo == 'ACUERDO PROVEEDOR') ? 'selected' : '' ?>>ACUERDO PROVEEDOR</option>
                                                                <option value="CONTRATO" <?= ($l->tipo == 'CONTRATO') ? 'selected' : '' ?>>CONTRATO</option>
                                                            </select>
                                                        <?PHP endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Numero Contrato</label>
                                                        <?PHP if($l->id == $id): ?>
                                                            <input type="text" class="form-control"  name="numero" id="numero" value="<?= $l->numero ?>" />
                                                        <?PHP else: ?>
                                                            <input type="text" class="form-control" disabled readonly value="<?= $l->numero ?>" />
                                                        <?PHP endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Contra Parte</label>
                                                        <?PHP if($l->id == $id): ?>
                                                            <select class="form-control select2" style="width: 100%;" name="parte" id="parte">
                                                                <option value="CLIENTE" <?= ($l->parte == 'CLIENTE') ? 'selected' : '' ?>>CLIENTE</option>
                                                                <option value="PROVEEDOR" <?= ($l->parte == 'PROVEEDOR') ? 'selected' : '' ?>>PROVEEDOR</option>
                                                            </select>
                                                        <?PHP else: ?>
                                                            <select class="form-control select2" disabled readonly style="width: 100%;" >
                                                                <option value="CLIENTE" <?= ($l->parte == 'CLIENTE') ? 'selected' : '' ?>>CLIENTE</option>
                                                                <option value="PROVEEDOR" <?= ($l->parte == 'PROVEEDOR') ? 'selected' : '' ?>>PROVEEDOR</option>
                                                            </select>
                                                        <?PHP endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Nombre Contra Parte</label>
                                                        <?PHP if($l->id == $id): ?>
                                                            <select class="form-control select2 required" style="width: 100%;" name="contra_parte" id="contra_parte">
                                                                <option value="">. . .</option>
                                                                <?php foreach ($clientes as $v) : ?>
                                                                    <option value="<?= $v->id_client ?>" <?= ($l->contra_parte == $v->id_client) ? 'selected' : '' ?>><?= $v->nombre ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        <?PHP else: ?>
                                                            <select class="form-control select2" disabled readonly style="width: 100%;" >
                                                                <option value="">. . .</option>
                                                                <?php foreach ($clientes as $v) : ?>
                                                                    <option value="<?= $v->id_client ?>" <?= ($l->contra_parte == $v->id_client) ? 'selected' : '' ?>><?= $v->nombre ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        <?PHP endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Responsable</label>
                                                        <?PHP if($l->id == $id): ?>
                                                            <select class="form-control select2" style="width: 100%;" name="responsable" id="responsable">
                                                                <option value="GERENCIA ADMINISTRATIVA" <?= ($l->responsable == 'GERENCIA ADMINISTRATIVA') ? 'selected' : '' ?>>GERENCIA ADMINISTRATIVA</option>
                                                                <option value="GERENCIA COMERCIAL" <?= ($l->responsable == 'GERENCIA COMERCIAL') ? 'selected' : '' ?>>GERENCIA COMERCIAL</option>
                                                                <option value="GERENCIA MEDIOS" <?= ($l->responsable == 'GERENCIA MEDIOS') ? 'selected' : '' ?>>GERENCIA MEDIOS</option>
                                                            </select>
                                                        <?PHP else: ?>
                                                            <select class="form-control select2" disabled readonly style="width: 100%;">
                                                                <option value="GERENCIA ADMINISTRATIVA" <?= ($l->responsable == 'GERENCIA ADMINISTRATIVA') ? 'selected' : '' ?>>GERENCIA ADMINISTRATIVA</option>
                                                                <option value="GERENCIA COMERCIAL" <?= ($l->responsable == 'GERENCIA COMERCIAL') ? 'selected' : '' ?>>GERENCIA COMERCIAL</option>
                                                                <option value="GERENCIA MEDIOS" <?= ($l->responsable == 'GERENCIA MEDIOS') ? 'selected' : '' ?>>GERENCIA MEDIOS</option>
                                                            </select>
                                                        <?PHP endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Valor</label>
                                                        <?PHP if($l->id == $id): ?>
                                                            <input type="text" class="form-control numerico"  name="valor" id="valor" value="<?= $l->valor ?>"/>
                                                        <?PHP else: ?>
                                                            <input type="text" class="form-control numerico" disabled readonly value="<?= $l->valor ?>"/>
                                                        <?PHP endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Forma Pago</label>
                                                        <?PHP if($l->id == $id): ?>
                                                            <input type="text" class="form-control"  name="forma_pago" id="forma_pago" value="<?= $l->forma_pago ?>"/>
                                                        <?PHP else: ?>
                                                            <input type="text" class="form-control" disabled readonly value="<?= $l->forma_pago ?>"/>
                                                        <?PHP endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tipo Poliza</label>
                                                        <?PHP 
                                                        $arr = explode(',', $l->tipo_poliza);
                                                        
                                                        if($l->id == $id): ?>
                                                            <select class="form-control select2" style="width: 100%;" multiple name="tipo_poliza" id="tipo_poliza">
                                                                <option value="">. . .</option>
                                                                <option value="CUMPLIMIENTO" <?= in_array('CUMPLIMIENTO',$arr) ? 'selected' : '' ?>>CUMPLIMIENTO</option>
                                                                <option value="RESPONSABILIDAD CIVIL" <?= in_array('RESPONSABILIDAD CIVIL',$arr) ? 'selected' : '' ?>>RESPONSABILIDAD CIVIL</option>
                                                            </select>
                                                        <?PHP else: ?>
                                                            <select class="form-control select2" disabled readonly multiple style="width: 100%;">
                                                                <option value="">. . .</option>
                                                                <option value="CUMPLIMIENTO" <?= in_array('CUMPLIMIENTO',$arr) ? 'selected' : '' ?>>CUMPLIMIENTO</option>
                                                                <option value="RESPONSABILIDAD CIVIL" <?= in_array('RESPONSABILIDAD CIVIL',$arr) ? 'selected' : '' ?>>RESPONSABILIDAD CIVIL</option>
                                                            </select>
                                                        <?PHP endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Emisor Poliza</label>
                                                        <?PHP if($l->id == $id): ?>
                                                            <input type="text" class="form-control"  name="emisor_poliza" id="emisor_poliza" value="<?= $l->emisor_poliza ?>" />
                                                        <?PHP else: ?>
                                                            <input type="text" class="form-control" disabled readonly  value="<?= $l->emisor_poliza ?>" />
                                                        <?PHP endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Obligaciones Contra Parte</label>
                                                        <?PHP if($l->id == $id): ?>
                                                            <textarea type="text" class="form-control" rows="2" name="obligaciones_contra_parte" id="obligaciones_contra_parte" ><?= $l->obligaciones_contra_parte ?></textarea>
                                                        <?PHP else: ?>
                                                            <textarea type="text" class="form-control" rows="2" disabled readonly  ><?= $l->obligaciones_contra_parte ?></textarea>
                                                        <?PHP endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Obligaciones Sonovista</label>
                                                        <?PHP if($l->id == $id): ?>
                                                        <textarea type="text" class="form-control" rows="2"  name="obligaciones_sonovista" id="obligaciones_sonovista" ><?= $l->obligaciones_sonovista ?></textarea>
                                                        <?PHP else: ?>
                                                        <textarea type="text" class="form-control" rows="2" disabled readonly  ><?= $l->obligaciones_sonovista ?></textarea>
                                                        <?PHP endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Objeto</label>
                                                        <?PHP if($l->id == $id): ?>
                                                            <textarea type="text" rows="2" class="form-control"  name="objeto" id="objeto" ><?= $l->objeto ?></textarea>
                                                        <?PHP else: ?>
                                                            <textarea type="text" rows="2" class="form-control" disabled readonly  ><?= $l->objeto ?></textarea>
                                                        <?PHP endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Anexos</label>
                                                        <?PHP if($l->id == $id): ?>
                                                            <textarea type="text" rows="2" class="form-control"  name="anexos" id="anexos" ><?= $l->anexos ?></textarea>
                                                        <?PHP else: ?>
                                                            <textarea type="text" rows="2" class="form-control" disabled readonly ><?= $l->anexos ?></textarea>
                                                        <?PHP endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="history-<?=$l->id?>">
                                                    <?=$history[$l->id]?>
                                                </div>
                                            </div>
                                        <?php if($l->id == $id){?></form><?php } ?>
                                    </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-default btn-sm">Cancelar</button>
                <button type="submit" class="btn btn-default btn-sm" id="list"><i class="fa fa-fw fa-list"></i> Listar</button>
                <?php if($info->id_estado == 1 && $info->id_user == $this->session->IdUser): ?>
                    <button type="submit" class="btn btn-default btn-sm "  id="renovate"><i class="fa fa-fw fa-refresh"></i> Otro SI</button>
                    <button type="submit" class="btn btn-primary btn-sm pull-right" id="save"><i class="fa fa-fw fa-save"></i> Guardar</button>
                    <?php if(count($renov) <= 0 && $info->id_user == $this->session->IdUser): ?>
                        <button type="submit" class="btn btn-danger btn-sm pull-right" style="margin-right: 5px" id="anule"><i class="fa fa-fw fa-trash-o"></i> Anular</button>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="modal-anule">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="anule-title">Anular Contrato</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Motivo</label>
                    <textarea class="form-control" id="motivo" rows="3" placeholder="Enter ..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn  btn-warning pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn  btn-primary pull-right" id="btn-anule"  >Aceptar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.picker').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
        });
        
        $('.select2').select2();
        
        $('.numerico').autoNumeric('init', {
            mDec: 0,
            aDec: ',',
            aSep: '.'
        }); 
        
        
        $("#parte").change(function(){
            $.post('<?= base_url() ?>Contracts/C_Contracts/LoadClients',{parte:$('#parte').val()},function(data){
                var options = '<option value="">. . .</option>';
                $.each(data,function(e,i){
                    options += '<option value="'+i.id_client+'">'+i.nombre+'</option>';
                });
                $('#contra_parte').html(options);
            },'json');
        });
 
        $("#list").click(function () {
            window.location.href = '<?= base_url() ?>Contracts'
        });
        
        $("#renovate").click(function () {
            
            var ini =  $('#fecha_inicio').val();
            var fin =  $('#fecha_vencimiento').val();
            if (validatefield('required')) {
                if(fin < ini){
                    swal({title: 'Error!', text: 'La fecha de vencimiento debe ser mayor a la fecha de inicio', type: 'error'});
                }else{
                    swal({
                        title: 'Confirmar?',
                        text: "Agregar otro si al contrato seleccionado?",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Aceptar!',
                        reverseButtons: true
                    }).then((result) => {
                        if (result) {
                            Renovate();
                        }
                    }, function (dismiss) {
                        if (dismiss === 'cancel') {

                        }
                    }).catch(swal.noop)
                   
                }
            } else {
                alertify.error("DATOS INCOMPLETOS!");
            }
        });
        
        $("#save").click(function () {
            if (validatefield('required')) {
                Save();
            } else {
                alertify.error("DATOS INCOMPLETOS!");
            }
        });
        
        $("#anule").click(function () {
            $('#modal-anule').modal();
        });
        
        $("#btn-anule").click(function () {
            if($('#motivo').val() != ''){
                $.post('<?= base_url() ?>Contracts/C_Contracts/Anule',{id:<?=$id?>,motivo:$('#motivo').val()},function(data){
                    if(data.res == 'OK'){
                        $('#renovate, #anule, #save').hide();
                        swal({title: 'OK!', text: '', type: 'success'});
                        $('#history-<?=$id?>').html(data.history);
                        $('#modal-anule').modal('hide');
                    } else {
                        swal({title: 'Error!', text: obj.res, type: 'error'});
                    }
                },'json');
            }else{
                swal({title: 'Atención!', text: 'Debe digitar un motivo', type: 'warning'});
            }
        });
        
    });
    
    function Save(){
        $(".overlay_ajax").show();
        
        var poliza = '';
        $.each($('#tipo_poliza').val(), function (e, i) {
            if (poliza != "") {
                poliza += ",";
            }
            poliza += i;
        });

        var formData = new FormData($('#form')[0]);
        formData.append("id", <?=$id?>);
//        formData.append("renovate", renovate);
        formData.append("tipo_poliza", poliza);
        $.ajax({
            url: "<?= base_url() ?>Contracts/C_Contracts/Update",
            type: 'POST',
            data: formData,
            success: function (data) {
                var obj = jQuery.parseJSON(data);
                if (obj.res == "OK") {
                    swal({title: 'OK!', text: '', type: 'success'});
                    if(obj.history != ''){
                        $('#history-<?=$id?>').html(obj.history);
                    }
                } else {
                    swal({title: 'Error!', text: obj.res, type: 'error'});
                }
            },
            global: true,
            cache: false,
            contentType: false,
            processData: false
        }).fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }
    
    function Renovate(){
        var poliza = '';
        $.each($('#tipo_poliza').val(), function (e, i) {
            if (poliza != "") {
                poliza += ",";
            }
            poliza += i;
        });
        
        var formData = new FormData($('#form')[0]);
        formData.append("id", <?=$id?>);
        formData.append("other", <?=$info->id?>);
        formData.append("tipo_poliza", poliza);
        
        $.ajax({
            url: "<?= base_url() ?>Contracts/C_Contracts/Renovate",
            type: 'POST',
            data: formData,
            success: function (data) {
                var obj = jQuery.parseJSON(data);
                if (obj.res == "OK") {
                    swal({title: 'OK!', text: '', type: 'success'});
                    location.reload();
                } else {
                    swal({title: 'Error!', text: obj.res, type: 'error'});
                }
            },
            global: true,
            cache: false,
            contentType: false,
            processData: false
        }).fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }
    
</script>
