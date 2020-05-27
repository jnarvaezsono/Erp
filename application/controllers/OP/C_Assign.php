<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Assign extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model("OP/M_Assign");
    }

    public function index() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, SELECT2_CSS,RANGOPICKER_CSS);
        $this->load->view('Template/V_Header', $Header);

        $clientes = $this->M_Assign->ListarClientes();

        $this->load->view('OP/Assign/V_Panel', array('clientes'=>$clientes));

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, SELECT2_JS,MOMENT,RANGOPICKER_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function ListarTasksFilter($op, $tarea, $cliente, $f_ini, $f_fin, $id_estado) {
        $rows = $this->M_Assign->ListarTask($this->input->get('start'), $this->input->get("length"), $op, $tarea, $cliente,$f_ini, $f_fin, $id_estado);
        $all = $this->M_Assign->SelectTask($op, $tarea, $cliente, $f_ini, $f_fin, $id_estado);
        $array = array();
        foreach ($rows['result'] as $v) {
            
            if(!empty($v->presupuesto)){
                $pptos = explode('-', $v->presupuesto);
            }else{
                $pptos[0] = '';
            }
            $array[] = array($v->id_op, $v->id_tarea, $v->pvcl_nombre,$v->camp_nombre,$v->fecha_creacion ,$v->fecha_cierre , mb_substr($v->descripcion, 0, 50, 'UTF-8') . "...",$v->description,$v->facturas);
        }

        echo json_encode(array('draw' => $this->input->get("draw"), 'recordsFiltered' => $all['num'], 'datos' => $array));
    }
    
    function ShowPpto(){
        $result = $this->M_Assign->ShowPpto();
        $table = 'Sin Datos';
        if($result['num']>0){
            $table = $this->load->view('OP/Assign/V_Table_Ppto', $result,TRUE);
        }
        echo json_encode(array('table'=>$table));
    }
    
    function AsignPpto(){
        $result = $this->M_Assign->AsignPpto();
        echo $result;
    }

}

