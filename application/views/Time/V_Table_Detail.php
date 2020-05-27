<style>
    .td-detail{
        vertical-align: middle !important;
    }
</style>
<table class="table table-condensed">
    <thead>
        <tr>
            <th style="text-align:center;width: 10px">Sel</th>
            <th style="min-width: 130px;">Acción</th>
            <th >Ocupación</th>
            <th style="min-width: 100px;text-align:center">Tiempo <i class="fa fa-clock-o"></i></th>
        </tr>
    </thead>
    <tbody>
        <?php
        setlocale(LC_TIME, LOCALE);
        $times = array();
        foreach ($detail as $v) :
            $times[] = $v->time ;
            ?>
            <tr st>
                <td class="td-detail" style="text-align:center"><input type="radio" name="select" class="minimal" value="<?=$v->id_time_detail?>"></td>
                <td class="td-detail"><?= $v->type ?></td>
                <td class="td-detail" ><?= (!empty($v->actividad)?'('.$v->actividad.')':'').' '.$v->text ?></td>
                <!--<td class="td-detail"><?= utf8_encode(strftime("%A, %d de %B", strtotime($this->input->post('fecha')))) ?></td>-->
                <td class="td-detail" style="text-align:center; "><?= $v->time ?></td>
            </tr>
        <?php endforeach; ?>
            <tr>
                <th colspan="3" style="text-align: right">Total</th>
                <th style="text-align: center"><?=sumTime($times)?></th>
            </tr>
    </tbody>
</table>
