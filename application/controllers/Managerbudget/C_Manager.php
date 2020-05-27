<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Manager extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model('Managerbudget/M_Manager');
    }

    public function GetList() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, ALERTIFY_CSS,ALERTIFY_CSS2,SELECT2_CSS,SWEETALERT_CSS);
        $this->load->view('Template/V_Header', $Header);

        $all = $this->M_Manager->SelectType('presup_avisos', 'all');
        $datos['rows'] = $this->M_Manager->ListarType($this->input->get('start'), $this->input->get("length"), 'presup_avisos', 'all');
        $tabla = $this->load->view('Managerbudget/V_Table', $datos, true);

        $type = $this->M_Manager->GetCategorias();

        $this->load->view('Managerbudget/V_Panel', array('table' => $tabla, 'all' => $all['num'], 'type' => $type));

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, ALERTIFY_JS,SELECT2_JS,SWEETALERT_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    function GetListTable($table, $id) {
        $array = array();
        $showPrint = false;
        if($table == 'orden'){
            $resultOrden = $this->M_Manager->GetOrden($id);
            
            if($resultOrden['num']>0){
                $info = $this->GetTable($resultOrden['row']->tpo_doc);
                $table = $info['table'];
                $modulo = $info['modulo'];
                $id = $resultOrden['row']->doc_id;
                $showPrint = true;
            }
        }
      
        $rows = $this->M_Manager->ListarType($this->input->get('start'), $this->input->get("length"), $table, $id);
        $all = $this->M_Manager->SelectType($table, $id);
       
        foreach ($this->M_Manager->LoadButtonPermissions("LISTPPTO") as $btn) {
            $button = $btn->name;
            $$button = $button;
        }
        
        
        foreach ($rows['result'] as $v) {
            $btn = "";
            
            //activar-anular
            if(isset($BtnActiveInactive)){
                if($v->id_status != 1){
                    $btn .= ' <span id="btn-'.$v->id.'" title="ACTIVAR" style="margin-left: 13px;" class="fa fa-unlock text-aqua" aria-hidden="true" onclick="enable(\''.$table.'\', '.$v->id.', \''.$v->field_id.'\',\''.$v->field_status.'\')"></span> ';
                }else{
                    $btn .= ' <span id="btn-'.$v->id.'" title="ANULAR" style="margin-left: 13px;" class="fa fa-lock text-red" aria-hidden="true" onclick="disable(\''.$table.'\', '.$v->id.', \''.$v->field_id.'\',\''.$v->field_status.'\')"></span></button> ';
                }
            }
            //print
            if($showPrint){
                $btn .= ' <span class="fa fa-print " onclick="OpenPrint('.$v->id.','.$modulo.',0)" title="IMPRIMIR" style="margin-left: 13px;" aria-hidden="true" onclick=""></span></button> ';
            } 
         
            
            $array[] = array($v->id, $v->category, $v->client, $v->campain, $v->date,'<small class="label label-'.$v->id.' label-'.$v->color.'">'.$v->status.'</small>', $btn);
        }

        echo json_encode(array('draw' => $this->input->get("draw"), 'recordsFiltered' => $all['num'], 'datos' => $array));
    }
    
    function GetTable($tipo){
        switch ($tipo) {
            case 'aviso':
                $table = 'presup_avisos';
                $modulo = 1;
                break;
            case 'clasificado':
                $table = 'presup_clasificados';
                $modulo = 2;
                break;
            case 'revista':
                $table = 'presup_revis';
                $modulo = 3;
                break;
            case 'radio':
                $table = 'presup_radio';
                $modulo = 4;
                break;
            case 'television':
                $table = 'presup_tv';
                $modulo = 5;
                break;
            case 'externa':
                $table = 'presup_prode';
                $modulo = 6;
                break;
            case 'interna':
                $table = 'presup_prodi';
                $modulo = 7;
                break;
            case 'publicidad_exterior':
                $table = 'publicidad_exterior';
                $modulo = 8;
                break;
            case 'impresos':
                $table = 'impresos';
                $modulo = 9;
                break;
            case 'articulos_publicitarios':
                $table = 'art_publi';
                $modulo = 10;
                break;

            default:
                $table = '';
                break;
        }
        return array('table'=>$table,'modulo'=>$modulo);
    }
    
    function EnableRow(){
        $result = $this->M_Manager->EnableRow();
        echo json_encode(array("res"=>$result));
    }
    
    function DisableRow(){
        $result = $this->M_Manager->DisableRow();
        echo json_encode(array("res"=>$result));
    }

}
