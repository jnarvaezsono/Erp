<table class="table table-bordered table-striped table-condensed " style="width: 100%">
    <tr>
        <th style="text-align: center; width:10%">Tarea</th>
        <th style="text-align: center">OP</th>
        <th style="text-align: center">Descripcion</th>
    </tr>
    <?php foreach ($result as $v) : ?>
    <tr ondblclick="nav(<?= $v->id_tarea ?>,'task')" style="cursor:pointer">
            <td style="text-align: center"><?= $v->id_tarea ?></td>
            <td ><?= $v->descripcion_op ?></td>
            <td ><?= $v->descripcion ?></td>
        </tr>
    <?php endforeach ?>
</table>

