<!DOCTYPE html>
<?php 
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); 
foreach ($result as $v) : 
     switch ($tipo) {
         case 7:
             $tittle = 'PRODUCCIÓN INTERNA';
             break;

         default:
             break;
     }
?>
<div id = 'print'>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Expires" content="0">
        <meta http-equiv="Last-Modified" content="0">
        <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
        <meta http-equiv="Pragma" content="no-cache">
        <title>Imprimir Presupesto</title>
        <link rel="stylesheet" href="<?= base_url() ?>dist/css/stylePdfs.css" media="all" />
        <script src="<?= base_url() ?>dist/jquery/jquery.js"></script>
    </head>
    <body>
        
            <header class="clearfix">
                <p style="text-align:right;"><b><?=($v->impresiones >= 0 )?'DUPLICADO':'ORIGINAL'?></b></p>
                <?php if($print != 0): ?>
                <button type="button" class="btn btn-block btn-primary btn-sm" onclick="imprimir()">Imprimir</button>
                <?php endif; ?>
                <div id="logo">
                    <img src="<?=base_url()?>dist/img/header-ordenes-sonovista1.jpg">
                </div>
                <h1>PRESUPUESTO DE <?=$tittle?> No. <?=$v->id?> <?=(count($bill)>0)?' FACTURA '.$bill->factura_id:''?></h1>
                <table id="head">
                    <tr><td class="th-cab">CLIENTE</td><td class="td-cab"><?=$v->cliente?></td><td class="th-cab">N&deg; ORDEN</td><td><?=$v->orden?></td></tr>
                    <tr><td class="th-cab">NIT</td><td class="td-cab"><?=$v->documento?></td><td class="th-cab">SERVICIO</td><td><?=strtoupper($v->servicio)?></td></tr>
                    <tr><td class="th-cab">PRODUCTO</td><td class="td-cab"><?=$v->producto?></td><td class="th-cab">FECHA</td><td><?=$v->fecha?></td></tr>
                    <tr><td class="th-cab">CAMPAÑA</td><td class="td-cab"><?=$v->campana?></td><td class="th-cab">COTIZACIÓN</td><td><?=$v->cotizacion?></td></tr>
                </table>
            </header>
            <main>
                <table id="detail">
                    <thead>
                        <tr>
                            <th class="desc">DETALLES DEL SERVICIO</th>
                            <th>CANTIDAD</th>
                            <th>VALOR</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($detail as $d) : ?>
                            <tr>
                                <td class="desc"><?=$d->detalle?></td>
                                <td class="qty"><?=$d->cantidad?></td>
                                <td class="unit">$<?=number_format($d->valor/$d->cantidad,0,"",".")?></td>
                                <td class="total">$<?=number_format($d->valor,0,"",".")?></td>
                            </tr>
                        <?php 
                        $vlrDesc = $v->valor * ($v->descuento / 100 );
                        $subTotal = $v->valor - $vlrDesc;
                        $vlrIva = $subTotal * ($v->iva / 100 );
                        endforeach; ?>

                        <tr style="border-top: 1px solid #C1CED9;">
                            <td colspan="3">Valor</td>
                            <td class="total">$<?=number_format($v->valor,0,"",".")?></td>
                        </tr>
                        <tr>
                            <td colspan="3">Descuento <?=$v->descuento?>%</td>
                            <td class="total">$<?=number_format($vlrDesc,0,"",".")?></td>
                        </tr>
                        <tr>
                            <td colspan="3">Subtotal</td>
                            <td class="total">$<?=number_format($subTotal,0,"",".")?></td>
                        </tr>
                        <tr>
                            <td colspan="3">Iva <?=$v->iva?>%</td>
                            <td class="total">$<?=number_format($vlrIva,0,"",".")?></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="grand total">TOTAL</td>
                            <td class="grand total">$<?=number_format($v->total,0,"",".")?></td>
                        </tr>
                    </tbody>
                </table>
                <div id="notices">
                    <div>Observaciones:</div>
                    <div class="notice"><?=$v->observacion?>.</div>
                </div>
                <br/>
                <div id="notices">
                    <div>NOTA:</div>
                    <div class="notice">Su firma en este presupuesto constituye su aprobaci&oacute;n y autorizaci&oacute;n para que por su cuenta ordenemos todo el trabajo y servicio comprendido en el mismo a los precios y condiciones los cuales estan sujetos a la aceptaci&oacute;n de los medios y proveedores.</div>
                </div>

                <table style="width: 100%;font-size: 11px; color:#252424;    margin-top: 40px;"> 
                    <tr>
                        <td style="width: 33.3%; text-align: center; font-weight: bold;font-style:italic"><?php echo utf8_decode($v->usuario); ?></td><td style="width: 33.3%; text-align: center"></td><td style="width: 33.3%; text-align: center"></td>
                    </tr>
                    <tr>
                        <td style="width: 33.3%; text-align: center; font-weight: bold; font-style: italic;"></td>
                    </tr>
                    <tr> 
                        <td style="width: 33.3%; text-align: center">__________________________ </td> <td style="width: 33.3%; text-align: center">__________________________</td><td style="width: 33.3%;text-align: center">__________________________</td>
                    </tr>
                    <tr> 
                        <td style="width: 33.3%; text-align: center">Dpto de medios </td> <td style="width: 33.3%; text-align: center">Ejecutivo de cuentas</td> <td style="width: 33.3%; text-align: center">Cliente aprobaci&oacute;n</td>
                    </tr>
                </table>
            </nobreak>
        </main>
</body>
<script>
    $(function(){   
        $(document).keydown(function(e) {    
          if ((e.ctrlKey || e.metaKey) && e.keyCode == 80) {
            e.preventDefault();
          }
        });
        
        $(this).bind("contextmenu", function(e) {
            e.preventDefault();
        });
    });
    
    function imprimir(){
        if(confirm('Confirma imprimir el formato?')){
            $.post('<?= base_url() ?>Managerbudget/C_Ppto/UpdatePrint',{tipo:<?=$tipo?>,ppto:<?=$v->id?>,status:5,ord:0,ord_id:0},function(){
                window.print();
            });
        }
    }
</script>
</html>
</div>
<?php endforeach; ?>