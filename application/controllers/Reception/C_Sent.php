<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Sent extends Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Reception/M_Sent');
    }

    public function index() {
        $array['menus'] = $this->M_Main->ListMenu();
        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS,ALERTIFY_CSS, DATEPICKER_CSS, TIMEPICKER_CSS);
        $this->load->view('Template/V_Header', $Header);

        $data['list'] = $this->M_Sent->ListSent();
        
        $d['table'] = $this->load->view('Reception/Sent/V_Table_Sent', $data, true);
        
        $this->load->view('Reception/Sent/V_List_Sent', $d);
      
        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS,ALERTIFY_JS, DATEPICKER_JS, TIMEPICKER_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function CreateRegister(){
        $result = $this->M_Sent->CreateRegister();
        $table ="";
        if($result == "OK"){
            $data['list'] = $this->M_Sent->ListSent();
            $table = $this->load->view('Reception/Sent/V_Table_Sent', $data, true);
        }
        echo json_encode(array("res"=>$result,"tabla"=>$table));  
    }
    
    function UpdateSent(){
        $result = $this->M_Sent->UpdateSent();
        
        echo json_encode(array("res"=>$result));  
    }
    
    function AnuleUser(){
        $result = $this->M_Sent->AnuleUser();
        
        echo json_encode(array("res"=>$result));  
    }
    
    function PrintLabel($consecutive,$fecha){
        $this->load->view('Reception/Sent/V_Label', array('consecutive'=>$consecutive,'fecha'=>$fecha));
    }

}