<div class="modal fade" id="modal-task">
    <div class="modal-dialog" style="width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-fw fa-tasks"></i> Adjunto</h4>
            </div>
            <div class="modal-body">
                <div class="tab-pane" id="tab_2">
                    <form class="fileupload"  id="upload_documento" method="POST" enctype="multipart/form-data">
                        <!-- Redirect browsers with JavaScript disabled to the origin page -->
                        <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
                        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                        <div class="row fileupload-buttonbar">
                            <div class="col-md-4">
                                <div class="col-md-6">
                                    <!-- The fileinput-button span is used to style the file input field as button -->
                                    <span class="btn btn-default fileinput-button">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span>Agregar</span>
                                        <input type="file" name="files" multiple>
                                    </span>
                                    </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-default start">
                                        <i class="glyphicon glyphicon-upload"></i>
                                        <span>Subir todo</span>
                                    </button>
                                </div>

                            </div>
                            <div class="col-md-6 fileupload-progress fade">
                                <!-- The global progress bar -->
                                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                </div>
                                <!-- The extended global progress state -->
                                <div class="progress-extended">&nbsp;</div>
                            </div>
                        </div>
                        <!-- The table listing the files available for upload/download -->
                        <table role="presentation" id="table-adjuntos" class="table table-striped"><tbody class="files"></tbody></table>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save-task" data-dismiss="modal">OK</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
    <td>
    <span class="preview"></span>
    </td>
    <td>
    <p class="name">{%=file.name%}</p>
    <strong class="error text-danger"></strong>
    </td>
    <td>
    <p class="size">Subiendo...</p>
    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
    </td>
    <td>
    {% if (!i && !o.options.autoUpload) { %}
    <button class="btn btn-primary start" disabled>
    <i class="glyphicon glyphicon-upload"></i>
    <span>Subir</span>
    </button>
    {% } %}
    {% if (!i) { %}
    <button class="btn btn-warning cancel">
    <i class="glyphicon glyphicon-ban-circle"></i>
    <span>Cancelar</span>
    </button>
    {% } %}
    </td>
    </tr>
    {% } %}
</script>
<!-- The template to display files available for download   //{% $("#table-adjuntos > tbody").html(""); %}  {% $("#modal-task").modal('hide');; %} -->
<script id="template-download" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
    <td>
    <span class="preview">
    {% if (file.thumbnailUrl) { %}
    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
    {% } %}
    </span>
    </td>
    <td>
    <p class="name">
    {% if (file.url) { %}
    <a href="{%=file.url%}" target='_blank' title="{%=file.name%}">{%=file.name%}</a>
    {% } else { %}
    <span>{%=file.name%}</span>
    {% } %}
    </p>
    {% if (file.error) { %}
    <div><span class="label label-danger">Error</span> {%=file.error%}</div>
    {% } %}
    </td>
    <td>
    <span class="size">{%=o.formatFileSize(file.size)%}</span>
    </td>
    <td>
    {% if (file.deleteUrl) { %}

    {% var comment = '<li class="time-label">'; %}
    {% comment += '<span class="bg-red">'+ShowDateJS()+'</span>'; %}
    {% comment += '</li>'; %}
    {% comment += '<li>'; %}
    {% comment += '<i class="fa fa-paperclip bg-yellow"></i>'; %}
    {% comment += '<div class="timeline-item">'; %}
    {% comment += '<span class="time"><i class="fa fa-clock-o"></i> Ahora </span>'; %}

    {% comment += '<h3 class="timeline-header"><a href="#" class="img-header"><?=$this->session->NameUser?>...<img class="img-circle img-sm" src="<?= base_url() ?>/dist/img/<?=$this->session->Avatar?>" alt="User Image"></a></h3>'; %}

    {% comment += '<div class="timeline-body">'; %}
    
    {% var arreglo = file.name.split('.'); %}
    {% if(arreglo[1] == 'pdf'){ %}
        {% comment += '<img src="<?= base_url() ?>/dist/img/pdf.png" alt="..." class="margin" style="max-width:100px"><br />'; %}
    {% }else if(arreglo[1] == 'doc' || arreglo[1] == 'docx'){ %}
        {% comment += '<img src="<?= base_url() ?>/dist/img/word.png" alt="..." class="margin" style="max-width:100px"><br />'; %}
    {% }else if(arreglo[1] == 'pptx'){ %}
        {% comment += '<img src="<?= base_url() ?>/dist/img/pptx.png" alt="..." class="margin" style="max-width:100px"><br />'; %}
    {% }else if(arreglo[1] == 'xls' || arreglo[1] == 'xlsx'){ %}
        {% comment += '<img src="<?= base_url() ?>/dist/img/excel.png" alt="..." class="margin" style="max-width:100px"><br />'; %}
    {% }else{ %}
        {% comment += '<img src="' + file.url + '" alt="..." class="margin" style="max-width:100px"><br />'; %}
    {% } %}
    
    {% comment += '<a download="' + file.name + '" href="' + file.url + '" target="_blank"><i class="fa fa-paperclip"></i> ' + file.name + '</a>'; %}
    {% comment += '</div>'; %}
    {% comment += '</div>'; %}
    
    {% comment += '</li>'; %}
    
    {% $(".timeline").prepend(comment); %}
    
    
    

    {% } else { %}
    <button class="btn btn-warning cancel">
    <i class="glyphicon glyphicon-ban-circle"></i>
    <span>Cancelar</span>
    </button>
    {% } %}
    </td>
    </tr>
    {% } %}
</script>