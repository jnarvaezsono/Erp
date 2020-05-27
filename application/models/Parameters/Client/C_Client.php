<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Client extends Controller {

    public function __construct() {
    parent::__construct();
        $this->ValidateSession();
        $this->load->model("Parameters/Client/M_Client");
    }

    public function index() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, ICHECK_CSS_RED, SELECT2_CSS);
        $this->load->view('Template/V_Header', $Header);
        
        $data['clientes'] = $this->M_Client->ListClientAll();
        $data['type'] = 'Cliente';
        $data['table'] = $this->load->view('Parameters/Client/V_Table_Client',$data,true);
        $this->load->view('Parameters/Client/V_List_Client',$data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, ICHECK_JS, SELECT2_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    public function Provider() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, ICHECK_CSS_RED, SELECT2_CSS);
        $this->load->view('Template/V_Header', $Header);
        
        $data['clientes'] = $this->M_Client->ListProveedortAll();
        $data['type'] = 'Proveedor';
        $data['table'] = $this->load->view('Parameters/Client/V_Table_Client',$data,true);
        $this->load->view('Parameters/Client/V_List_Client',$data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, ICHECK_JS, SELECT2_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function NewClient(){
        $data['type'] = $this->input->post('type');
        $data['status'] = $this->M_Client->ListStatusAll();
        $data['tipos_persona'] = $this->M_Client->ListTipoPersona();
        $data['tipos_doc'] = $this->M_Client->ListTipoDocumento();
        $data['obligaciones'] = $this->M_Client->ListObligaciones();
        $data['departamentos'] = $this->M_Client->ListDepartaments();
        $data['ciudades'] = $this->M_Client->ListCitys();
        $modal = $this->load->view('Parameters/Client/V_Modal_Create',$data,true);
        
        echo json_encode(array('modalCreate'=>$modal));
    }
    
    function InfoClient(){
        $data['type'] = $this->input->post('type');
        $data['info'] = $this->M_Client->ListClientProvsAll($this->input->post('id_client'));
        $data['status'] = $this->M_Client->ListStatusAll();
        $data['tipos_persona'] = $this->M_Client->ListTipoPersona();
        $data['tipos_doc'] = $this->M_Client->ListTipoDocumento();
        $data['obligaciones'] = $this->M_Client->ListObligaciones();
        $data['departamentos'] = $this->M_Client->ListDepartaments();
        $data['ciudades'] = $this->M_Client->ListCitys();
        $modal = $this->load->view('Parameters/Client/V_Modal_Edit',$data,true);
        
        echo json_encode(array('modalEdit'=>$modal));
    }
    
    function UpdateClient(){
        $result = $this->M_Client->UpdateClient();
        $table ="";
        if($result == "OK"){
            $data['clientes'] = $this->M_Client->ListClientAll();
            $table = $this->load->view('Parameters/Client/V_Table_Client',$data,true);
        }
        echo json_encode(array("res"=>$result,"tabla"=>$table));
    }
    
    function CreateClient(){
        $result = $this->M_Client->CreateClient();
        $table ="";
        if($result == "OK"){
            $data['clientes'] = $this->M_Client->ListClientAll();
            $table = $this->load->view('Parameters/Client/V_Table_Client',$data,true);
        }
        echo json_encode(array("res"=>$result,"tabla"=>$table));
    }
    
    function DeleteClient(){
        $result = $this->M_Client->DeleteClient();
        $table ="";
        if($result == "OK"){
            $data['clientes'] = $this->M_Client->ListClientAll();
            $table = $this->load->view('Parameters/Client/V_Table_Client',$data,true);
        }
        echo json_encode(array("res"=>$result,"tabla"=>$table));
    }

}
