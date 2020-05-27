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

function cargar_adjuntos(url, ids_tarea) {
    'use strict';

    $('#upload_documento').fileupload({
        url: url + 'OP/C_OP/Subir_adjunto',
        formData: {id_tarea: ids_tarea, folder: "OP"},
        maxFileSize: 50000000,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png|xls|xlsx|csv|pdf|pptx|docx|doc|pptx|zip|rar|7z|mp3|mp4)$/i
    });

}