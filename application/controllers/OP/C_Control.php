<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Control extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model('OP/M_Control');
    }

    public function index() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS);
        $this->load->view('Template/V_Header', $Header);
        
        $data['tareas'] = $this->M_Control->SelectMyTask($this->session->IdUser);
        $data['comentarios'] = $this->M_Control->SelectMyTaskComment();
        
        if(isCreator($this->session->IdRol)):
            $data['indicatorsMy'] = $this->M_Control->SelectIndicatorsTask($this->session->IdUser);
            $data['indicatorsOPMy'] = $this->M_Control->SelectIndicatorsOP($this->session->IdUser);
        endif;
        
        if (isExecutive($this->session->IdRol) || isViewTeam($this->session->IdRol)):
            $users = $this->M_Control->LoadUserTeam($this->session->IdRol);
        
            foreach ($users as $u) {
                $data['group'][$u->name]['task']['data'] = $this->M_Control->SelectIndicatorsTask($u->id_users);
                $data['group'][$u->name]['op']['data'] = $this->M_Control->SelectIndicatorsOP($u->id_users);
                $data['group'][$u->name]['id_User'] = $u->id_users;
            }
            
        endif;
        
        if (isDirGroup($this->session->IdRol) || isDirMedios($this->session->IdRol)):
            $users = $this->M_Control->LoadUserTeam($this->session->IdRol);
        
            foreach ($users as $u) {
                $data['group'][$u->name]['task']['data'] = $this->M_Control->SelectIndicatorsTask(false,$u->id_users);
                $data['group'][$u->name]['id_User'] = $u->id_users;
                if(isDirMedios($this->session->IdRol)){
                    $data['group'][$u->name]['task']['indicatorsPendiente'] = $this->M_Control->TaskPendiente($u->id_users);
                    $data['group'][$u->name]['task']['indicatorsVencida'] = $this->M_Control->TaskVencida($u->id_users);
                }
            }
            
        endif;
        
        
        if(isResponsable($this->session->IdRol)):
            $data['indicatorsRes'] = $this->M_Control->SelectIndicatorsTask(false,$this->session->IdUser);
            $data['indicatorsPendiente'] = $this->M_Control->TaskPendiente($this->session->IdUser);
            $data['indicatorsVencida'] = $this->M_Control->TaskVencida($this->session->IdUser);
        endif;
        
        $this->load->view('OP/Control/V_Control',$data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }
    

    function ShowOp(){
        $result = $this->M_Control->ShowOP($this->input->post('id_estado'),$this->session->IdUser);
        $table = 'Sin Datos';
        if($result['num']>0){
            $table = $this->load->view('OP/Control/V_Table_ControlOp', $result,TRUE);
        }
        echo json_encode(array('table'=>$table));
    }

    function ShowTask($opc = false){
        
        if($opc == 'Responsable'){
            $result = $this->M_Control->ShowTaskRes($this->input->post('id_estado'),$this->session->IdUser);
        }else{
            $result = $this->M_Control->ShowTask($this->input->post('id_estado'),$this->session->IdUser);
        }
        
        
        $table = 'Sin Datos';
        if($result['num']>0){
            $table = $this->load->view('OP/Control/V_Table_Control', $result,TRUE);
        }
        echo json_encode(array('table'=>$table));
    }

    function ShowTaskOther($opc = false){
        
        if($opc == 'Responsable'){
            $result = $this->M_Control->ShowTasOtherkRes($this->input->post('id_estado'),$this->input->post('user'));
        }else{
          //  $result = $this->M_Control->ShowTaskOther('PENDIENTE',$this->session->IdUser);
        }
        
        
        $table = 'Sin Datos';
        if($result['num']>0){
            $table = $this->load->view('OP/Control/V_Table_Control', $result,TRUE);
        }
        echo json_encode(array('table'=>$table));
    }
    
    
    function ShowTaskAllExecutive($opc = false){
        
        if($opc == 'Responsable'){
            $result = $this->M_Control->ShowTask($this->input->post('id_estado'),$this->input->post('user'));
        }else{
            //$result = $this->M_Control->ShowTask($this->input->post('id_estado'),$user);
        }
        
        
        $table = 'Sin Datos';
        if($result['num']>0){
            $table = $this->load->view('OP/Control/V_Table_Control', $result,TRUE);
        }
        echo json_encode(array('table'=>$table));
    }
    
    function ShowTaskAllDir(){
        
        $result = $this->M_Control->ShowTaskRes($this->input->post('id_estado'),$this->input->post('user'));
        
        $table = 'Sin Datos';
        if($result['num']>0){
            $table = $this->load->view('OP/Control/V_Table_Control', $result,TRUE);
        }
        echo json_encode(array('table'=>$table));
    }
    
    function ShowOpkAllExecutive(){
        $result = $this->M_Control->ShowOP($this->input->post('id_estado'),$this->input->post('user'));
        $table = 'Sin Datos';
        if($result['num']>0){
            $table = $this->load->view('OP/Control/V_Table_ControlOp', $result,TRUE);
        }
        echo json_encode(array('table'=>$table));
    }
}

