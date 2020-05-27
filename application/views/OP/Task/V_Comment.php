<?php 
$array = array();
$key = '';
foreach ($comments as $v) : 
    if($v->tipo != "TEXTO" && !empty($v->token)){
        $array[$v->token][] = $v->adjunto;
    }
endforeach;

?>
<style>
    .img-header{vertical-align: -webkit-baseline-middle;}
</style>
<ul class="timeline">
    <?php 
    $fecha_old = '';
    foreach ($comments as $v) : 
        
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado","Domingo");
                    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                

                    $fecha = $dias[date('N', strtotime($v->fecha))]." "
                            . "".date('d', strtotime($v->fecha))." de "
                            . "".$meses[date('n', strtotime($v->fecha))-1]. " del "
                            . "".date('Y', strtotime($v->fecha)) ;
                
                    
    ?>
    
    <?php if($fecha_old != $fecha): ?>
        <li class="time-label">
            <span class="bg-red">
                <?=$fecha;?>
            </span>
        </li>
    <?php endif; ?>
    <!-- /.timeline-label -->
    <!-- timeline item -->
    <li class="li-token" key="<?= $v->token ?>" >
        <?php if ($v->tipo == "TEXTO") : ?>
            <?php if ($v->update == 1) : ?>
                <i class="fa fa-refresh bg-maroon"></i>
            <?php else: ?> 
                <i class="fa fa-comments bg-blue"></i>
            <?php endif; ?>
        <?php else: ?> 
            <i class="fa fa-paperclip bg-yellow"></i>
        <?php endif; ?>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> <?=$v->fecha?></span>

            <h3 class="timeline-header"><a href="#" class="img-header"><?= $v->name ?>...<img class="img-circle img-sm" src="<?= base_url() ?>/dist/img/<?= $v->avatar ?>" alt="User Image"></a></h3>

            <div class="timeline-body">
                <?php if ($v->tipo == "TEXTO") : ?>
                    <?=$v->texto;?> 
                <?php else: ?> 
                    <?php if(!empty($v->token)): 
                        if(array_key_exists($v->token, $array)){
                        ?>
                        <table class="">
                            <tr>
                            <?php $cont = 1; foreach ($array[$v->token] as $value) :
                                if($cont > 3){
                                    echo "</tr><tr>";
                                    $cont = 1;
                                }
                                ?>
                                <td>
                                    <?php if (strpos($value, '.pdf') === false) : ?>
                                        <?php if (strpos($value, '.xls') === false && strpos($value, '.xls') === false) : ?>
                                            <?php if (strpos($value, '.pptx') === false) : ?>
                                                <?php if (strpos($value, '.doc') === false && strpos($value, '.docx') === false) : ?>
                                                    <img src="<?= base_url() ?>Adjuntos/COMMENT/<?= $v->id_tarea ?>/<?= $value ?>" alt="..." class="margin" style="max-width:200px"><br />
                                                <?php else: ?> 
                                                    <img src="<?= base_url() ?>dist/img/word.png" alt="..." class="margin" style="max-width:100px"><br />
                                                <?php endif; ?>
                                            <?php else: ?> 
                                                <img src="<?= base_url() ?>dist/img/pptx.png" alt="..." class="margin" style="max-width:100px"><br />
                                            <?php endif; ?>
                                        <?php else: ?> 
                                            <img src="<?= base_url() ?>dist/img/excel.png" alt="..." class="margin" style="max-width:100px"><br />
                                        <?php endif; ?>
                                    <?php else: ?> 
                                        <img src="<?= base_url() ?>dist/img/pdf.png" alt="..." class="margin" style="max-width:100px"><br />
                                    <?php endif; ?>
                                        <a download="<?= $value ?>" href="<?= base_url() ?>Adjuntos/COMMENT/<?= $v->id_tarea ?>/<?= $value ?>" target="_blank"><i class="fa fa-paperclip"></i> <?= $value ?></a>
                                </td>
                            <?php $cont++; endforeach; unset($array[$v->token]) ?>
                            </tr>
                        </table>
                        <?php } ?>
                        <?php else: ?>
                        <?php if (strpos($v->adjunto, '.pdf') === false) : ?>
                            <?php if (strpos($v->adjunto, '.xls') === false && strpos($v->adjunto, '.xls') === false) : ?>
                                <?php if (strpos($value, '.pptx') === false) : ?>
                                    <?php if (strpos($value, '.doc') === false && strpos($value, '.docx') === false) : ?>
                                        <img src="<?= base_url() ?>Adjuntos/COMMENT/<?= $v->id_tarea ?>/<?= $value ?>" alt="..." class="margin" style="max-width:200px"><br />
                                    <?php else: ?> 
                                        <img src="<?= base_url() ?>dist/img/word.png" alt="..." class="margin" style="max-width:100px"><br />
                                    <?php endif; ?>
                                <?php else: ?> 
                                    <img src="<?= base_url() ?>dist/img/pptx.png" alt="..." class="margin" style="max-width:100px"><br />
                                <?php endif; ?>
                            <?php else: ?> 
                                <img src="<?= base_url() ?>dist/img/excel.png" alt="..." class="margin" style="max-width:100px"><br />
                            <?php endif; ?>
                        <?php else: ?> 
                            <img src="<?= base_url() ?>dist/img/pdf.png" alt="..." class="margin" style="max-width:100px"><br />
                        <?php endif; ?>

                        <a download="<?= $v->adjunto ?>" href="<?= base_url() ?>Adjuntos/COMMENT/<?= $v->id_tarea ?>/<?= $v->adjunto ?>" target="_blank"><i class="fa fa-paperclip"></i> <?= $v->adjunto ?></a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </li>
    <?php
    $fecha_old = $fecha;
    endforeach; ?>
    
    <li>
        <i class="fa fa-clock-o bg-gray"></i>
    </li>
</ul>