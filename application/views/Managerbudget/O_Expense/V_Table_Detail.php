<table class="table table-hover">
    <tbody>
        <tr>
            <th>Detalle</th>
            <th>Total</th>
            <th></th>
        </tr>
        <?php foreach ($detail as $d) : ?>
            <tr>
                <td><?=$d->detalle?></td>
                <td>$<?=  number_format($d->total,2,',','.')?></td>
                <td style="width: 75px;">
                    <button style="margin-left:5px" class="btn btn-info btn-xs" onclick="OpenDetail(<?=$d->id_detalle?>)"  title="Editar"><span class="fa fa-edit" aria-hidden="true"></span></button>
                    <button style="margin-left:5px" class="btn btn-danger btn-xs"  onclick="DeleteDetail(<?=$d->id_detalle?>,<?=$d->valor?>)" title="Eliminar"><span class="fa fa-trash" aria-hidden="true"></span></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>