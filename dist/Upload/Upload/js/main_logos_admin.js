
function cargar_logos(){
    'use strict';
    console.log(123);
    var id_logo = 1;
    // Initialize the jQuery File Upload widget:
    $('#upload_logo_inicio').fileupload({
        url: 'Front/subir_logo',
        formData: { tipo: 'logo_inicio', id:id_logo }
    });

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
                url:'Front/cargar_logos',
                dataType: 'json',
                data:{'tipo':id,id:id_logo},
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