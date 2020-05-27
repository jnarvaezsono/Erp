<table id="table<?=$table?>" class="table table-bordered table-striped table-condensed display">
    <thead>
        <tr>
            <th style="text-align:center">ORDEN</th>
            <th style="text-align:center">FECHA</th>
            <th style="text-align:center">ESTADO</th>
            <th style="text-align:center">CLIENTE</th>
            <th>TOTAL ORDEN</th>
            <th>TOTAL PPTO</th>
            <th>DIFERENCIA</th>
            <th>% <?=($table == 1)?'GANACIA':'PERDIDA';?></th>
            <th>USUARIO</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result as $value) : 
//          $pc = ($value["total_ppto"] > 0)?($value["total_orden"] / $value["total_ppto"]):1;     
            $pc = ($value["total_ppto"] > 0)?($value["diferencia"] / $value["total_ppto"]):-1;
            ?>
            <tr>
            <td><?=$value["orden"]?></td>
            <td><?=$value["fecha"]?></td>
            <td ><?=$value["estado"]?></td>
            <td ><?=$value["cliente"]?></td>
            <td>$ <?=number_format($value["total_orden"],"2",",",".")?></td>
            <td>$ <?=number_format($value["total_ppto"],"2",",",".")?></td>
            <td style='<?=$value["style"]?>'>$ <?=number_format($value["diferencia"],"2",",",".")?></td>
            <td>
                <?=round($pc * 100,2)?> %
            </td>
            <td><?=$value["usuario"]?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
