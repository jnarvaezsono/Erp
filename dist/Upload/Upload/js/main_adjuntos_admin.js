/*
 * jQuery File Upload Plugin JS Example
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/* global $, window */

function cargar_adjuntos(){
    'use strict';
    console.log(123);
var id_cliente=$('#id_cliente').val();
    // Initialize the jQuery File Upload widget:
    $('#upload_documento').fileupload({
        url: 'https://dameplata.com/Adm_51218/Clientes/subir_adjunto',
            formData: {tipo: 'documento',id_cliente:id_cliente}
    });
    $('#upload_otros').fileupload({
        url: 'https://dameplata.com/Adm_51218/Clientes/subir_adjunto',
        formData: {tipo: 'otros',id_cliente:id_cliente}
    });
    $('#upload_volante_pago').fileupload({
        url: 'https://dameplata.com/Adm_51218/Clientes/subir_adjunto',
        formData: {tipo: 'volante_pago',id_cliente:id_cliente}
    });
    $('#upload_declaracion_renta').fileupload({
        url: 'https://dameplata.com/Adm_51218/Clientes/subir_adjunto',
        formData: {tipo: 'declaracion_renta',id_cliente:id_cliente}
    });
    $('#upload_certificado_ingresos').fileupload({
        url: 'https://dameplata.com/Adm_51218/Clientes/subir_adjunto',
        formData: {tipo: 'certificado_ingresos',id_cliente:id_cliente}
    });
    $('#upload_certificado_camara').fileupload({
        url: 'https://dameplata.com/Adm_51218/Clientes/subir_adjunto',
        formData: {tipo: 'certificado_camara',id_cliente:id_cliente}
    });

//    // Enable iframe cross-domain access via redirect option:
//    $('.fileupload').fileupload(
//        'option',
//        'redirect',
//        window.location.href.replace(
//            /\/[^\/]*$/,
//            '/cors/result.html?%s'
//        )
//    );

    if (window.location.hostname === 'blueimp.github.io') {
        // Demo settings:
        $('.fileupload').fileupload('option', {
            url: '//jquery-file-upload.appspot.com/',
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
            maxFileSize: 999000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png|pdf)$/i
        });
        // Upload server status check for browsers with CORS support:
        if ($.support.cors) {
            $.ajax({
                url: '//jquery-file-upload.appspot.com/',
                type: 'HEAD'
            }).fail(function () {
                $('<div class="alert alert-danger"/>')
                    .text('Upload server currently unavailable - ' +
                            new Date())
                    .appendTo('.fileupload');
            });
        }
    } else {
          $('.fileupload').each(function(index,x){
              var id=$(x).attr('id').substring(7, 50);
               $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url:'https://dameplata.com/Adm_51218/Clientes/cargar_adjuntos',
            dataType: 'json',
            data:{'tipo':id,id_cliente:id_cliente},
            context: $(x)
        }).always(function () {
            $(this).removeClass('fileupload-processing');
        }).done(function (result) {
            
            $(this).fileupload('option', 'done')
                .call(this, $.Event('done'), {result: result});
        });
          });
    }
}