<script src="<?=base_url()?>dist/jquery/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>dist/JsBarcode/dist/JsBarcode.all.min.js"></script>
<?php
$consecutivePad = str_pad($consecutive, 5, "0", STR_PAD_LEFT);
$date = explode('-', $fecha);
?>
<div style="margin-top: -12px;margin-left:-3px;width: 127px;height:80px ;border: 1px solid #f5f5f5;text-align: center">
    <h6 style="margin-top: 1px;margin-bottom: 16px;text-align: center;height: 0px;">Sonovista Publicidad SA</h6>
    <div style="margin-left: auto;margin-right: auto; width: 110px;text-align: center"><svg id="barcode"></svg></div>
    <span style="font-size: 9px;text-align: left;font-weight: 600;">Fecha: <?=$fecha?></span>
    <span style="display: block; font-size: 9px;text-align: center;font-weight: 600;">Cons: <span style="font-size: 11px;"><?=$consecutivePad?></span></span>
    <span style="font-size: 11px;text-align: left;font-weight: 600;">Recibido, No implica aceptación.</span>
</div>

<script>
    $(function(){
        JsBarcode("#barcode", "<?=$date[0]?>-<?=$consecutivePad;?>", {
            width: 0.8,
            height: 20,
            fontSize:0,
            margin:0
        });
    });
</script>