
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"> <i class="fa fa-fw fa-tasks"></i> Lista De Tareas</h3>

        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover" id="table-task">
                <thead>
                    <tr>
                        <th style="width: 110px;">Fecha Entrega</th>
                        <th>Responsable</th>
                        <th>Area</th>
                        <th>Descripción</th>
                        <th style="width: 50px;"></th>
                        <th style="width: 50px;">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $v) : 
                        $icon = '<img style="width:25px;margin-left:5px"  title="Tarea cerrada" src="'. base_url().'dist/img/icon-image/invalid.png" />';
                        if(isOpen($v->id_estado)){
                            if($v->dias <= 0){
                                $icon = '<img style="width:30px;margin-left:5px"  title="Tarea vencida" src="'. base_url().'dist/img/icon-image/rojo.png" />';
                            }elseif($v->dias <= 1){
                                $icon = '<img style="width:30px;margin-left:5px"  title="Restan 1 día para su vencimiento" src="'. base_url().'dist/img/icon-image/naranja.png" />';
                            }elseif($v->dias <= 2){
                                $icon = '<img style="width:30px;margin-left:5px"  title="Restan 2 días para su vencimiento" src="'. base_url().'dist/img/icon-image/amarillo.png" />';
                            }elseif($v->dias <= 3){
                                $icon = '<img style="width:30px;margin-left:5px"  title="Restan 3 días para su vencimiento" src="'. base_url().'dist/img/icon-image/lima.png" />';
                            }else{
                                $icon = '<img style="width:30px;margin-left:5px"  title="Restan mas de 3 día para su vencimiento" src="'. base_url().'dist/img/icon-image/verde.png" />';
                            }
                        }else if($v->id_estado == 13){
                            $icon = '<img style="width:25px;margin-left:5px"  title="Tarea cerrada" src="'. base_url().'dist/img/icon-image/valid.png" />';
                        }
                        
                    ?>
                        <tr class="trTask" id="<?= $v->id_tarea ?>">
                            <td><?= $v->fecha_entrega ?></td>
                            <td><?= (empty($v->name)?'<b>SIN ASIGNAR</b>':$v->name) ?></td>
                            <td><?= $v->area ?></td>
                            <td style="text-align:left"><?= strip_tags(mb_substr($v->descripcion,0,70), '</p>')  ?></td>
                            <td style="padding: 0px;vertical-align: middle;"><?=$icon?></td>
                            <td style="padding: 0px;vertical-align: middle;"><span style="width:100%" class="label label-<?= $v->id_tarea ?> label-<?= $v->color ?>"><?= $v->estado ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>