<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Received extends Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Reception/M_Received');
    }

    public function index($inbox = false) {
        $array['menus'] = $this->M_Main->ListMenu();
        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, ALERTIFY_CSS, ALERTIFY_CSS2, DATEPICKER_CSS);
        $this->load->view('Template/V_Header', $Header);

        if ($inbox) {
            $data['list'] = $this->M_Received->ListReceived($this->session->IdUser);
        } else {
            $data['list'] = $this->M_Received->ListReceived();
        }
        $data['inbox'] = $inbox;
        $data['table'] = $this->load->view('Reception/Received/V_Table_Received', $data, true);

        $data['users'] = $this->M_Received->ListUsers();

        $this->load->view('Reception/Received/V_List_Received', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, ALERTIFY_JS, DATEPICKER_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    function CreateRegister() {
        $result = $this->M_Received->CreateRegister();
        $table = "";
        if ($result == "OK") {
            $data['list'] = $this->M_Received->ListReceived();
            $data['inbox'] = FALSE;
            $table = $this->load->view('Reception/Received/V_Table_Received', $data, true);
        }
        echo json_encode(array("res" => $result, "tabla" => $table));
    }

    function UpdateReceived() {
        $result = $this->M_Received->UpdateReceived();

        echo json_encode(array("res" => $result));
    }

    function ChangeStatus() {
        $result = $this->M_Received->ChangeStatus();

        echo json_encode(array("res" => $result));
    }

    function PrintLabel($id, $cons, $fecha) {
        $this->load->view('Reception/Received/V_Label', array('id' => $id, 'consecutive' => $cons, 'fecha' => $fecha));
    }

    function CreateResend() {
        $result = $this->M_Received->SelectConsecutive($this->input->post('id'));
        $data = array(
            'date_received' => $result->date_received,
            'consecutive' => $result->consecutive,
            'type' => $result->type,
            'sender' => $result->sender,
            'id_user' => $this->session->IdUser,
            'description_register' => $result->description_register,
            'company' => $result->company,
            'addressee' => $this->input->post('resend_addressee'),
            'resend_of' => $this->input->post('id'),
        );
        
        if($this->input->post('resend_format') == 'COPIA'){
            $data['copy'] = 1;
        }

        $r = $this->M_Received->InsertConsecutive($data, $this->input->post('id'), $this->input->post('resend_addressee'), $this->input->post('resend_name'), $this->input->post('resend_format'));

        echo json_encode(array('res' => $r));
    }
    
    function NewObs(){
        $data = array(
            'observation' => $this->input->post('obs'),
        );
        
        $result = $this->M_Received->Updateobs($data,$this->input->post('id'));
        echo json_encode(array('res' => $result));
    }

}
