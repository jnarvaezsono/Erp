<?php 
foreach ($result as $v) : 
     
?>
<page backtop="23%" backbottom="3%" backleft="5%" backright="5%" footer="page">
    <page_header>
         <?php
        if ($v->impresiones >= 0){ 
           echo '<p style="text-align:right;"><b>DUPLICADO</b></p>';
       } else{
           echo '<p style="text-align:right;"><b>ORIGINAL</b></p>';
       }
       ?>   
           <table border="0" cellpadding="0" cellspacing="0" style="width:100%; margin-left: 30px;">
                <tbody>
                    <tr> 
                        <td style="box-sizing: border-box;"><img alt="" src="<?=base_url()?>dist/img/header-ordenes-sonovista1.jpg" style="box-sizing: border-box; border: 0px; vertical-align: middle;"/></td>

                    </tr>
                </tbody>
            </table>
          <h3 style="text-align:center; font-size: 13px;color:#252424;">ORDEN DE COSTOS DE <?=$v->tipo?> No. <?=$v->id; ?></h3> 
        <table style="margin-left: 30px;  width: 100%; color:#252424;">
            <tr  style="font-size: 11px;">
                <td><b>CLIENTE : </b></td>
                <td style="width: 20%;"><?=$v->cliente; ?></td>
                <td>&nbsp; &nbsp; &nbsp; </td>
                <td><b>PROVEEDOR : </b></td>
                <td style="width: 20%;"><?=$v->proveedor; ?></td>
            </tr>

            <tr style="font-size: 11px;">
                <td><b>NIT :</b></td>
                <td><?php echo $v->documento; ?></td>
                <td>&nbsp; &nbsp; &nbsp; &nbsp;  </td>
                <td><b>FECHA : </b></td>
                <td><?php echo $v->fecha; ?></td>
            </tr>
            <tr style="font-size: 11px;">
                 <td><b>PRODUCTO :</b></td>
                <td style="width: 20%;"><?=$v->producto; ?></td>
                <td>&nbsp; &nbsp; &nbsp; &nbsp;  </td>
                <td><b>CAMPAÑA : </b></td>
                <td style="width: 20%;"><?=$v->campana; ?></td>
            </tr>
            <tr style="font-size: 11px;">
                 <td><b>TIPO DE SERVICIO :</b></td>
                <td><?=$v->servicio; ?></td>
                <td>&nbsp; &nbsp; &nbsp; &nbsp;  </td>
                <?php /*if($v->ordcos_noorden != ""){*/ ?>
                <td><b>No PRESUPUESTO :</b></td>
                <td style="width: 20%;"><?=$v->ordcos_noorden .' '. $v->no_presup  ?></td>
                <?php /*}*/ ?>
            </tr>
        </table> 

    </page_header>
    <page_footer> 
    </page_footer> 
    <br/>
    <hr style="color:#252424;">
    <br/>

    <table style="width: 104%; color:#252424;" cellspacing="0" cellpadding="0" > 
        <tr > 
            <td  style="border-bottom: 2px solid #252424; font-size: 11px; text-align: center;"><b>DETALLES DEL SERVICIO</b> </td>
            <td style="border-bottom: 2px solid #252424; font-size: 11px;"></td>
            <td  style="border-bottom: 2px solid #252424; font-size: 11px; text-align: center;"><b>CANTIDAD</b> </td>
            <td style="border-bottom: 2px solid #252424; font-size: 11px;"></td>
            <td style="border-bottom: 2px solid #252424; font-size: 11px;width: 10%;"><b>VALOR UNITARIO</b> </td>
            <td style="border-bottom: 2px solid #252424; font-size: 11px;"></td>
            <td style="border-bottom: 2px solid #252424; font-size: 11px;"><b>TOTAL</b> </td>
        </tr>
        <?php foreach ($detail as $d) : ?>  
            <tr>
                <td style="padding-top: 5px; text-align: justify; width: 55%; border-bottom: 1px dotted #252424; font-size: 11px;"> <?=$d->detalle?> </td>
                <td style="padding-top: 5px; width: 5%; border-bottom: 1px dotted #252424; font-size: 11px;"></td>
                <td style="padding-top: 5px; text-align: justify; width: 10%; border-bottom: 1px dotted #252424; font-size: 11px;text-align: center;"><?=$d->cantidad?> </td>
                <td style="padding-top: 5px; width: 5%; border-bottom: 1px dotted #252424; font-size: 11px;"></td>
                <td style="padding-top: 5px; text-align: right; border-bottom: 1px dotted #252424; font-size: 11px;"> $<?=number_format($d->valor,0,"",".")?> </td>
                <td style="padding-top: 5px; width: 5%; border-bottom: 1px dotted #252424; font-size: 11px;"></td>
                <td style="padding-top: 5px; text-align: center; border-bottom: 1px dotted #252424; font-size: 11px;"> $<?=number_format($d->total,0,"",".")?> </td>
            </tr>
        <?php 
            $vlrDesc = $v->valor * ($v->descuento / 100 );
            $subTotal = $v->valor - $vlrDesc;
            $vlrIva = $subTotal * ($v->iva / 100 );
            endforeach; ?>

    </table>
    <br/>
    <hr style="color:#252424;">
    <br/>
    <nobreak>
    <table style="width: 50%;color:#252424; font-size: 11px;" align="right"> 
        <tr> 
            <td style="width: 50%;border-bottom: 1px dashed #000;"><b>Valor :</b> </td> <td style="text-align: right;">$<?=number_format($v->valor,0,"",".")?> </td>
        </tr>
        <tr> 
            <td style="width: 50%;border-bottom: 1px dashed #000;"><b>Descuento <?=$v->descuento?>% :</b> </td> <td style="text-align: right;"> $<?=number_format($vlrDesc,0,"",".")?></td>
        </tr>
        <tr>
            <td style="width: 50%;border-bottom: 1px dashed #000;"><b>Subtotal :</b> </td> <td style="text-align: right;"> $<?=number_format($subTotal,0,"",".")?> </td>
        </tr>
        <tr>
            <td style="width: 50%;border-bottom: 1px dashed #000;"><b>Iva <?=$v->iva?>%:</b></td><td style="text-align: right;"> $<?=number_format($vlrIva,0,"",".")?></td>
        </tr>
        <tr>
            <td style="width: 50%;border-bottom: 1px dashed #000;"><b>Total Orden:</b> </td> <td style="text-align: right;">$<?=number_format($v->total,0,"",".")?></td>
        </tr>
    </table>
    <br/><br/>

    <br/><br/>
    <br/><br/>
    <p style="font-size: 11px;"><b>OBSERVACI&Oacute;N:</b> <?=$v->observacion?></p>
     <br/>       <br/>       <br/>
    <p style="font-size: 11px;color:#252424;"><b>NOTA:</b></p>
    <p style="color:#252424; font-size: 11px;">Favor elaborar la factura correspondiente a nombre de SONOVISTA PUBLICIDAD S.A, y enviarla a la dirección Calle 70 No 53 – 74 piso 5, Barranquilla Colombia.</p>
    <br/><br/><br/>

    <table style="width: 100%;color:#252424; font-size: 11px;"> 
        <tr>
            <td style="width: 50%; text-align: center; font-weight: bold; font-style: italic;"><?=$v->usuario ?></td><td style="width: 50%; text-align: center"></td>
        </tr>
        <tr> 
            <td style="width: 50%; text-align: center">__________________________ </td> <td style="width: 50%; text-align: center">__________________________</td>
        </tr>
        <tr> 
            <td style="width: 50%; text-align: center">Dpto de medios </td> <td style="width: 50%; text-align: center">Recibido Por</td> 
        </tr>
    </table>
    </nobreak>
</page>
<?php endforeach; ?>