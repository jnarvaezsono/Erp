<table class="table table-hover">
    <tbody>
        <tr>
            <th>#</th>
            <th>Producto</th>
            <th style="text-align: center">Cantidad</th>
            <th style="text-align: center">Total</th>
            <th></th>
        </tr>
        <?php $count = 1; foreach ($detail as $d) : ?>
            <tr>
                <td><?=$count++?></td>
                <td><?=$d->producto?></td>
                <td style="text-align: center"><?=$d->cantidad?></td>
                <td style="text-align: center">$ <?=  number_format($d->total,2,',','.')?></td>
                <td>
                    <button style="margin-left:2px" class="btn btn-info btn-xs" onclick="OpenDetail(<?=$d->id_detalle?>)"  title="Editar"><span class="fa fa-edit" aria-hidden="true"></span></button>
                    <button style="margin-left:2px" class="btn btn-danger btn-xs"  onclick="DeleteDetail(<?=$d->id_detalle?>)" title="Eliminar"><span class="fa fa-trash" aria-hidden="true"></span></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>