<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-dashboard"></i> Panel de control</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <?php if(in_array($this->session->IdRol, array(2,7,1))): ?>
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Mis OP Abiertas</h3>
                                </div>
                                <div class="box-body no-padding">
                                    <div class="table-responsive mailbox-messages" style="height: 200px;">
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>N&deg; OP</th>
                                                    <th>Descripción</th>
                                                    <th>Fec.creación</th>
                                                    <th>Cliente</th>
                                                    <th>Campaña</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($ops as $v) : ?>
                                                    <tr>
                                                        <td style="width: 75px" class="mailbox-name"><i class="fa fa-star text-yellow"></i> <a href="<?=base_url()?>OP/C_OP/Info/<?=$v->id_op?>"><?=$v->id_op?></a></td>
                                                        <td class=""><?=(empty($v->descripcion_op))?'Sin Descripción':$v->descripcion_op?></td>
                                                        <td class="mailbox-date" style=""><?=$v->fecha_creacion?></td>
                                                        <td class="mailbox-date" style=""><?=$v->pvcl_nombre?></td>
                                                        <td class="mailbox-date" style=""><?=$v->camp_nombre?></td>
                                                    </tr>
                                                <?php endforeach ; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if(!in_array($this->session->IdRol, array(2,7))): ?>
                    <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Tareas</h3>
                            </div>
                            <div class="box-body no-padding">
                                <div class="table-responsive mailbox-messages" style="height: 200px;">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tarea</th>
                                                <th>Descripción</th>
                                                <th>Fec.entrega</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($tareas as $v) : ?>
                                                <tr>
                                                    <td style="width: 75px" class="mailbox-name"><i class="fa fa-star text-yellow"></i> <a href="<?=base_url()?>OP/C_OP/Task/<?=$v->id_tarea?>"><?=$v->id_tarea?></a></td>
                                                    <td class="mailbox-subject"><b><?=$v->name?></b> - <?=$v->descripcion?></td>
                                                    <td class="mailbox-date" style="width: 81px;"><?=$v->fecha_entrega?></td>
                                                </tr>
                                            <?php endforeach ; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="col-md-<?=(!in_array($this->session->IdRol, array(2,7)))?'6':'12'?>">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Mis Tareas Notificadas</h3>
                            </div>
                            <div class="box-body no-padding">
                                <div class="table-responsive mailbox-messages" style="height: 200px;">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tarea</th>
                                                <th>Descripción</th>
                                                <th>Fec.entrega</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($notificaciones as $v) : ?>
                                                <tr>
                                                    <td style="width: 75px" class="mailbox-name"><i class="fa fa-star text-yellow"></i> <a href="<?=base_url()?>OP/C_OP/Task/<?=$v->id_tarea?>"><?=$v->id_tarea?></a></td>
                                                    <td class="mailbox-subject"><b><?=$v->name?></b> - <?=$v->descripcion?></td>
                                                    <td class="mailbox-date" style="width: 81px;"><?=$v->fecha_entrega?></td>
                                                </tr>
                                            <?php endforeach ; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Notificaciones</h3>
                            </div>
                            <div class="box-body no-padding">
                                <div class="table-responsive mailbox-messages" style="height: 200px;">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tarea</th>
                                                <th>Descripción</th>
                                                <th>Tipo</th>
                                                <th>Comentario</th>
                                                <th>Realizado Por</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($comentarios as $v) : ?>
                                                <tr>
                                                    <td style="width: 75px;"><i class="fa fa-star text-yellow"></i> <a href="<?=base_url()?>OP/C_OP/Task/<?=$v->id_tarea?>"></a></td>
                                                    <td ><b><?=$v->name?></b> - <?=$v->descripcion?></td>
                                                    <td ><?=$v->tipo?></td>
                                                    <td ><?=($v->tipo == 'TEXTO')?$v->texto: "<a download='".$v->adjunto."' target='_blank' href='".base_url()."Adjuntos/COMMENT/".$v->id_tarea."/".$v->adjunto." ><i class='fa fa-paperclip'>".$v->adjunto."</a>"?></td>
                                                    <td ><?=$v->comentarista?></td>
                                                </tr>
                                            <?php endforeach ; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>