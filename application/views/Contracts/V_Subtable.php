<table class="table table-bordered table-striped table-condensed " style="width:200px;">
    <tr>
        <th style="text-align: center">#</th>
        <th style="text-align: center">Vencimiento</th>
        <th style="text-align: center">Valor</th>
    </tr>
    <?php 
    $count = 1;
    foreach ($result as $v) : ?>
        <tr>
            <td style="width:5%;text-align: center"><?= $count++ ?></td>
            <td style="width:45%;text-align: center"><?= $v->fecha_vencimiento ?></td>
            <td style="width:50%;text-align: center">$ <?= number_format($v->valor,0,',','.') ?></td>
        </tr>
    <?php endforeach ?>
</table>

