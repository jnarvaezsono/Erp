<div class="box-header with-border">
    <h3 class="box-title">Tickets</h3>

    <div class="box-tools">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
    </div>
</div>
<div class="box-body no-padding">
    <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="#"><i class="fa fa-warning"></i>Pendientes<span class="label label-primary pull-right"><?= $row->pendiente ?></span></a></li>
        <li><a href="#"><i class="fa fa-check"></i> Resueltos<span class="label label-primary pull-right"><?= $row->resuelto ?></span></a></li>
        <li><a href="#"><i class="fa fa-frown-o"></i> Sin Calificar<span class="label label-primary pull-right calificated"><?= $row->nocalificado ?></span></a></li>
        <li><a href="#"><i class="fa fa-trash-o"></i> Anulados<span class="label label-primary pull-right"><?= $row->anulado ?></span></a></li>
    </ul>
</div>
