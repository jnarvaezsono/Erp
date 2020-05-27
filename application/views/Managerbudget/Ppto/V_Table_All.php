<table id="table_ppto" class="table table-bordered table-striped table-condensed display">
    <thead>
        <tr>
            <th style="text-align:center">Ppto</th>
            <th style="text-align:center">Fecha</th>
            <th style="text-align:center">Cliente</th>
            <th style="text-align:center">Proveedor</th>
            <th style="text-align:center">Campaña</th>
            <th style="text-align:center">Usuario</th>
            <th style="text-align:center;">Estado</th>
            <th style="text-align:center">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result as $v) :  ?>
        <tr>
            <td><?=$v->id?></td>
            <td><?=$v->fecha?></td>
            <td><?=$v->cliente?></td>
            <td><?=$v->proveedor?></td>
            <td><?=$v->campana?></td>
            <td><?=explode(' ', $v->usuario)[0]?></td>
            <?php 
                $btn = '<div class="btn-group btnI'.$v->id.'" order="'.$v->orden.'" >
                            <button  type="button" class="btn1-'.$v->id.' btn btn-'.$v->est_color.' btn-xs btn-left">'.$v->estado.'</button>
                                <button type="button" class="btn2-'.$v->id.' btn btn-'.$v->est_color.' btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>';

                $btn    .= '<ul class="dropdown-menu u-'.$v->id.'" role="menu">';
                $btn    .= '<li onclick="printPdf('.$v->id.',0)"><a href="#"><i class="fa fa-fw fa-print" ></i> Imprimir</a></li>';
                if($tipo != '7'){
                    $btn    .= '<li onclick="printPdf('.$v->id.',1)"><a href="#"><i class="fa fa-fw fa-print" ></i> Imprimir Orden</a></li>';
                }
                $btn    .= (isset($BtnEditPpto) && ($v->id_estado == 1 && $v->impresiones == -1))? '<li onclick="EditPpto('.$v->id.','.$tipo.')"><a href="#"><i class="fa fa-fw fa-edit"></i> Editar</a></li>':'';
                $btn    .= (isset($BtnDupliPpto))? '<li onclick="copy('.$v->id.')"><a href="#"><i class="fa fa-fw fa-copy"></i> Duplicar</a></li>':'';
                $btn    .= (isset($BtnAddOrderPpto) && ($v->id_estado == 5 || $v->id_estado == 1 ) )? '<li onclick="addOrder('.$v->id.')" ><a href="#"><i class="fa fa-fw fa-plus"></i> Add Orden</a></li>':'';
                $btn    .= (isset($BtnAnulePpto) && (($v->id_estado == 1 && $v->impresiones == -1) || ($v->id_estado == 5)))? '<li onclick="Anule('.$v->id.')"><a style="color: red;" href="#"><i class="fa fa-fw fa-trash-o"></i> Anular</a></li>':'';
                $btn    .= '</ul></div>';

            ?>
            <td></td>
            <td><?=number_format($v->total,0,',','.')?></td>
        </tr>
        <?php  endforeach; ?>
    </tbody>
</table>