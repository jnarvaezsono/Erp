<div class="content-wrapper">
    <section class="content-header">
        <h1 id="title">
            <i class="fa fa-edit"></i> Factura N&deg;
            <small><?= $id ?> <?= $row->estado ?> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Medios</a></li>
            <li><a href="<?= base_url() ?>Billing">Listar</a></li>
            <li class="active">Editar</li>
        </ol>
    </section>
    <section class="content">
        <ul class="mailbox-attachments clearfix" id="cont-adjuntos">
            <?=$adjuntos?>
        </ul>
    </section>
</div>
