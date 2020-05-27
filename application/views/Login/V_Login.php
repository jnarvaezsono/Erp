<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login V15</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link  rel = "icono de acceso directo"  href = "<?= base_url() ?>dist/img/favicon.ico"  type = "image / x-icon" > 
        <link  rel = "icon"  href = "<?= base_url() ?>dist/img/favicon.ico"  type = "image / x-icon" >
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
                            Sign In
                        </span>
                    </div>

                    <div class="login100-form " >
                        <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
                            <span class="label-input100">Username</span>
                            <input class="input100" type="text" id="usr" placeholder="Enter username" autocomplete="new-name" >
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
                            <span class="label-input100">Password</span>
                            <input class="input100" type="password" id="psw" placeholder="Enter password" autocomplete="new-password">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="flex-sb-m w-full p-b-30">
                            <div class="contact100-form-checkbox">
                                <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                                <label class="label-checkbox100" for="ckb1">
                                    Recuerdame
                                </label>
                            </div>

                            <div>
                                <a href="#" class="txt1" onclick="$('#myModalC').modal('show')">
                                    Se te olvidó tu contraseña?
                                </a>
                            </div>
                        </div>

                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn btn-log">
                                <i class="fa fa-user"></i>&nbsp;&nbsp;&nbsp;Login
                            </button>
                        </div>
                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn btn-google">
                                <i class="fa fa-google-plus"></i>&nbsp;&nbsp;&nbsp;Google
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myModalC" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title"><strong>Recuperar tu contraseña</strong></h5>
                    </div>
                    <div class="modal-body body-form">
                        <p>Indícanos tu correo para que puedas recuperar tu contraseña</p>
                        <div class="form-group">
                            <label for="email_pss">Correo Electronico</label>
                            <input type="email" class="form-control" id="email_pss" placeholder="Email">
                            <div id="xmail" class="hide"><h6 class="text-danger">Ingresa un email valido</h6></div>
                        </div>
                        <div class="text-center">
                            <a class="btn btn-block btn-social btn-forgot">
                                <i class="fa fa-envelope"></i> Enviar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-change" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title"><strong>PASSWORD VENCIDO!</strong></h5>
                    </div>
                    <div class="modal-body body-form">
                        <p>Debes realizar el cambio de password periódico.</p>
                        <div class="form-group">
                            <label for="change1">Nuevo Password</label>
                            <input type="password" class="form-control" id="change1" >
                            <input type="hidden" class="form-control" id="id_user" >
                        </div>
                        <div class="form-group">
                            <label for="change1">Repetir</label>
                            <input type="password" class="form-control" id="change2" >
                        </div>
                        <div class="text-center">
                            <a class="btn btn-block btn-social btn-change">
                                <i class="fa fa-envelope"></i> Enviar
                            </a>
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
            validateSecurity('change1')
            $(document).keypress(function (e) {
                if (e.which == 13) {
                    Send();
                    return false;
                }
            });
            $(".btn-log").click(function () {
                Send();
            });

            $(".btn-google").click(function () {
                var url = "<?= $login_url; ?>";
                $(location).attr('href', url);
            });
            
            $(".btn-change").click(function () {
                if($("#change1").val() != $("#change2").val()){
                    alertify.error('PASSWORD NO COINCIDE');
                }else if($("#change1").val() == "" ||  $("#change2").val() == ""){
                    alertify.error('DEBE DIGITAR LOS CAMPOS');
                }else{
                    var check = true;
                    $(".li-validate").each(function(){
                        if($(this).hasClass("invalid")){
                            check = false;
                        }
                    });
                    if(check){
                        $.post("<?= base_url() ?>C_Main/Login", {usr: $("#usr").val(), psw: md5($("#psw").val()), pswnew: md5($("#change1").val())}, function (data) {
                            if (data.res == "OK") {
                                location.href = "C_Panel";
                            } else {
                                swal({title: 'Error!', text: data.res, type: 'error'});
                            }
                        }, 'json').fail(function (error) {
                            swal({title: 'La url solicitada no existe para ingresar haz click en el enlace <a href="<?= URL_PROJETC ?>">Sonoffice</a>!', text: error.responseText, type: 'error'});
                        });
                    }else{
                        swal({title: 'Error!', text: "El password no cumple con las reglas minimas de seguridad", type: 'error'});
                    }
                }
            });
            
            $(".btn-forgot").click(function () {
                if(ValidateEmail($("#email_pss").val())){
                    $('#myModalC').modal('hide');
                    $.post("<?= base_url()?>C_Main/ForgotToPassword",{email:$("#email_pss").val()},function(data){
                        $("#email_pss").val("");
                        if(data == "OK"){
                            swal({title: '', text: "Se ha enviado un link a la cuenta para recuperar la contraseña", type: 'success'});
                        }else if(data == "EMPTY"){
                            swal({title: '', text: "Email Invalido", type: 'error'});
                        }else{
                            swal({title: 'Error!', text: data, type: 'error'});
                        }
                    });
                }else{
                    alertify.error("EMAIL INVALIDO");
                }
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

            $('.input100').each(function () {
                $(this).focus(function () {
                    hideValidate(this);
                });
            });

            var check = true;

            for (var i = 0; i < input.length; i++) {
                if (validate(input[i]) == false) {
                    showValidate(input[i]);
                    check = false;
                }
            }

            if (check) {
                $.post("<?= base_url() ?>C_Main/Login", {usr: $("#usr").val(), psw: md5($("#psw").val())}, function (data) {
                    if (data.res == "OK") {
                        location.href = "OP/C_Control";
                    } else if (data.res == "ERROR") {
                        swal({title: 'Error!', text: "Usuario o password incorrecto", type: 'error'});
                    }else if(data.res == "CHANGE"){
                        $("#modal-change").modal("show");
                    }else if(data.res == "LOCKED"){
                        swal({title: 'Usuario bloqueado!', text: 'Comunicate con sistemas', type: 'error'});
                    } else {
                        swal({title: 'Error!', text: data.res, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'La url solicitada no existe para ingresar haz click en el enlace <a href="<?= URL_PROJETC ?>">Sonoffice</a>!', text: error.responseText, type: 'error'});
                });
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