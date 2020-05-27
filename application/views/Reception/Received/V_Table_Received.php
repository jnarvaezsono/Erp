<table id="tabla" class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th>#</th>
            <th>Detalle</th>
            <th ></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list as $v) : ?>
        <tr id="id<?=$v->id?>" desc="<?=$v->description_register?>" copy="<?=$v->copy?>" obs="<?=$v->observation?>">
            <td style="text-align: center;width: 15px;" id="consecutive<?=$v->id_users ?>"><?=$v->consecutive?></td>
            <td  style="text-align: left;">
                <table style="width:100%" >
                    <tr><td><b>Creador:</b> <?=$v->name?></td><td><b>Recibido:</b> <div style="display: inline-block;" id="date_received<?=$v->id?>"><?=$v->date_received?></div></td><td><b>Formato:</b> <?=($v->copy == 0)?'ORIGINAL':'COPIA' ?></td></tr>
                    <tr><td><b>Remitente:</b> <div style="display: inline-block;" id="sender<?=$v->id?>"><?=$v->sender?></div></td><td><b>Empresa:</b> <div style="display: inline-block;" id="company<?=$v->id?>"><?=$v->company?></div></td><td><b>Registro:</b> <?=substr($v->date_register,0,10)?></td></tr>
                    <tr><td><b>Destino:</b> <div style="display: inline-block;" id="addressee<?=$v->id?>" num="<?=$v->addressee?>"><?=$v->destino?></div></td><td><b>Tipo:</b> <div style="display: inline-block;" id="type<?=$v->id?>"><?=$v->type?></div></td></tr>
                    <tr>
                        <?php if($v->resend == 0):  ?>
                        <td colspan="3" id="status<?=$v->id?>" status="<?=$v->id_status?>" style="width:140px; max-width:140px;"><span style="width:100%" class="label label-<?= $v->id ?> label-<?= $v->color ?>"><?=$v->description?></span></td>           
                        <?php else:  ?>
                        <td colspan="3" id="status<?=$v->id?>" status="<?=$v->id_status?>" style="width:140px; max-width:140px;"><span style="width:100%" class="label label-<?= $v->id ?> label-primary"><?=$v->description?> REENVIADO A <?=$v->resend_name?></span></td>
                        <?php endif;  ?>
                    </tr>
                </table>
                
            </td>        
            <td style="width: 76px;text-align: center;" id="btns<?=$v->id?>">
                <button type="button"  class="btn btn-info btn-xs btn-tabla" title="Editar" onclick="Update(<?=$v->id?>,<?=$v->id_status?>)"><i class="fa fa-search"></i></button>
                
                <?php if($inbox):  ?>
                    <?php if($v->resend == 0 || $v->resend_format == 'COPIA'):  ?>
                        <?php if($v->id_status == 23):  ?>
                        <button type="button"  class="btn btn-info btn-xs btn-tabla" id="btn-resend-<?=$v->id?>" title="Reenviar" onclick="Resend(<?=$v->id?>,'<?=($v->resend_format == 'COPIA' && $v->copy == 1)?1:($v->copy == 1)?1:0?>')"><i class="fa fa-send"></i></button>
                        <?php elseif($v->id_status == 6):  ?>
                            <button type="button"  class="btn btn-success btn-xs btn-tabla" title="Aceptar" onclick="Accept(<?=$v->id?>,23,<?=empty($v->resend_of)?0:$v->resend_of?>)"><i class="fa fa-check"></i></button>
                            <button type="button"  class="btn btn-danger btn-xs btn-tabla" title="Rechazar" onclick="Accept(<?=$v->id?>,24,<?=empty($v->resend_of)?0:$v->resend_of?>)"><i class="fa fa-close"></i></button>
                        <?php endif;  ?>
                    <?php endif;  ?>
                <?php else:  ?>
                        <button type="button"  class="btn btn-default btn-xs btn-tabla" title="Imprimir" onclick="printTicket(<?=$v->id?>,<?=$v->consecutive?>,'<?=$v->date_received?>')"><i class="fa fa-print"></i></button>

                        <?php if(in_array($v->id_status, array('24','6'))):  ?>
                            <button type="button"  class="btn btn-danger btn-xs btn-tabla" title="Anular" onclick="Anule(<?=$v->id?>)"><i class="fa fa-trash"></i></button>
                        <?php endif;  ?>
                <?php endif;  ?>
               
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
