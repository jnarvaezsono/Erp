<li class="header" id="notifications-head"><?=$num?> Notificacion(es) sin leer</li>
<?php foreach ($rows as $v):  ?>
<li id="not-<?=$v->id_notificacion?>">
    <ul class="menu">
        <li onclick="DeleteNotification(<?=$v->id_notificacion?>,'<?= base_url()?>','<?=$v->url?>')">
            <a style="cursor: pointer">
                <i class="fa fa-users text-aqua"></i> <?=$v->texto?>
            </a>
        </li>
    </ul>
</li>
<?php endforeach;  ?>