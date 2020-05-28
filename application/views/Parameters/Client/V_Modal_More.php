<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title"><?= $this->input->post('title') ?></h4>
</div>
<div class="modal-body">
    <table class="table table-condensed">
        <tbody>
            <tr>
                <th>Nombre</th>
                <th></th>
            </tr>
        
    <?php if ($this->input->post('title') == 'Producto'): ?>
        <?php foreach ($result as $v):  ?>
            <tr>
                <td><?= $v->pdcl_nombre ?></td>
                <td></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <?php foreach ($result as $v):  ?>
            <tr>
                <td><?= $v->camp_nombre ?></td>
                <td></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
        </tbody>
    </table>
</div>
