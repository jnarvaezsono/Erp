<?php foreach ($adjuntos as $v) : ?>
    <li style="width:250px" class="adj-<?= $v->id ?>">
        <div class="mailbox-attachment-info" style="min-height: 80px">
            <a href="<?= base_url() ?>Adjuntos/FACTURAS/<?=$factura_id?>/<?= $v->name ?>" class="mailbox-attachment-name" download="<?= $v->name ?>" target="_blank"><i class="fa fa-paperclip"></i> <?= substr($v->name, 0, 20) ?></a>
            <span class="mailbox-attachment-size">
                <?= $v->type ?>
                <?= $v->size2 ?>
                
            </span>
        </div>
        <a href="<?= base_url() ?>Adjuntos/FACTURAS/<?=$factura_id?>/<?= $v->name ?>" download="<?= $v->name ?>" class="btn btn-primary btn-xs pull-right" style="margin-left: 2px"><i class="fa fa-cloud-download"></i></a>
        <a onclick="deleteAdjunto(<?= $v->id ?>,'<?=$factura_id?>/<?= $v->name ?>')" class="btn btn-warning btn-xs pull-right"><i class="fa fa-trash"></i></a>
    </li>
<?php endforeach; ?>