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
        
//        $data['clientes'] = $this->M_Client->ListClientAll();
        $data['type'] = 'Cliente';
//        $data['table'] = $this->load->view('Parameters/Client/V_Table_Client',$data,true);
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
        
//        $data['clientes'] = $this->M_Client->ListProveedortAll();
        $data['type'] = 'Proveedor';
//        $data['table'] = $this->load->view('Parameters/Client/V_Table_Client',$data,true);
        $this->load->view('Parameters/Client/V_List_Client',$data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, ICHECK_JS, SELECT2_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function GetListTable($tipo) {
        $rows = $this->M_Client->GetPptoCompleteInfo($this->input->get('start'), $this->input->get("length"), $tipo);
        $rows2 = $this->M_Client->GetPptoCompleteInfo(false, false, $tipo);

        $array = array();
        foreach ($rows['result'] as $v) {

            $btn = '<div class="btn-group btnI' . $v->id_client . '" >
                        <button  type="button" class="btn1-' . $v->id_client . ' btn btn-' . $v->color . ' btn-xs btn-left">' . $v->description . '</button>
                            <button type="button" class="btn2-' . $v->id_client . ' btn btn-' . $v->color . ' btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';

            $btn .= '<ul class="dropdown-menu u-' . $v->id_client . '" role="menu">';
            $btn .= '<li onclick="Update(' . $v->id_client . ')"><a href="#"><i class="fa fa-fw fa-edit" ></i> Editar</a></li>';
            $btn .= '<li onclick="Delete(' . $v->id_client . ',\''.$v->nombre.'\')"><a href="#"><i class="fa fa-fw fa-trash" ></i> Eliminar</a></li>';
            if($tipo == 'Cliente'):
                $btn .= '<li onclick="addmore(1,' . $v->id_client . ')"><a href="#"><i class="fa fa-fw fa-plus" ></i> Add Camapaña</a></li>';
                $btn .= '<li onclick="addmore(2,' . $v->id_client . ')"><a href="#"><i class="fa fa-fw fa-plus" ></i> Add Producto</a></li>';
            endif;
            $btn .= '</ul></div>';


            $array[] = array($v->nombre, $v->documento, $v->ciudad, $v->direccion, $v->telefono, $btn);
        }

        echo json_encode(array('draw' => $this->input->get("draw"), 'recordsFiltered' => $rows2['num'], 'datos' => $array));
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
        
        echo json_encode(array("res"=>$result));
    }
    
    function ShowCampana(){
        $data['result'] = $this->M_Client->ShowCampana();
        $table = $this->load->view('Parameters/Client/V_Modal_More',$data,true);
        echo json_encode(array("res"=>$table));
    }
    
    function ShowProducto(){
        $data['result'] = $this->M_Client->ShowProducto();
        $table = $this->load->view('Parameters/Client/V_Modal_More',$data,true);
        echo json_encode(array("res"=>$table));
    }

}
