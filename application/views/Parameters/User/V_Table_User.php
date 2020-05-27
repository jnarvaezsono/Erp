<table id="tabla_user" class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th></th>
            <th>Nombre</th>
            <th>Usuario</th>
            <th>Rol</th>
            <th>E-mail</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($user as $v) : ?>
            <tr id="user<?= $v->id_users ?>">
                <td><img style="width:30px" src="<?= base_url() ?>dist/img/<?= $v->avatar ?>" class="img-circle" alt="User Image"></td>
                <td id="name<?= $v->id_users ?>"><?= $v->name ?></td>
                <td style="text-align: center;"><?= $v->user ?></td>           
                <td style="text-align: center;"><?= $v->rol ?></td>
                <td style="text-align: center;"><?= $v->email ?></td>
                <td style="text-align: center;"><?= $v->status ?></td>           
                <td style="text-align: center;    min-width: 150px;">
                    <div class="btn-group">
                        <button type="button" class="btn btn-<?= $v->color ?>"><?= $v->status ?></button>
                        <button type="button" class="btn btn-<?= $v->color ?> dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li onclick="Update(<?=$v->id_users?>)"><a href="#">Editar</a></li>
                            <li <?=($v->id_status == 1)?'style="display:none"':'' ?> onclick="Changestatus(<?=$v->id_users?>,'<?=$v->name?>',1)"><a href="#">Activar</a></li>
                            <li <?=($v->id_status == 1)?'':'style="display:none"' ?> onclick="Changestatus(<?=$v->id_users?>,'<?=$v->name?>',2)"><a href="#">Inactivar</a></li>
                            <li class="divider"></li>
                            <li onclick="ResetPass(<?= $v->id_users ?>,'<?=$v->name?>')"><a href="#">Resetear</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
