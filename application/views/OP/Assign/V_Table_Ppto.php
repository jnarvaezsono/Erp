<table class="table table-bordered table-striped table-condensed " style="width: 200px;">
    <tr>
        <th style="text-align: center">Presupuesto</th>
        <th style="text-align: center">Factura</th>
    </tr>
    <?php foreach ($result as $v) : ?>
        <tr>
            <td style="width:50%;text-align: center"><?= $v->ppto ?></td>
            <td style="width:50%;text-align: center"><?= $v->factura ?></td>
        </tr>
    <?php endforeach ?>
</table>
