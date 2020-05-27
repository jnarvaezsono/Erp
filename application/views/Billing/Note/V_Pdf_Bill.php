<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title >Nota Credito <?= $nota ?></title>

        <style>
            @page { size: auto;  margin: 0mm; }
            @media print {
                body {
                    height: 21.59cm;
                    width: 27.94cm;
                    margin-left: auto;
                    margin-right: auto;
                    margin:auto;
                    /*font-family: sans-serif;*/
                    font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;
                }

                tr {
                    page-break-inside:avoid; page-break-after:auto
                }
            }
            .invoice-box {
                /* max-width: 800px;*/
                margin: auto;
                padding: 30px;
                border: 1px solid #eee;
                box-shadow: 0 0 10px rgba(0, 0, 0, .15);
                font-size: 12px;
                /*line-height: 24px;*/
                /*font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;*/
                font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;
                font-weight: 400;
                color: #555;
            }

            .invoice-box table {
                width: 100%;
                line-height: inherit;
                text-align: left;
            }

            .invoice-box table td {
                padding: 5px;
                vertical-align: top;
            }

            .invoice-box table tr td:nth-child(2) {
                text-align: right;
            }

            .invoice-box table tr.top table td {
                padding-bottom: 20px;
            }

            .invoice-box table tr.top table td.title {
                font-size: 45px;
                line-height: 45px;
                color: #333;
            }

            .invoice-box table tr.information table td {
                padding-bottom: 40px;
            }

            .invoice-box table tr.heading td {
                background: #eee;
                border-bottom: 1px solid #ddd;
                font-weight: bold;
                text-align: center;
            }

            .invoice-box table tr.details td {
                padding-bottom: 20px;
            }

            .invoice-box table tr.item td{
                border-bottom: 1px solid #eee;
                text-align: center;
            }

            .invoice-box table tr.item.last td {
                border-bottom: none;
            }

            .invoice-box table tr.total td:nth-child(2) {
                border-top: 2px solid #eee;
                font-weight: bold;
            }

            @media only screen and (max-width: 600px) {
                .invoice-box table tr.top table td {
                    width: 100%;
                    display: block;
                    text-align: center;
                }

                .invoice-box table tr.information table td {
                    width: 100%;
                    display: block;
                    text-align: center;
                }
            }

            /** RTL **/
            .rtl {
                direction: rtl;
            }

            .rtl table {
                text-align: right;
            }

            .rtl table tr td:nth-child(2) {
                text-align: left;
            }
        </style>
    </head>

    <body>
        <div class="invoice-box">
            <table cellpadding="0" cellspacing="0">
                <tr class="top">
                    <td colspan="10">
                        <table>
                            <tr>
                                <td class="title" >
                                    <img src="<?= LOGO_VERTICAL ?>" style="width:100%; max-width:300px;">
                                </td>

                                <td >
                                    Nit: 890.101.778-4<br />
                                    Cll 70 No. 53 - 74 P5<br />
                                    PBX: 356 4900<br />
                                    Barranquilla - Colombia
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="information">
                    <td colspan="10">
                        <table>
                            <tr>
                                <td>
                                    <b>Cliente</b><?= str_repeat("&nbsp;", 10); ?><?= $info->nombre ?><br>
                                    <b>Nit</b><?= str_repeat("&nbsp;", 17); ?><?= $info->documento ?><br>
                                    <b>Dirección</b><?= str_repeat("&nbsp;", 5); ?><?= $info->direccion ?><br>
                                </td>

                                <td>
                                    <b>Factura <?= $info->factura_id ?>.</b><br>
                                    <b>Nota Crédito <?= $nota ?>.</b><br>
                                    Barranquilla<br>
                                    <?= $cab->fecha ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                
            <?=$tabla?>
            </table>
            <center>
                <table cellpadding="4" width="90%" style="font-size:10pt;">
                    <tbody><tr><td style="border: none;">Observaciones: <?=$cab->observacion?></td></tr>
                    </tbody></table>
            </center>
            <?= str_repeat("<br />", 3); ?>
            <table cellpadding="4" width="100%" style="font-size:9pt;text-align: center;">
                <tbody>
                    <tr>
                        <th style="border: none;">Efectuar el <?=$info->factura_retefuente?>% de retención en la fuente sobre <?= number_format($spa, 0) ?></th>       
                    </tr>
                    <tr>
                        <th style="border: none;"><?=$letras?></th>       
                    </tr>
                </tbody>
            </table>
            <?= str_repeat("<br />", 10); ?>
            <table cellpadding="4" width="100%" style="font-size:9pt;text-align: center;">
                <tbody>
                    <tr>
                        <th style="border: none;">_____________________________________</th>
                        <th style="border: none;">_____________________________________</th>
                        <th style="border: none;">_____________________________________</th>            
                    </tr>
                    <tr>
                        <th style="border: none;">Elaborado</th>
                        <th style="border: none;">Revisado</th>
                        <th style="border: none;">Autorizado</th>            
                    </tr>
                </tbody>
            </table>
            <!--<br class="no-print"><hr class="no-print" style="border:1px dashed; width:100%;" /><br class="no-print">-->
        </div>
    </body>
</html>
