<style>
    .img-header{vertical-align: -webkit-baseline-middle;}
</style>
<ul class="timeline">
    <?php 
    $fecha_old = '';
    foreach ($history as $v) : 
        
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado","Domingo");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
           
        $fecha = $dias[date('N', strtotime($v->fecha))]." ". "".date('d', strtotime($v->fecha))." de ". "".$meses[date('n', strtotime($v->fecha))-1]. " del ". "".date('Y', strtotime($v->fecha)) ;
           
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
    <li class="li-token">
        <i class="fa fa-comments bg-blue"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> <?=$v->fecha?></span>

            <h3 class="timeline-header"><a href="#" class="img-header"><?=$v->name?><img class="img-circle img-sm" src="<?= base_url() ?>/dist/img/<?=$v->avatar?>" alt="User Image"></a></h3>

            <div class="timeline-body">
                <?=$v->texto?>
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