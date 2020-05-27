<div class="content-wrapper">
    <section class="content-header">
        <h1>
            User Profile
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">User profile</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" id="img-avatar" src="<?= base_url("dist/img/" . $user->avatar) ?>" alt="User profile picture">

                        <h3 class="profile-username text-center"><?= $user->name ?></h3>

                        <p class="text-muted text-center"><?= $user->rol ?></p>
                        <?php if($user->id_status == 1): ?>
                        <a href="#" class="btn btn-danger btn-block" onclick="Changestatus(<?=$user->id_users?>,'<?=$user->name?>',2)"><b>Inactivar</b></a>
                        <?php else: ?>
                        <a href="#" class="btn btn-success btn-block" onclick="Changestatus(<?=$user->id_users?>,'<?=$user->name?>',1)"><b>Activar</b></a>
                        <?php endif; ?>
                        <a href="#" class="btn btn-primary btn-block" onclick="ResetPass(<?= $user->id_users ?>, '<?= $user->name ?>')"><b>Resetear</b></a>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">About Me</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Nombre</label>
                                    <input type="text" class="form-control" id="name" value="<?= $user->name ?>" onchange="update('name', this.value)">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Documento</label>
                                    <input type="text" class="form-control" id="cc" value="<?= $user->cc ?>" onchange="update('cc', this.value)">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Area</label>
                                    <select class="form-control" id="id_area"  onchange="update('id_area', this.value)">
                                        <?php foreach ($areas as $r) : ?>
                                            <option value="<?= $r->cat_areaid ?>" <?= ($r->cat_areaid == $user->id_area) ? 'selected' : '' ?>><?= $r->nmb_are ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group register">
                                    <label for="nombre">Usuario</label>
                                    <input type="text" name="user" class="form-control " id="user" value="<?= $user->user ?>" onchange="update('user', this.value)" placeholder="Nombres Usuario"  />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group register form-email">
                                    <label for="nombre">Correo</label>
                                    <input type="text" name="email" class="form-control" id="email" value="<?= $user->email ?>"  onchange="update('email', this.value)" placeholder="E-mail"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group register">
                                    <label for="rol">Rol</label>
                                    <select name="rol" class="form-control required" id="rol" onchange="update('rol', this.value)">
                                        <option value="">. . .</option>
                                        <?php foreach ($rol as $r) : ?>
                                            <option value="<?= $r->id_roles ?>" <?= ($r->id_roles == $user->id_roles) ? 'selected' : '' ?>><?= $r->rol ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group register">
                                    <label for="avatar"> Seleccionar Avatar</label>
                                    <select name="avatar" class="form-control required" id="avatar" onchange="validaavatar(); update('avatar', this.value);">
                                        <option value="">. . .</option>
                                        <option value="avatar2.png" <?= ('avatar2.png' == $user->avatar) ? 'selected' : '' ?>>Avatar Girl</option>
                                        <option value="avatar3.png" <?= ('avatar3.png' == $user->avatar) ? 'selected' : '' ?>>Avatar Girl</option>  
                                        <option value="avatar_girl.png" <?= ('avatar_girl.png' == $user->avatar) ? 'selected' : '' ?>>Avatar Girl</option>
                                        <option value="avatar_morena.png" <?= ('avatar_morena.png' == $user->avatar) ? 'selected' : '' ?>>Avatar Girl</option>
                                        <option value="avatar_senora.png" <?= ('avatar_senora.png' == $user->avatar) ? 'selected' : '' ?>>Avatar Girl</option>
                                        <option value="avatar.png" <?= ('avatar.png' == $user->avatar) ? 'selected' : '' ?>>Avatar Man</option>  
                                        <option value="avatar04.png" <?= ('avatar04.png' == $user->avatar) ? 'selected' : '' ?>>Avatar Man</option>
                                        <option value="avatar5.png" <?= ('avatar5.png' == $user->avatar) ? 'selected' : '' ?>>Avatar Man</option>
                                        <option value="avatar_senor_moreno.png" <?= ('avatar_senor_moreno.png' == $user->avatar) ? 'selected' : '' ?>>Avatar Man</option>
                                        <option value="avatar_barba_blanco.jpg" <?= ('avatar_barba_blanco.jpg' == $user->avatar) ? 'selected' : '' ?>>Avatar Man</option>
                                        <option value="avatar10.jpg" <?= ('avatar10.jpg' == $user->avatar) ? 'selected' : '' ?>>Avatar Man</option>
                                        <option value="avatarcalvo.jpg" <?= ('avatarcalvo.jpg' == $user->avatar) ? 'selected' : '' ?>>Avatar Man</option>
                                        <option value="avatar9.png" <?= ('avatar9.png' == $user->avatar) ? 'selected' : '' ?>>Avatar Man</option>
                                        <option value="avatar_gordo.png" <?= ('avatar_gordo.png' == $user->avatar) ? 'selected' : '' ?>>Avatar Man</option>
                                    </select>
                                </div>
                            </div> 
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
<script>

    function validaavatar() {
        var avatarpng = $("#avatar").val();
        $("#img-avatar").attr('src','<?= base_url() ?>dist/img/' + avatarpng);
    }
    
    function update(field, valor){
        $.post("<?= base_url() ?>Parameters/User/C_User/updateInfo", {id_user: <?=$user->id_users?>,field:field,valor:valor}, function (data) {
            if (data.res == "OK") {
                
                if(field == 'name'){
                    $('.profile-username').html(valor);
                }else if(field == 'rol'){
                    $('.text-muted').html($('#rol option:selected').text());
                }
                
                swal('Operacion Exitosa!', '', 'success').then((result) => {});
            } else {
                swal({title: 'Error!', text: data, type: 'error'});
            }
        }, 'json');
    }
    
    function ResetPass(id_user, titulo){
        swal({
            title: 'Esta seguro de resetear la clave del usuario ' + titulo + '!',
                    text: "",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ACEPTAR!'
            }).then((result)=>{
            if (result) {
                $.post("<?= base_url() ?>Parameters/User/C_User/ResetPass", {id_user: id_user}, function (data) {
                    if (data.res == "OK") {
                        swal('Operacion Exitosa!', '', 'success').then((result) => {});
                    } else {
                        swal({title: 'Error!', text: data, type: 'error'});
                    }
                }, 'json');
            }
        }).catch(swal.noop)
    }
    
    function Changestatus(id_user, titulo, status) {
        var txt = '';
        if(status != 1){
            var txt = 'In';
        }
        
        swal({
            title: 'Esta seguro de '+txt+'activar el Usuario ' + titulo + '!',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ACEPTAR!'
        }).then((result) => {
            if (result) {
                $.post("<?= base_url() ?>Parameters/User/C_User/Changestatus", {id_user: id_user,status:status}, function (data) {
                    if (data.res == "OK") {
                        swal('Operacion Exitosa!', 'El Usuario ha sido '+txt+'activado.', 'success').then((result) => {
                            location.reload();
                        });
                    } else {
                        swal({title: 'Error!', text: data, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            }
        }).catch(swal.noop)
    }
</script>