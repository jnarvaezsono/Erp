<table class="table table-hover">
    <tbody>
        <tr>
            <th>Servicio</th>
            <th style="text-align: center">Cantidad</th>
            <th>Total</th>
            <th>Detalle</th>
            <th></th>
        </tr>
        <?php foreach ($detail as $d) : ?>
            <tr>
                <td><?=$d->servicio?></td>
                <td style="text-align: center"><?=$d->cantidad?></td>
                <td>$<?=  number_format($d->total,2,',','.')?></td>
                <td><?=$d->detalle?></td>
                <td style="width:75px;">
                    <?php if(empty($d->orden_costo)): ?>
                        <button style="margin-left:2px" class="btn btn-info btn-xs" onclick="OpenDetail(<?=$d->id_detalle?>)"  title="Editar"><span class="fa fa-edit" aria-hidden="true"></span></button>
                    <?php else: 
                        $d->valor = $d->valor / (($d->aumento/100)+1);
                    ?>
                        <button style="margin-left:2px" disabled class="btn btn-default btn-xs"  title="Editar"><span class="fa fa-edit" aria-hidden="true"></span></button>
                    <?php endif; ?>
                    <button style="margin-left:2px" class="btn btn-danger btn-xs"  onclick="DeleteDetail(<?=$d->id_detalle?>,<?=(empty($d->orden_costo))?0:$d->orden_costo?>,<?=$d->valor?>)" title="Eliminar"><span class="fa fa-trash" aria-hidden="true"></span></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>