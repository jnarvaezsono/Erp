<table class="table table-bordered table-striped table-condensed " style="width: 100%">
    <tr>
        <th style="text-align: center; width:10%">Op</th>
        <th style="text-align: center">Descripcion</th>
    </tr>
    <?php foreach ($result as $v) : ?>
    <tr ondblclick="nav(<?= $v->id_op ?>,'op')" style="cursor:pointer">
            <td style="text-align: center"><?= $v->id_op ?></td>
            <td ><?= $v->descripcion_op ?></td>
        </tr>
    <?php endforeach ?>
</table>

