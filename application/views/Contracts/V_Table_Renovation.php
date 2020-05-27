<table class="table table-hover">
    <tbody>
        <tr>
            <th>Fecha</th>
            <th>Usuario</th>
            <th>Fec. Inicio</th>
            <th>Fec. Vnecimiento</th>
            <th>Valor</th>
        </tr>
        <?php foreach ($renov as $v) : ?>
            <tr>
                <td><?= $v->fecha ?></td>
                <td><?= $v->name ?></td>
                <td><?= $v->fecha_inicio ?></td>
                <td><?= $v->fecha_vencimiento ?></td>
                <td>$ <?= $v->valor ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>