<table class="table table-hover">
    <tbody>
        <tr>
            <th>Titulo</th>
            <th style="text-align: center">Tarifa</th>
            <th>Tamaño</th>
            <th>Total</th>
            <th></th>
        </tr>
        <?php foreach ($detail as $d) : ?>
            <tr>
                <td><?=$d->titulo?></td>
                <td style="text-align: center">$ <?=  number_format($d->tarifa,2,',','.')?></td>
                <td><?=$d->tamano?></td>
                <td style="text-align: center">$ <?=  number_format($d->total,2,',','.')?></td>
                <td>
                    <button style="margin-left:2px" class="btn btn-info btn-xs" onclick="OpenDetail(<?=$d->id_detalle?>)"  title="Editar"><span class="fa fa-edit" aria-hidden="true"></span></button>
                    <button style="margin-left:2px" class="btn btn-danger btn-xs"  onclick="DeleteDetail(<?=$d->id_detalle?>)" title="Eliminar"><span class="fa fa-trash" aria-hidden="true"></span></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>