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

function cargar_adjuntos(url, id_tarea, folder, token) {
    'use strict';
    //999999 1 MB
    $(".loader_ajax2").text("Enviado Notificación");

    var sub = $('#upload_documento').fileupload({
        url: url + 'OP/C_OP/UploadFileComment',
        formData: {id_tarea: id_tarea, folder: folder, tokenkey:token},
        maxFileSize: 50000000,
//        done: function (e, data) {
//            $.each(data.files, function (index, file) {
//                console.log(file.name);
//            });
//        },
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png|xls|xlsx|csv|pdf|pptx|docx|doc|pptx|zip|rar|7z|mp3|mp4)$/i
    });
}

function cargar_cotizacion(url, id_tarea, folder, token) {
    'use strict';
    //999999 1 MB
    $(".loader_ajax2").text("Enviado Notificación");

    var sub = $('#upload_cotizacion').fileupload({
        url: url + 'OP/C_OP/UploadCotization',
        formData: {id_tarea: id_tarea, folder: folder, tokenkey:token},
        maxFileSize: 50000000,
        uploadTemplateId: 'template-upload-cot',
        downloadTemplateId: 'template-download-cot',
//        done: function (e, data) {
//            $.each(data.files, function (index, file) {
//                console.log(file.name);
//            });
//        },
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png|xls|xlsx|csv|pdf|pptx|docx|doc|pptx|zip|rar|7z|mp3|mp4)$/i
    });
}