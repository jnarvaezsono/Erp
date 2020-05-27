<table class="table table-hover">
    <tbody>
        <tr>
            <th>No. Presup</th>
            <th>Tipo</th>
            <th>Proveedor</th>
            <th>Servicio</th>
            <th style="text-align: center">Total</th>
            <th></th>
        </tr>
        <?php foreach ($detail['result'] as $d) : ?>
            <tr>
                <td><?=$d->ppto?></td>
                <td><?= strtoupper($d->tpo_presup)?></td>
                <td><?= ($d->tpo_presup == 'interna')?'SONOVISTA':strtoupper($d->proveedor)?></td>
                <td><?= strtoupper($d->tipo_servicio)?></td>
                <td style="text-align: center">$ <?=  number_format($d->vlr_total,2,',','.')?></td>
                <td>
                    <button style="margin-left:5px" class="btn btn-danger btn-xs"  onclick="DeleteDetail(<?=$d->factura_presupid?>,<?=$d->modulo_id?>,<?=$d->ppto?>)" title="Eliminar"><span class="fa fa-trash" aria-hidden="true"></span></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>