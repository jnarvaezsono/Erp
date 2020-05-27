<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_TimeClient extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model('Time/M_Time');
    }

    public function index() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(MORRIS_CSS, DATEPICKER_CSS, OTHER_RANGOPICKER_CSS, SELECT2_CSS);
        $this->load->view('Template/V_Header', $Header);
        
        $data['users'] = $this->M_Time->ListarUsuarios();
        $this->load->view('Time/V_Client',$data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(MORRIS_JS,MORRIS_JS2,DATEPICKER_JS,MOMENT, OTHER_RANGOPICKER_JS, SELECT2_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function LoadTimesClients(){
        $data = $this->M_Time->LoadTimesClients($this->input->post('periodo'));

        echo json_encode(array('clients'=>$data['rows']));
    }
    
    function LoadTimesClientsRange(){
        $result = $this->M_Time->LoadTimesClients($this->input->post('periodo'));
        
        $data = array();
        foreach ($result['rows'] as $v) {
            $old = $this->M_Time->LoadTimesClients($this->input->post('old'),$v->id_cliente);
            
            $a = 0;
            
            if($old['num'] > 0){
                $a = $old['rows']->sumtime;
            }
            
            $data[] = array('y'=>$v->nombre,'a'=>$a,'b'=>$v->sumtime);
        }
        
        echo json_encode(array('clients'=>$data));
    }
    
    
    function LoadrangeUser(){
        $result = $this->M_Time->LoadrangeUser($this->input->post('user'),$this->input->post('ini'),$this->input->post('fin'));
        
        echo json_encode(array('clients'=>$result['rows']));
    }
    
}


