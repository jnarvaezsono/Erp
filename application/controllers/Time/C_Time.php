<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Time extends Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->has_userdata('IdUser')) {
            header('Location: ' . base_url());
            return false;
        }
        $this->load->model('Time/M_Time');
    }

    public function index() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS);
        $this->load->view('Template/V_Header', $Header);
        
        $this->load->view('Template/V_Plantilla');

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    public function MyTimes() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(ALERTIFY_CSS, ALERTIFY_CSS2, TIMEPICKER_CSS, ICHECK_CSS_RED, SELECT2_CSS, SWEETALERT_CSS);
        $this->load->view('Template/V_Header', $Header);
        
        $data['times'] = $this->M_Time->LoadTimesCab($this->session->IdUser,40);
        $data['task'] = $this->M_Time->LoadMyTask($this->session->IdUser);
        $data['clients'] = $this->M_Time->ListarClientesNew(false,true,true);
        $this->load->view('Time/V_Panel',$data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(ALERTIFY_JS, TIMEPICKER_JS, ICHECK_JS, SELECT2_JS, SWEETALERT_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function ShowDetail(){
        $data['detail'] = $this->M_Time->DetailTimeSheet($this->input->post('id_time'));
        
        $response['button'] = $this->load->view('Time/V_Buttons',null, true);
        $response['table'] = $this->load->view('Time/V_Table_Detail',$data, true);
     
        echo json_encode($response);
    }
    
    function GenerateTimesheets($month_ini ,$year, $rol){
        
        $resulUsers = $this->M_Time->ListarUsuarios(false,false,false,$rol);
        
        $NotWorking = $this->M_Time->LoadDayNotWorking();

        $all_Day = array();
        for ($mes = $month_ini; $mes <= 12; $mes++) {
            $days = $this->getDiasHabiles($mes, $year,$NotWorking, false, false,true);
            foreach($days as $d){
                $all_Day[] = $d;
            }
        }
        
        $insert = array();
        foreach ($resulUsers as $user) {
            foreach ($all_Day as $day) {
                $insert[] = array('fecha'=>$day['fecha'],'num'=>$day['num'],'id_users'=>$user->id_users, 'festivo'=>$day['festivo']);
            }
        }
        $this->M_Time->CreateTimes($insert);
    }
    
    function LoadDetail(){
        $data['detail'] = $this->M_Time->DetailTimeSheet($this->input->post('id_time'),$this->input->post('detail'));
        echo json_encode($data);
    }
    
    function Save(){
        
        $this->db->trans_begin();
        
        $op = $this->input->post('option');
        $detail = $this->input->post('detail');
        
        unset($_POST['option']);
        unset($_POST['detail']);
        
        if($op == 'create'){
            $result = $this->M_Time->SaveData('sys_timesheet_detail',$_POST);
        }else if($op == 'delete'){
            $result = $this->M_Time->RemoveData('sys_timesheet_detail','id_time_detail',$detail);
        }else if($op == 'update'){
            $result = $this->M_Time->UpdateData('sys_timesheet_detail','id_time_detail',$detail,$_POST);
        }
        
        if($result > 0){
            $response['res'] = 'OK';
            $data['detail'] = $this->M_Time->DetailTimeSheet($this->input->post('id_time'));
            $response['table'] = $this->load->view('Time/V_Table_Detail',$data, true);
        }else{
            $response['res'] = 'error';
        }
        
        $response['sw'] = $this->M_Time->validateDayFinished($this->input->post('id_time'));
        
//        $count = $this->M_Time->getCountTotal();
        
//        $response['dias'] = $count['num'];
//        $this->session->set_userdata('count_time', $count['num']);
        $response['dias'] = 0;
        $this->session->set_userdata('count_time', 0);
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        
        echo json_encode($response);
        
    }
    
}


