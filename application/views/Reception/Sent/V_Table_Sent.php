<table id="tabla" class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th >#</th>
            <th>Detalle</th>
            <th style="width: 76px;"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list as $v) : ?>
        <tr style="text-align: center;width: 15px;" id="id<?=$v->consecutive?>" desc="<?=$v->description_register?>" hour="<?=$v->hour?>" response="<?=$v->response?>">
            <td style="text-align: center;" id="consecutive<?=$v->id_users ?>"><?=$v->consecutive?></td>
            <td style="text-align: left;">
                <table style="width:100%" >
                    <tr>
                        <td><b>Destinatario:</b> <div style="display: inline-block;" id="addressee<?=$v->consecutive?>"><?=$v->addressee?></div></td>
                        <td><b>Empresa:</b> <div style="display: inline-block;" id="company<?=$v->consecutive?>"><?=$v->company?></div></td>
                    </tr>
                    <tr>
                        <td><b>Fecha Envio:</b> <div style="display: inline-block;" id="date_sent<?=$v->consecutive?>"><?=$v->date_sent?></div></td>
                        <td><b>Tipo:</b> <div style="display: inline-block;" id="type<?=$v->consecutive?>"><?=$v->type?></div></td>
                    </tr>
                    <tr>
                        <td><b>Medio Envio:</b> <div style="display: inline-block;" id="shipping_by<?=$v->consecutive?>"><?=$v->shipping_by?></div></td>
                        <td><b>Fecha Registro:</b> <?=$v->date_register?></td>
                    </tr>
                    <tr>
                        <td><b>Usuario:</b> <?=$v->name?></td>
                        <td  id="status<?=$v->consecutive?>" status="<?=$v->id_status?>" ><span style="width:100%" class="label label-<?= $v->consecutive ?> label-<?= $v->color ?>"><?=$v->description?></span></td>
                    </tr>
                </table>
            </td>
            <td style="width: 76px;text-align: center;">
                <button type="button"  class="btn btn-default btn-xs btn-tabla" onclick="printTicket(<?=$v->consecutive?>,'<?=$v->date_sent?>')"><i class="fa fa-print"></i></button>
                <button type="button"  class="btn btn-info btn-xs btn-tabla" onclick="Update(<?=$v->consecutive?>)"><i class="fa fa-search"></i></button>
                <button type="button"  class="btn btn-danger btn-xs btn-tabla" onclick="Anule(<?=$v->consecutive?>)"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
