<!DOCTYPE html>
<?php 
$vlrDesc = 0;
$subTotal = 0;
$vlrIva = 0 ;
$vlrMasIva = 0;
$vlrSpa = 0;
$vlrIvaspa = 0;
foreach ($result as $v) : 
    
?>
<div id = 'print'>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Expires" content="0">
        <meta http-equiv="Last-Modified" content="0">
        <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
        <meta http-equiv="Pragma" content="no-cache">
        <title>Imprimir Pre Orden</title>
        <link rel="stylesheet" href="<?= base_url() ?>dist/css/stylePdfs.css" media="all" />
        <script src="<?= base_url() ?>dist/jquery/jquery.js"></script>
        <style>
            @media print
            {    
                .btn{
                    display: none !important;
                }
            }
            .th-cab {
                display: table-cell;
            }
        </style>
    </head>
    <body>
        <header class="clearfix">
            <p style="text-align:right;"><b><?=($v->impresiones >= 0 )?'DUPLICADO':'ORIGINAL'?></b></p>
            <button type="button" class="btn btn-block btn-primary btn-sm" onclick="imprimir()">Imprimir</button>
            <div id="logo">
                <img src="<?=base_url()?>dist/img/header-ordenes-sonovista1.jpg">
            </div>
            <h1><b>PRE ORDEN DE CLASIFICADOS No. <?=$v->id?> </b></h1>
            <table id="head" >
                <tr>
                    <td class="th-cab">CLIENTE</td><td class="td-cab"><?=$v->cliente?></td>
                    <td class="th-cab">NIT </td><td class="td-cab"><?=$v->documento?></td>
                </tr>
                <tr>
                    <td class="th-cab">PROVEEDOR</td><td class="td-cab"><?=$v->proveedor?></td>
                    <td class="th-cab">NIT </td><td class="td-cab"><?=$v->nit_proveedor?></td>
                    <td class="th-cab" style="width:112px">N&deg; ORDEN PROVEEDOR</td><td><?=$v->id?></td>
                </tr>
                <tr><td class="th-cab">CAMPAÑA</td><td class="td-cab"><?=$v->campana?></td><td class="th-cab" style="width:112px">N&deg; ORDEN CLIENTE</td><td><?=$v->orden?></td></tr>
                <tr><td class="th-cab">SERVICIO</td><td><?=strtoupper($v->servicio)?></td><td class="th-cab">COTIZACIÓN</td><td><?=$v->cotizacion?></td></tr>
                <tr><td class="th-cab">PRODUCTO</td><td class="td-cab"><?=$v->producto?></td><td class="th-cab">FECHA</td><td><?=$v->fecha?></td></tr>
                
            </table>
        </header>
        <main>
            <table id="aviso" >
                <tbody>
                    <?php foreach ($detail as $row) : ?>
                        <tr>
                            <td style="text-align:left"><b>Ciudad :</b></td><td style="text-align:left" ><?=$row->drad_ciudad?></td>
                            <td style="text-align:left"><b>CuñaXdia :</b></td><td style="text-align:left" ><?=$row->drad_numcuna?></td>
                            <td style="text-align:left"><b>Prog de Radio :</b></td><td style="text-align:left" ><?=$row->programa?></td>
                        </tr>
                        <tr>
                            <td style="text-align:left"><b>Emisora :</b></td><td style="text-align:left" ><?=$row->emisora?></td>
                            <td style="text-align:left"><b>Segundos :</b></td><td style="text-align:left" ><?=$row->drad_seg?></td>
                            <td style="text-align:left"><b>Dias :</b></td><td style="text-align:left" ><?=$row->drad_dias?></td>
                        </tr>
                        <tr>
                            <td style="text-align:left"><b>Fecha Inicio :</b></td><td style="text-align:left" ><?=$row->drad_fechaini?></td>
                            <td style="text-align:left"><b>Fecha Fin :</b></td><td style="text-align:left" ><?=$row->drad_fechafin?></td>
                            <td style="text-align:left"><b>Total Cuñas :</b></td><td style="text-align:left" ><?=$row->drad_totalcuna?></td>
                        </tr>
                        <tr>
                            <td style="text-align:left"><b>Frecuencia :</b></td><td style="text-align:left" ><?=$row->drad_frecuencia?></td>
                            <td style="text-align:left"><b>Tarifa :</b></td><td style="text-align:left" ><?=number_format($row->drad_tarifa,2,",",".")?></td>
                            <td style="text-align:left"><b>Total :</b></td><td style="text-align:left"><?=number_format($row->drad_total,2,",",".")?></td>
                        </tr>
                        <?php if(!empty($row->drad_detalle)): ?>
                        <tr style="border-bottom: 1px solid #C1CED9;">
                            <td style="text-align:left"><b>DETALLE :</b></td><td style="text-align:left" colspan="5"><?=$row->drad_detalle?></td>
                        </tr>
                        <?php else: ?>
                        <tr style="border-bottom: 1px solid #C1CED9;"><td colspan="6"></td></tr>
                        <?php endif; ?>
                    <?php 
                    $vlrDesc = $v->valor * ($v->descuento / 100 );
                    $subTotal = $v->valor - $vlrDesc;
                    $vlrIva = $subTotal * ($v->iva / 100 );
                    $vlrMasIva = $subTotal + $vlrIva;

                    $vlrSpa = $subTotal * ($v->porcentaje_spa / 100 );
                    $vlrIvaspa = $vlrSpa * ($v->porcentaje_iva_spa / 100 );
                    endforeach; ?>
                </tbody>
            </table>
            <table id="aviso" style="page-break-inside:avoid; " >
                <tbody>
                    <tr>
                        <td colspan="5">Valor</td>
                        <td class="total" style="width: 96px;">$<?=number_format($v->valor,0,"",".")?></td>
                    </tr>
                    <tr>
                        <td colspan="5">Descuento <?=$v->descuento?>%</td>
                        <td class="total">$<?=number_format($vlrDesc,0,"",".")?></td>
                    </tr>
                    <tr>
                        <td colspan="5">Subtotal</td>
                        <td class="total">$<?=number_format($subTotal,0,"",".")?></td>
                    </tr>
                    <tr>
                        <td colspan="5">Iva <?=$v->iva?>%</td>
                        <td class="total">$<?=number_format($vlrIva,0,"",".")?></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="grand total">TOTAL</td>
                        <td class="grand total">$<?=number_format($vlrMasIva,0,"",".")?></td>
                    </tr>
                </tbody>
            </table>
            <div id="notices" style="page-break-inside:avoid; ">
                <div>Observaciones:</div>
                <div class="notice"><?=$v->observacion?>.</div>
            </div>
            <br/>
            <div id="notices" style="page-break-inside:avoid; ">
                <div>NOTA:</div>
                <div class="notice">Su firma en este presupuesto constituye su aprobaci&oacute;n y autorizaci&oacute;n para que por su cuenta ordenemos todo el trabajo y servicio comprendido en el mismo a los precios y condiciones los cuales estan sujetos a la aceptaci&oacute;n de los medios y proveedores.</div>
            </div>
            <table style="width: 100%;font-size: 11px; color:#252424;    margin-top: 40px;" style="page-break-inside:avoid; "> 
                <tr>
                    <td style="width: 33.3%; text-align: center; font-weight: bold; font-style: italic;"></td>
                </tr>
                <tr>
                    <td style="width: 33.3%; text-align: center; font-weight: bold;font-style:italic"><?php echo utf8_decode($v->usuario); ?></td><td style="width: 33.3%; text-align: center"></td><td style="width: 33.3%; text-align: center"></td>
                </tr>
                <tr> 
                    <td style="width: 50%; text-align: center">__________________________ </td> <td style="width: 50%; text-align: center">__________________________</td>
                </tr>
                <tr> 
                    <td style="width: 50%; text-align: center">Dpto de medios </td>  <td style="width: 50%; text-align: center">Recibido Por</td>
                </tr>
                
            </table>
        </main>
</body>
<script>
    $(function(){   
        $.post('<?= base_url() ?>Managerbudget/C_Preorden/UpdatePrint',{tipo:<?=$tipo?>,ppto:<?=$v->id?>,status:5},function(){
        });
    });
    
    function imprimir(){
        window.print();
    }
</script>
</html>
</div>
<?php endforeach; ?>