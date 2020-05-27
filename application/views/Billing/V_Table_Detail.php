<table class="table table-condensed" id="table-ppto">
    <thead>
        <tr>
            <th style="text-align: center;">Sel</th>
            <th style="text-align: center;">Ppto</th>
            <th>Pieza</th>
            <th>Proveedor</th>
            <th>Producto</th>
            <th style="text-align: center;">N.Credito</th>
            <th style="text-align: center; width:100px">Valor Bruto</th>
            <th style="text-align: center; width:100px">Descuento</th>
            <th style="text-align: center; width:100px">Iva</th>
            <th style="text-align: center; width:100px">Spa</th>
            <th style="text-align: center; width:100px">Iva Spa</th>
            <th style="text-align: center; width:100px">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($detail as $v) : ?>
            <tr id="tr-<?= $v->ppto ?>" type="<?= $v->tpo_presup ?>" detalle="<?= $v->factura_presupid ?>">
                <td style="text-align: center;"><input type="checkbox" class="minimal-red" id="ck-<?= $v->ppto ?>"></td>
                <td style="text-align: center;"><?= $v->ppto ?></td>
                <td><?= $v->tipo_servicio ?></td>
                <td><?= $v->proveedor ?></td>
                <td><?= $v->producto ?></td>
                <td style="text-align: center;" class="nota-<?= $v->ppto ?>"><?= ($v->nota == 1) ? 'SI' : 'NO' ?></td>
                <td style="text-align: center;"><input type="text" onkeyup='SumaTotal(this,<?= $v->ppto ?>)' style="text-align: center;width: 100%;" disabled class="vlr_bruto_<?= $v->ppto ?> form-control input-sm decimals" value="<?= $v->vlr_bruto ?>" /></td>
                <td style="text-align: center;"><input type="text" onkeyup='SumaTotal(this,<?= $v->ppto ?>)' style="text-align: center;width: 100%;" disabled class="vlr_desc_<?= $v->ppto ?> form-control input-sm decimals" value="<?= $v->vlr_desc ?>" /></td>
                <td style="text-align: center;"><input type="text" onkeyup='SumaTotal(this,<?= $v->ppto ?>)' style="text-align: center;width: 100%;" disabled class="vlr_iva_<?= $v->ppto ?> form-control input-sm decimals" value="<?= $v->vlr_iva ?>" /></td>
                <td style="text-align: center;"><input type="text" onkeyup='SumaTotal(this,<?= $v->ppto ?>)' style="text-align: center;width: 100%;" disabled class="vlr_spa_<?= $v->ppto ?> form-control input-sm decimals" value="<?= $v->vlr_spa ?>" /></td>
                <td style="text-align: center;"><input type="text" onkeyup='SumaTotal(this,<?= $v->ppto ?>)' style="text-align: center;width: 100%;" disabled class="vlr_ivaspa_<?= $v->ppto ?> form-control input-sm decimals" value="<?= $v->vlr_ivaspa ?>" /></td>
                <td style="text-align: center;"><input type="text" readonly style="text-align: center;width: 100%;" class="vlr_total_<?= $v->ppto ?> form-control input-sm numerico" value="<?= $v->vlr_total ?>" /></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>