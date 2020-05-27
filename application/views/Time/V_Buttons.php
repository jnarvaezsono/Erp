<a class="btn btn-app" onclick="AddDetail(<?=$this->input->post('id_time')?>,'<?=$this->input->post('fecha')?>')">
    <i class="fa fa-plus"></i> Acción
</a>
<a class="btn btn-app" onclick="EditDetail(<?=$this->input->post('id_time')?>,'<?=$this->input->post('fecha')?>')">
    <i class="fa fa-edit"></i> Editar
</a>
<a class="btn btn-app" onclick="RemoveDetail(<?=$this->input->post('id_time')?>,'<?=$this->input->post('fecha')?>')">
    <i class="fa fa-trash"></i> Eliminar
</a>