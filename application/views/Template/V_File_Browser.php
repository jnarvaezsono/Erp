<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Sonoffice</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link  rel = "icono de acceso directo"  href = "<?= base_url() ?>dist/img/favicon.ico"  type = "image / x-icon" > 
        <link  rel = "icon"  href = "<?= base_url() ?>dist/img/favicon.ico"  type = "image / x-icon" >
        <link rel="stylesheet" href="<?= base_url() ?>dist/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= base_url() ?>dist/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?= base_url() ?>dist/Ionicons/css/ionicons.min.css">

        <link rel="stylesheet" href="<?= base_url() ?>dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="<?= base_url() ?>dist/css/custom.css">
        <link rel="stylesheet" href="<?= base_url() ?>dist/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <script src="<?= base_url() ?>dist/jquery/jquery.js"></script>
        <script src="<?= base_url() ?>dist/ckeditor/ckeditor.js"></script>
        <style>
        </style>
        <script>
            $(function () {
                var funcNum = <?= $_GET['CKEditorFuncNum'] . ';'; ?>;
                $('#fileExplorer').on('click', 'img', function () {
                    var fileUrl = "<?= base_url() ?>" + $(this).attr('title');
                    window.opener.CKEDITOR.tools.callFunction(funcNum, fileUrl);
                    window.close();
                }).hover(function () {
                    $(this).css('cursor', 'pointer');
                });
            });
        </script>
    </head>

    <body>
        <div id="fileExplorer">
            <div class="container">
                <div class="row">
                    <?php foreach ($fileList as $fileName) : ?>
                    <div class="col-lg-2 col-sm-2 col-xs-2"><a title="Image 1" href="#"><img style="width:60px" class="thumbnail img-responsive" src="<?= base_url() . $fileName ?>" title="<?= $fileName ?>"></a></div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </body>

</html>