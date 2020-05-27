<!DOCTYPE html>
<?php 
$vlrDesc = 0;
$subTotal = 0;
$vlrIva = 0 ;
$vlrMasIva = 0;
$vlrSpa = 0;
$vlrIvaspa = 0;
?>
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
            <p style="text-align:right;"><b>FACTURA DE VENTA N&deg;</b></p>
            <button type="button" class="btn btn-block btn-primary btn-sm" onclick="imprimir()">Imprimir</button>
            
            <div id="logo">
                <img src="<?=base_url()?>dist/img/header-ordenes-sonovista1.jpg">
            </div>
            <h1>PRESUPUESTO DE PRENSA No. </h1>
            <table id="head">
                <tr>
                    <td class="th-cab">CLIENTE</td><td class="td-cab"><?=$v->cliente?></td>
                    <td class="th-cab" style="width:112px">N&deg; ORDEN PROVEEDOR</td><td><?=$orden->ord_id?></td>
                </tr>
                <tr>
                    <td class="th-cab">NIT</td><td class="td-cab"><?=$v->nit_proveedor?></td>
                    <td class="th-cab">CLIENTE</td><td class="td-cab"><?=$v->cliente?></td>
                </tr>
                <tr><td class="th-cab">PRODUCTO</td><td class="td-cab"><?=$v->producto?></td><td class="th-cab">FECHA</td><td><?=$v->fecha?></td></tr>
                <tr><td class="th-cab">CAMPAÑA</td><td class="td-cab"><?=$v->campana?></td></tr>
                
            </table>
        </header>
        <main>
            <table id="aviso" >
                <tbody>
                    
                </tbody>
            </table>
            <table id="aviso" style="page-break-inside:avoid; " >
                <tbody>
                    <tr style="border-top: 1px solid #C1CED9;">
                        <td colspan="5">Valor</td>
                        <td class="total" style="width: 96px;">$ </td>
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
                    <?php if($printOrder == 0): ?>
                    <tr>
                        <td colspan="5">Subtotal</td>
                        <td class="total">$<?=number_format($vlrMasIva,0,"",".")?></td>
                    </tr>
                    <tr>
                        <td colspan="5">SPA <?=$v->porcentaje_spa?>%</td>
                        <td class="total">$<?=number_format($vlrSpa,0,"",".")?></td>
                    </tr>
                    <tr>
                        <td colspan="5">IVA SPA <?=$v->porcentaje_iva_spa?>%</td>
                        <td class="total">$<?=number_format($vlrIvaspa,0,"",".")?></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="grand total">TOTAL</td>
                        <td class="grand total">$0</td>
                    </tr>
                    <?php else: ?>
                    <tr>
                        <td colspan="5" class="grand total">TOTAL</td>
                        <td class="grand total">$<?=number_format($vlrMasIva,0,"",".")?></td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div id="notices" style="page-break-inside:avoid; ">
                <div>Observaciones:</div>
                <div class="notice"><?=$orden->ord_observacion?></div>
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
                    <td style="width: 33.3%; text-align: center">__________________________ </td> <td style="width: 33.3%; text-align: center">__________________________</td><td style="width: 33.3%;text-align: center">__________________________</td>
                </tr>
                <tr> 
                    <td style="width: 33.3%; text-align: center">Dpto de medios </td> <td style="width: 33.3%; text-align: center">Ejecutivo de cuentas</td> <td style="width: 33.3%; text-align: center">Cliente aprobaci&oacute;n</td>
                </tr>
                
                
            </table>
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
            $.post('<?= base_url() ?>Managerbudget/C_Ppto/UpdatePrint',{tipo:<?=$tipo?>,ppto:<?=$v->id?>,status:5,ord:<?=$printOrder?>,ord_id:<?=$orden->ord_id?>},function(){
                window.print();
            });
        }
    }
    
    function imprimirPrevia(){
        window.print();
    }
</script>
</html>