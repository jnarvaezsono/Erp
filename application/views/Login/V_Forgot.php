<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login V15</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
        <link rel="stylesheet" href="<?= base_url() ?>dist/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= base_url() ?>dist/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?= base_url() ?>dist/Ionicons/css/ionicons.min.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>dist/css/util.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>dist/css/main.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>dist/<?= SWEETALERT_CSS ?>">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>dist/<?= ALERTIFY_CSS ?>">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>dist/<?= ALERTIFY_CSS2 ?>">
    </head>
    <body>
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100">
                    <div class="login100-form-title" style="background-image: url(<?= base_url() ?>dist/img/bg-01.jpg);">
                        <span class="login100-form-title-1">
                            CAMBIAR CONTRASEÑA
                        </span>
                    </div>

                    <div class="login100-form " >
                        <div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
                            <span class="label-input100">Password</span>
                            <input class="input100" type="password" id="psw" placeholder="Enter password" autocomplete="new-password">
                            <span class="focus-input100"></span>
                        </div>
                        <div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
                            <span class="label-input100">Repetir</span>
                            <input class="input100" type="password" id="psw2" placeholder="Enter password" autocomplete="new-password">
                            <span class="focus-input100"></span>
                        </div>
                        <div id="pswd_info">
                            <ul>
                                <li id="letter" class="li-validate invalid">Al menos <strong>Una letra</strong></li>
                                <li id="capital" class="li-validate invalid">Al menos <strong>Una mayúscula</strong></li>
                                <li id="number" class="li-validate invalid">Al menos <strong>Un numero</strong></li>
                                <li id="caracter" class="li-validate invalid">Al menos <strong>Un Caracter Esp</strong></li>
                                <li id="length" class="li-validate invalid">Al menos <strong>8 Caracteres</strong></li>
                            </ul>
                        </div>
                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn btn-log">
                                <i class="fa fa-user"></i>&nbsp;&nbsp;&nbsp;CAMBIAR
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="overlay_ajax"><div class="loader_ajax loader_ajax2"></div><i class="loader_ajax fa fa-refresh fa-spin fa-2x"></i></div>
    </body>
    <script src="<?= base_url() ?>dist/jquery/jquery.js"></script>
    <script src="<?= base_url() ?>dist/js/function.js"></script>
    <script src="<?= base_url() ?>dist/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>dist/<?= SWEETALERT_JS ?>"></script>
    <script src="<?= base_url() ?>dist/<?= ALERTIFY_JS ?>"></script>
    <script src="<?= base_url() ?>dist/md5/js/md5.js"></script>
    <script>

        var input = $('.validate-input .input100');

        $(function () {
            
            validateSecurity('psw');
            
            $(document).keypress(function (e) {
                if (e.which == 13) {
                    Send();
                    return false;
                }
            });
            $(".btn-log").click(function () {
                Send();
            });

            $('.input100').each(function () {
                $(this).on('blur', function () {
                    if ($(this).val().trim() != "") {
                        $(this).addClass('has-val');
                    } else {
                        $(this).removeClass('has-val');
                    }
                })
            });
            
        });

        function Send() {
            
            var check = true;
            
            if($("#psw").val() == "" ||  $("#psw2").val() == ""){
                alertify.error('DEBE DIGITAR LOS CAMPOS');
                return false;
            }            
            
            if($("#psw").val() != $("#psw2").val()){
                alertify.error('PASSWORD NO COINCIDE');
                return false;
            }
                    
            $(".li-validate").each(function(){
                if($(this).hasClass("invalid")){
                    check = false;
                }
            });
            
            if (check) {
                $.post("<?= base_url() ?>C_Main/ChangePassword", {psw: md5($("#psw").val()),id: <?=$id?>}, function (data) {
                    if (data.res == "OK") {
                        location.href = "<?= base_url()?>C_Panel";
                    } else if (data.res == "ERROR") {
                        swal({title: 'Error!', text: "Usuario o password incorrecto", type: 'error'});
                    } else {
                        swal({title: 'Error!', text: data, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'La url solicitada no existe para ingresar haz click en el enlace <a href="<?= URL_PROJETC ?>">Sonoffice</a>!', text: error.responseText, type: 'error'});
                });
            }else{
                swal({title: 'Error!', text: "El password no cumple con las reglas minimas de seguridad", type: 'error'});
            }
        }

        function validate(input) {
            if ($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
                if ($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                    return false;
                }
            } else {
                if ($(input).val().trim() == '') {
                    return false;
                }
            }
        }

        function showValidate(input) {
            var thisAlert = $(input).parent();

            $(thisAlert).addClass('alert-validate');
        }

        function hideValidate(input) {
            var thisAlert = $(input).parent();

            $(thisAlert).removeClass('alert-validate');
        }
    </script>
</html>