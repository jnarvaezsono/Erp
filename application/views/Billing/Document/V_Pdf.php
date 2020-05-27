<!DOCTYPE html>
<?php 
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
        <title>Documento Equivalente</title>
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
            <h1><b>DOCUMENTO EQUIVALENTE No. <?=$v->id?></b></h1>
            <table id="head"  >
                <tr>
                    <td class="th-cab">CIUDAD</td><td class="td-cab">BARRANQUILLA</td>
                    <td class="th-cab">FECHA </td><td class="td-cab"><?=$v->fecha?></td>
                </tr>
                <tr>
                    <td class="th-cab">PROVEEDOR</td><td class="td-cab"><?=$v->cliente?></td>
                    <td class="th-cab">NIT </td><td class="td-cab"><?=$v->documento?></td>
                </tr>
            </table>
        </header>
        <main>
            <table id="detail" >
                <tbody>
                    <tr>
                        <td style="width: 10%;font-weight: bold;text-align: center;">ITEM</td>
                        <td style="width: 50%;font-weight: bold;text-align: center;">DESCRIPCION</td>
                        <td style="width: 20%;font-weight: bold;">VALOR UNITARIO</td>
                        <td style="width: 20%;font-weight: bold;">VALOR TOTAL</td>
                    </tr>
                    <tr>
                        <td style="width: 10%;text-align: center;">1</td>
                        <td style="width: 50%;text-align: left;"><?= str_replace('|', '<br />', $v->detalle)  ?></td>
                        <td style="width: 20%;">$ <?= number_format($v->valor,0,',','.'); ?></td>
                        <td style="width: 20%;">$ <?= number_format($v->valor,0,',','.'); ?></td>
                    </tr>
                </tbody>
            </table>
            <table id="aviso" style="page-break-inside:avoid; " >
                <tbody>
                    <tr>
                        <td class="grand total" style="width:85%">TOTAL</td>
                        <td class="grand total">$<?=number_format($v->valor,0,"",".")?></td>
                    </tr>
                </tbody>
            </table>
            <br/>
            
            <table style="width: 100%;font-size: 11px; color:#252424;    margin-top: 40px;" style="page-break-inside:avoid; "> 
                <tr>
                    <td style="width: 33.3%; text-align: center; font-weight: bold; font-style: italic;"></td>
                </tr>
                <tr>
                    <td style="width: 33.3%; text-align: center; font-weight: bold;font-style:italic"></td><td style="width: 33.3%; text-align: center"></td><td style="width: 33.3%; text-align: center"></td>
                </tr>
                <tr> 
                    <td style="width: 50%; text-align: center">__________________________ </td> <td style="width: 50%; text-align: center">__________________________</td>
                </tr>
                <tr> 
                    <td style="width: 50%; text-align: center">FIRMA DEL PROVEEDOR </td>  <td style="width: 50%; text-align: center">AUTORIZADO</td>
                </tr>
                
            </table>
            <br /><br /><br />
            <div id="notices" style="page-break-inside:avoid; text-align: center">
                <h4>Calle 70- No 53-74 Piso 5 Barranquilla Colombia</h4>
                <h4>Tels 35649000</h4>
            </div>
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
            $.post('<?= base_url() ?>Billing/C_Document/UpdatePrint',{id:<?=$v->id?>,status:5},function(){
                window.print();
            });
        }
    }
    
    function imprimirPrevia(){
        window.print();
    }
</script>
</html>
</div>
<?php endforeach; ?>