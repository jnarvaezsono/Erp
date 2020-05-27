<table class="table table-hover">
    <tbody>
        <tr>
            <th>#</th>
            <th>Detalle</th>
            <th style="text-align: center">Total</th>
            <th></th>
        </tr>
        <?php $count = 1; foreach ($detail as $d) : ?>
            <tr>
                <td><?=$count++?></td>
                <td style="width: 60%"><?=$d->detalle?></td>
                <td style="text-align: center">$ <?=  number_format($d->total,2,',','.')?></td>
                <td>
                    <?php if(empty($d->orden_costo)): ?>
                    <button style="margin-left:2px" class="btn btn-info btn-xs" onclick="OpenDetail(<?=$d->id_detalle?>)"  title="Editar"><span class="fa fa-edit" aria-hidden="true"></span></button>
                    <?php endif; ?>
                    <button style="margin-left:2px" class="btn btn-danger btn-xs"  onclick="DeleteDetail(<?=$d->id_detalle?>,<?=(empty($d->orden_costo))?0:$d->orden_costo?>,<?=$d->total?>)" title="Eliminar"><span class="fa fa-trash" aria-hidden="true"></span></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>